<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Models\Attendance;
use App\Models\Employee;
use App\Enums\AttendanceStatus;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->get();
        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        $statuses = AttendanceStatus::cases();
        return view('admin.attendances.create', compact('employees', 'statuses'));
    }
    public function export()
    {
        return Excel::download(new AttendancesExport(), 'attendances_export.xlsx');
    }

    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();

        // Calculate total hours before creating
        if (!empty($data['clock_in']) && !empty($data['clock_out'])) {
            $attendance = new Attendance($data);
            $data['total_hours'] = $attendance->calculateTotalHours();
        }

        Attendance::create($data);

        return redirect()->route('attendances.index')->with('success', 'Attendance created successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        $statuses = AttendanceStatus::cases();
        return view('admin.attendances.edit', compact('attendance', 'employees', 'statuses'));
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $data = $request->validated();

        // Calculate total hours before updating
        if (!empty($data['clock_in']) && !empty($data['clock_out'])) {
            // Temporarily set attributes to calculate
            $attendance->fill($data);
            $data['total_hours'] = $attendance->calculateTotalHours();
        } else {
            $data['total_hours'] = null;
        }
        $attendance->update($data);

        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully.');
    }
}
