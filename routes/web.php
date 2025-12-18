<?php

use App\Http\Controllers\ClockInClockOutController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\EmployeeDashboardController;

Route::get('/', function () {
    return view('welcome');
});
//login and register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//profile of admin and employees both
Route::get('/admin-profile', [AuthController::class, 'show'])->name('admin.profile');
Route::get('/employee-profile', [AuthController::class, 'showEmployee'])->name('employee.profile');

//dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/employee-dashboard', [AuthController::class, 'employeeDashboard'])->name('employee.dashboard')->middleware('auth');

// Route::resource('roles', RoleController::class)
//role
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
//department
Route::resource('departments', DepartmentController::class)->middleware('auth');
//employee
Route::resource('employees', EmployeeController::class)->middleware('auth');
//notice
Route::resource('notices', NoticeController::class)->middleware('auth');
//event
Route::resource('events', EventController::class)->middleware('auth');
//assets
Route::resource('assets', AssetController::class)->middleware('auth');
Route::resource('asset-assignments', AssetAssignmentController::class)->middleware(['auth', 'role_verify']);
//contracts
Route::resource('contracts', ContractController::class)->middleware(['auth', 'role_verify']);
//attendance
Route::resource('attendances', AttendanceController::class)->middleware(['auth', 'role_verify']);
//for clocking and clocking out
Route::post('/attendance/clock-in', [ClockInClockOutController::class, 'clockIn'])->name('clockin');
Route::post('/attendance/clock-out', [ClockInClockOutController::class, 'clockOut'])->name('clockout');
//salary
Route::resource('payrolls', PayrollController::class)->middleware(['auth', 'role_verify']);
//leavetypes
Route::resource('leave-types', LeaveTypeController::class)->middleware(['auth', 'role_verify']);
//leave
Route::resource('leaves', LeaveController::class)->middleware(['auth', 'role_verify']);
//image uploading
Route::post('/image-upload', [ImageUploadController::class, 'upload'])->name('image.upload');
//employee dashboard
Route::get('/employee-asset', [EmployeeDashboardController::class, 'assetIndex'])->name('employee.assets.index')->middleware('auth');
Route::get('/employee-event', [EmployeeDashboardController::class, 'eventIndex'])->name('employee.events.index')->middleware('auth');
Route::get('/employee-notice', [EmployeeDashboardController::class, 'noticeIndex'])->name('employee.notices.index')->middleware('auth');
Route::get('/employee-leaves', [EmployeeDashboardController::class, 'leaveIndex'])->name('employee.leaves.index')->middleware('auth');
Route::get('/employee-attendances', [EmployeeDashboardController::class, 'attendanceIndex'])->name('employee.attendances.index')->middleware('auth');

//import try
Route::post('/users/import', [AuthController::class, 'import'])->name('users.import');
