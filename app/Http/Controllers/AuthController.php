<?php

namespace App\Http\Controllers;

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
    public function dashboard()
    {
        return view('admin.dashboards.admin_dashboard');
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
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:50|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role_id'    => $request->role_id ?? 1, 
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

