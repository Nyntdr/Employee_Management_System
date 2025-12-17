<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asset;
use App\Models\Event;
use App\Models\Leave;
use App\Models\Notice;
use App\Models\Employee;
use App\Models\Department;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use App\Models\AssetAssignment;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

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
        public function showEmployee()
    {
        return view('employee.dashboard.profile');
    }
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDepartments = Department::count();
        $totalEmployees = Employee::count();
        $totalNotices = Notice::count();
        $totalAssets = Asset::count();
        $totalEvents = Event::count();
        return view('admin.dashboards.admin_dashboard',compact('totalUsers','totalDepartments','totalEmployees','totalEvents','totalNotices','totalAssets'));
    }
    public function employeeDashboard()
    {
        $ip = Request::ip();

        $totalAssets = AssetAssignment::where('employee_id',Auth::user()->employee->employee_id)->count();
        $totalLeaves = Leave::where('employee_id',Auth::user()->employee->employee_id)->count();
        return view('employee.dashboard.dashboard',compact('totalAssets','totalLeaves','ip'));
    }
        public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Auth::user()->update(['last_login' => now()]);
            $adminRoles = [1, 2];

            if (in_array(Auth::user()->role_id, $adminRoles)) {
            return redirect()->route('dashboard');
            } else {
            return redirect()->route('employee.dashboard');
            }
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

