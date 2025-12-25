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
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $attendances = Attendance::query()->with('employee')
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['status'], 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($q) use ($search) {
                        $q->whereAny(['first_name','last_name'], 'like', "%{$search}%");
                    })
                    ->orWhereDate('date', 'like', "%{$search}%")
                    ->orWhere('clock_in', 'like', "%{$search}%")
                    ->orWhere('clock_out', 'like', "%{$search}%");
            })
            ->latest()->paginate(8);
        if ($request->ajax()) {
            return view('admin.attendances.table', compact('attendances'))->render();
        }

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
