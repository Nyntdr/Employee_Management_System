<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view ('admin.auth.login');
    }
    public function showRegister()
    {
        return view('admin.auth.register');
    }
    public function show()
    {
        return view('admin.dashboards.profile');
    }
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDepartments = Department::count();
        $totalEmployees = Employee::count();

        return view('admin.dashboards.admin_dashboard',compact('totalUsers','totalDepartments','totalEmployees'));
    }
        public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Auth::user()->update(['last_login' => now()]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'password' => 'The provided password is incorrect.',
        ])->withInput($request->except('password'));
    }
    public function register(RegisterRequest $request)
    {
       $validated = $request->validated();
        User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role_id'    => 1,
            'is_active'  => true,
        ]);
        return redirect()->route('login')
                         ->with('success', 'Registration successful! You can now log in.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}

