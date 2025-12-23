<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Event;
use App\Models\Leave;
use App\Models\Notice;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Models\AssetAssignment;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function assetIndex()
    {
        $asset_assigns = AssetAssignment::where('employee_id',Auth::user()->employee->employee_id)->get();
        return view('employee.assets.index', compact('asset_assigns'));
    }
        public function eventIndex()
    {
        $events=Event::latest()->get();
        return view('employee.events.index', compact('events'));
    }
        public function noticeIndex()
    {
        $notices=Notice::latest()->paginate(5);
        return view('employee.notices.index', compact('notices'));
    }
        public function leaveIndex()
    {
        $leaves=Leave::where('employee_id',Auth::user()->employee->employee_id)->get();
        return view('employee.leaves.index', compact('leaves'));
    }
        public function attendanceIndex()
    {
        $attendances=Attendance::where('employee_id',Auth::user()->employee->employee_id)->orderBy('date', 'desc')->get();
        return view('employee.attendances.index', compact('attendances'));
    }
    public function salaryIndex()
    {
        $payrolls=Payroll::where('employee_id',Auth::user()->employee->employee_id)->orderBy('month_year', 'desc')->get();
        return view('employee.salaries.index', compact('payrolls'));
    }
}
