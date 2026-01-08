<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Imports\AttendanceImport;
use App\Models\Attendance;
use App\Models\Employee;
use App\Enums\AttendanceStatus;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'contracts_index_' . md5($search . '_page_' . $page);
        $attendances = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Attendance::query()->with('employee')
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['status'], 'like', "%{$search}%")
                            ->orWhereHas('employee', function ($q) use ($search) {
                                $q->whereAny(['first_name', 'last_name'], 'like', "%{$search}%");
                            })
                            ->orWhereDate('date', 'like', "%{$search}%")
                            ->orWhere('clock_in', 'like', "%{$search}%")
                            ->orWhere('clock_out', 'like', "%{$search}%");
                    })
                    ->orderBy('date', 'desc')->paginate(8);
            }
        );
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new AttendanceImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Attendance records imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['clock_in']) && !empty($data['clock_out'])) {
            $clockIn = Carbon::parse($data['clock_in']);
            $clockOut = Carbon::parse($data['clock_out']);
            $data['total_hours'] = $clockIn->diffInHours($clockOut);
        }

        if (!empty($data['clock_in']) && empty($data['status'])) {
            $clockInTime = Carbon::parse($data['clock_in']);
            $nineThirty = Carbon::createFromTime(9, 30, 0);
            $tenThirty = Carbon::createFromTime(13, 30, 0);

            if ($clockInTime->lessThanOrEqualTo($nineThirty)) {
                $data['status'] = AttendanceStatus::PRESENT;
            } elseif ($clockInTime->lessThanOrEqualTo($tenThirty)) {
                $data['status'] = AttendanceStatus::LATE;
            } else {
                $data['status'] = AttendanceStatus::ABSENT;
            }
        }
        if ($data['status'] instanceof AttendanceStatus) {
            $data['status'] = $data['status']->value;
        }
        Attendance::create($data);
        Cache::flush();
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
        $data['status'] = $request->input('status');

        if (!empty($data['clock_in']) && !empty($data['clock_out'])) {
            $clockIn = Carbon::parse($data['clock_in']);
            $clockOut = Carbon::parse($data['clock_out']);
            $data['total_hours'] = $clockIn->diffInHours($clockOut);
        } else {
            $data['total_hours'] = null;
        }
        $attendance->update($data);
        Cache::flush();
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        Cache::flush();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully.');
    }
}
