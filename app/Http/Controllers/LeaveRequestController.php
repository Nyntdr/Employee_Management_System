<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Notifications\LeaveRequestNotification;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('employee.leaves.request_leave', compact( 'leaveTypes'));
    }
    public function store(LeaveRequest $request)
    {
        $validated = $request->validated();
        $leave = Leave::create([
            'employee_id' => auth()->user()->employee->employee_id,
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);
        $admins = User::whereIn('role_id', [1,2])->get();
        foreach ($admins as $admin) {
            $admin->notify(new LeaveRequestNotification($leave));
        }
        return redirect()->route('employee.leaves.index')->with('success', 'Leave request submitted.');
    }
}
