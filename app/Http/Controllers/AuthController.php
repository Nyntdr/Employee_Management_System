<?php

namespace App\Http\Controllers;

use App\Imports\UsersEmployeesImport;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new UsersEmployeesImport(), $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Employees imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function show()
    {
        return view('admin.dashboards.profile');
    }

    public function showEmployee()
    {
        return view('employee.dashboard.profile');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (! $user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();

                return redirect()->route('verification.notice')->with('status', 'verification-link-sent');
            }
            $request->session()->regenerate();
            $user->update(['last_login' => now()]);
            $adminRoles = [1, 2];
            if (in_array($user->role_id, $adminRoles)) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('employee.dashboard');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

