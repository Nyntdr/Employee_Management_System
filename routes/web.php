<?php
use App\Http\Controllers\ClockInClockOutController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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
Route::get('/departments/export', [DepartmentController::class, 'export'])->name('departments.export');
Route::resource('departments', DepartmentController::class)->middleware('auth');
//employee
Route::get('/employees/export', [EmployeeController::class, 'export'])->name('employees.export');
Route::resource('employees', EmployeeController::class)->middleware('auth');
//notice
Route::get('/notices/export', [NoticeController::class, 'export'])->name('notices.export');
Route::resource('notices', NoticeController::class)->middleware('auth');
//event
Route::get('/events/export', [EventController::class, 'export'])->name('events.export');
Route::resource('events', EventController::class)->middleware('auth');
//assets
Route::get('/assets/export', [AssetController::class, 'export'])->name('assets.export');
Route::get('/asset-assignments/export', [AssetAssignmentController::class, 'export'])->name('asset-assignments.export');
Route::resource('assets', AssetController::class)->middleware('auth');
Route::resource('asset-assignments', AssetAssignmentController::class)->middleware(['auth', 'role_verify']);
//contracts
Route::get('/contracts/export', [ContractController::class, 'export'])->name('contracts.export');
Route::resource('contracts', ContractController::class)->middleware(['auth', 'role_verify']);
//attendance
Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
Route::resource('attendances', AttendanceController::class)->middleware(['auth', 'role_verify']);
//for clocking and clocking out
Route::post('/attendance/clock-in', [ClockInClockOutController::class, 'clockIn'])->name('clockin');
Route::post('/attendance/clock-out', [ClockInClockOutController::class, 'clockOut'])->name('clockout');
//salary
Route::get('/payrolls/export', [PayrollController::class, 'export'])->name('payrolls.export');
Route::resource('payrolls', PayrollController::class)->middleware(['auth', 'role_verify']);
//leave types
Route::get('/leave-types/export', [LeaveTypeController::class, 'export'])->name('leave-types.export');
Route::resource('leave-types', LeaveTypeController::class)->middleware(['auth', 'role_verify']);
//leave
Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');
Route::resource('leaves', LeaveController::class)->middleware(['auth', 'role_verify']);
//leave request
Route::resource('leave-requests', LeaveRequestController::class)->middleware('auth');
//image uploading
Route::post('/image-upload', [ImageUploadController::class, 'upload'])->name('image.upload');
//employee dashboard
Route::get('/employee-asset', [EmployeeDashboardController::class, 'assetIndex'])->name('employee.assets.index')->middleware('auth');
Route::get('/employee-event', [EmployeeDashboardController::class, 'eventIndex'])->name('employee.events.index')->middleware('auth');
Route::get('/employee-notice', [EmployeeDashboardController::class, 'noticeIndex'])->name('employee.notices.index')->middleware('auth');
Route::get('/employee-leaves', [EmployeeDashboardController::class, 'leaveIndex'])->name('employee.leaves.index')->middleware('auth');
Route::get('/employee-attendances', [EmployeeDashboardController::class, 'attendanceIndex'])->name('employee.attendances.index')->middleware('auth');
Route::get('/employee-salaries', [EmployeeDashboardController::class, 'salaryIndex'])->name('employee.salaries.index')->middleware('auth');

//import try
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

//notification
Route::get('/notification/{id}', [NotificationController::class, 'handle'])->middleware('auth')->name('notifications.handle');

// Forgot password request form
Route::get('/forgot-password', function () {
    return view('admin.auth.forgot-password');
})->middleware('guest')->name('password.request');

// Send reset link
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Reset password form (with token)
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('admin.auth.reset-password', ['token' => $token, 'request' => $request]);
})->middleware('guest')->name('password.reset');

// Update password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new \Illuminate\Auth\Events\PasswordReset($user));
        }
    );
    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
