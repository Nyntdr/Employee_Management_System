<?php

use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\ClockInClockOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordController;
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
    return view('admin.auth.login');
});
// Guest middleware on routes for login and forgot password
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Forgot password routes
    Route::get('/forgot-password', [PasswordController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'updatePassword'])->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/departments/export', [DepartmentController::class, 'export'])->name('departments.export');
Route::get('/employees/export', [EmployeeController::class, 'export'])->name('employees.export');
Route::get('/notices/export', [NoticeController::class, 'export'])->name('notices.export');
Route::get('/events/export', [EventController::class, 'export'])->name('events.export');
Route::get('/assets/export', [AssetController::class, 'export'])->name('assets.export');
Route::get('/asset-assignments/export', [AssetAssignmentController::class, 'export'])->name('asset-assignments.export');
Route::get('/contracts/export', [ContractController::class, 'export'])->name('contracts.export');
Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
Route::get('/payrolls/export', [PayrollController::class, 'export'])->name('payrolls.export');
Route::get('/payslip/{payroll}', [PayrollController::class, 'generatePayslip'])->name('payrolls.payslip');
Route::get('/leave-types/export', [LeaveTypeController::class, 'export'])->name('leave-types.export');
Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');

//Auth and prevent-back middleware for all authenticated pages
Route::middleware(['auth', 'prevent-back'])->group(function () {
    //profile of admin and employees both
    Route::get('/admin-profile', [AuthController::class, 'show'])->name('admin.profile')->middleware('role_verify');
    Route::get('/employee-profile', [AuthController::class, 'showEmployee'])->name('employee.profile');

    //email verification
    Route::get('/email/verify', [EmailVerificationController::class, 'emailVerify'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resendEmail'])->middleware(['throttle:6,1'])->name('verification.send');

//dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard')->middleware(['verified', 'role_verify']);
    Route::get('/employee-dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard')->middleware(['verified']);

// Route::resource('roles', RoleController::class)
//role
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

//department
    Route::resource('departments', DepartmentController::class)->middleware(['role_verify']);
//employee
    Route::resource('employees', EmployeeController::class)->middleware(['role_verify']);
//notice
    Route::resource('notices', NoticeController::class)->middleware(['role_verify']);
//event
    Route::resource('events', EventController::class)->middleware(['role_verify']);
//assets
    Route::resource('assets', AssetController::class);
    Route::resource('asset-assignments', AssetAssignmentController::class)->middleware(['role_verify']);
//contracts
    Route::resource('contracts', ContractController::class)->middleware(['role_verify']);
//attendance
    Route::resource('attendances', AttendanceController::class)->middleware(['role_verify']);
    //salary
    Route::resource('payrolls', PayrollController::class)->middleware(['role_verify']);
    Route::post('/payrolls/{payroll}/send-email', [PayrollController::class, 'sendPayslipEmail'])->name('payrolls.email');
//leave types
    Route::resource('leave-types', LeaveTypeController::class)->middleware(['role_verify']);
//leave
    Route::resource('leaves', LeaveController::class)->middleware(['role_verify']);
//leave request and asset request for employee
    Route::resource('leave-requests', LeaveRequestController::class);
    Route::resource('asset-requests', AssetRequestController::class);

    //employee dashboard
    Route::get('/employee-asset', [EmployeeDashboardController::class, 'assetIndex'])->name('employee.assets.index');
    Route::get('/employee-event', [EmployeeDashboardController::class, 'eventIndex'])->name('employee.events.index');
    Route::get('/employee-notice', [EmployeeDashboardController::class, 'noticeIndex'])->name('employee.notices.index');
    Route::get('/employee-leaves', [EmployeeDashboardController::class, 'leaveIndex'])->name('employee.leaves.index');
    Route::get('/employee-attendances', [EmployeeDashboardController::class, 'attendanceIndex'])->name('employee.attendances.index');
    Route::get('/employee-salaries', [EmployeeDashboardController::class, 'salaryIndex'])->name('employee.salaries.index');

    //importing data from excel routes
    Route::post('/users/import', [AuthController::class, 'import'])->name('users.import');
    Route::post('contracts/import', [ContractController::class, 'import'])->name('contracts.import');
    Route::post('/departments/import', [DepartmentController::class, 'import'])->name('departments.import');
    Route::post('/notices/import', [NoticeController::class, 'import'])->name('notices.import');
    Route::post('/assets/import', [AssetController::class, 'import'])->name('assets.import');
    Route::post('/payrolls/import', [PayrollController::class, 'import'])->name('payrolls.import');
    Route::post('/asset-assignments/import', [AssetAssignmentController::class, 'import'])->name('asset-assignments.import');
    Route::post('/leaves/import', [LeaveController::class, 'import'])->name('leaves.import');
    Route::post('/attendances/import', [AttendanceController::class, 'import'])->name('attendances.import');
    Route::post('/events/import', [EventController::class, 'import'])->name('events.import');
    Route::post('/leave-types/import', [LeaveTypeController::class, 'import'])->name('leave-types.import');

});

//for clocking and clocking out
Route::post('/attendance/clock-in', [ClockInClockOutController::class, 'clockIn'])->name('clockin');
Route::post('/attendance/clock-out', [ClockInClockOutController::class, 'clockOut'])->name('clockout');

//image uploading route
Route::post('/image-upload', [ImageUploadController::class, 'upload'])->name('image.upload');

//notification route
Route::get('/notification/{id}', [NotificationController::class, 'handle'])->middleware('auth')->name('notifications.handle');
