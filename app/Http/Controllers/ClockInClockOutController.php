<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class ClockInClockOutController extends Controller
{
    private function verifyOfficeIp(Request $request)
    {
        if ($request->ip() !== '127.0.0.1') {
            return back()->with('error', 'You are not connected to the office network.');
        }
        return null; 
    }

    public function clockIn(Request $request)
    {
        $ipError = $this->verifyOfficeIp($request);
        if ($ipError) {
            return $ipError;
        }
        $employeeId = auth()->user()->employee->employee_id;
        $today = date('Y-m-d'); 
        $attendance = Attendance::where('employee_id', $employeeId)->where('date', $today)->first();
        if ($attendance && $attendance->clock_in) {      
            return back()->with('error', 'You have already clocked in.');
        }
        Attendance::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'date' => $today
            ],
            [
                'clock_in' => date('H:i:s'), 
                'status' => 'present'
            ]
        );
        return back()->with('success', 'Clock-in successful.');
    }

    public function clockOut(Request $request)
    {
        $ipError = $this->verifyOfficeIp($request);
        if ($ipError) {
            return $ipError;
        }
        $employeeId = auth()->user()->employee->employee_id;
        $today = date('Y-m-d');
        $attendance = Attendance::where('employee_id', $employeeId)->where('date', $today)->first();
        if (!$attendance || !$attendance->clock_in) {
            return back()->with('error', 'Clock in first.');
        }
        if ($attendance->clock_out) {
            return back()->with('error', 'Already clocked out.');
        }
        $attendance->update([
            'clock_out' => date('H:i:s')
        ]);
    
        return back()->with('success', 'Clock-out successful.');
    }
}