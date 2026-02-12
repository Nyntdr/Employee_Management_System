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
use Illuminate\Support\Facades\Cache;

class EmployeeDashboardController extends Controller
{
    public function assetIndex(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'asset_index_' . md5($search . '_page_' . $page);
        $asset_assigns = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                return AssetAssignment::with(['asset', 'assigner'])
                    ->where('employee_id', Auth::user()->employee->employee_id)
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->whereAny(
                                ['purpose', 'status', 'condition_at_assignment', 'condition_at_return'], 'like', "%{$search}%")
                                ->orWhereHas('asset', function ($q2) use ($search) {
                                    $q2->whereAny(['asset_code', 'name'], 'like', "%{$search}%");
                                })
                                ->orWhereHas('assigner', function ($q3) use ($search) {
                                    $q3->where('name', 'like', "%{$search}%");
                                });
                        });
                    })->latest()->paginate(6);
            }
        );
        if ($request->ajax()) {
            return view('employee.assets.table', compact('asset_assigns'))->render();
        }
        return view('employee.assets.index', compact('asset_assigns'));
    }

    public function eventIndex(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'event_index_' . md5($search . '_page_' . $page);
        $events = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                return Event::query()->with('creator')
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['title',], 'like', "%{$search}%")
                            ->orWhereHas('creator', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereDate('event_date', 'like', "%{$search}%");
                    })->latest()->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('employee.events.table', compact('events'))->render();
        }
        return view('employee.events.index', compact('events'));
    }

    public function noticeIndex(Request $request)
    {
//        $notices=Notice::latest()->paginate(5);
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'notice_index_' . md5($search . '_page_' . $page);
        $notices = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                return Notice::query()->with('poster')
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['title', 'content'], 'like', "%{$search}%")
                            ->orWhereHas('poster', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->latest()->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('employee.notices.table', compact('notices'))->render();
        }

        return view('employee.notices.index', compact('notices'));
    }

    public function leaveIndex(Request $request)
    {
        $search = $request->get('search', '');

        $page = $request->get('page', 1);

        $cacheKey = 'leave_index_' . md5($search . '_page_' . $page);

        $leaves = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                $employeeId = Auth::user()->employee->employee_id;
                return Leave::query()
                    ->with(['leaveType', 'approver'])
                    ->where('employee_id', $employeeId)
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->whereAny(['status', 'reason'], 'like', "%{$search}%")
                                ->orWhereHas('leaveType', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('approver', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->orderBy('created_at', 'DESC')->paginate(8);
            }
        );
        if ($request->ajax()) {
            return view('employee.leaves.table', compact('leaves'))->render();
        }

        return view('employee.leaves.index', compact('leaves'));
    }

    public function attendanceIndex(Request $request)
    {
//      $attendances=Attendance::where('employee_id',Auth::user()->employee->employee_id)->orderBy('date', 'desc')->get();
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'attendance_index_' . md5($search . '_page_' . $page);

        $attendances = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                return Attendance::where('employee_id', Auth::user()->employee->employee_id)
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->whereAny(['status'], 'like', "%{$search}%")
                                ->orWhereDate('date', 'like', "%{$search}%")
                                ->orWhere('clock_in', 'like', "%{$search}%")
                                ->orWhere('clock_out', 'like', "%{$search}%");
                        });
                    })
                    ->orderBy('date', 'desc')->paginate(8);
            }
        );
        if ($request->ajax()) {
            return view('employee.attendances.table', compact('attendances'))->render();
        }
        return view('employee.attendances.index', compact('attendances'));
    }

    public function salaryIndex(Request $request)
    {
        $search = $request->get('search', '');

        $page = $request->get('page', 1);

        $cacheKey = 'payroll_index_' . md5($search . '_page_' . $page);

        $payrolls = Cache::remember(
            $cacheKey,
            now()->addSeconds(60),
            function () use ($search) {
                $employeeId = Auth::user()->employee->employee_id;
                return Payroll::query()->with(['employee', 'generator'])
                    ->where('employee_id', $employeeId)
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->whereAny(['payment_status', 'net_salary', 'month_year'], 'like', "%{$search}%")
                                ->orWhereHas('generator', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->orderBy('month_year', 'desc')->orderBy('created_at', 'desc')->paginate(8);
            }
        );
        if ($request->ajax()) {
            return view('employee.salaries.table', compact('payrolls'))->render();
        }
        return view('employee.salaries.index', compact('payrolls'));
    }
}
