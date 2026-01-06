<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use App\Imports\LeaveImport;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Http\Requests\LeaveRequest;
use App\Models\User;
use App\Notifications\EventCreatedNotification;
use App\Notifications\LeaveUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
//        $leaves = Leave::orderBy('created_at', 'DESC')->get();
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'leaves_index_' . md5($search . '_page_' . $page);

        $leaves =Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Leave::query()->with(['employee', 'leaveType', 'approver'])
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['status','reason'], 'like', "%{$search}%")
                            ->orWhereHas('employee', function ($q) use ($search) {
                                $q->whereAny(['first_name', 'last_name'], 'like', "%{$search}%");
                            })
                            ->orWhereHas('leaveType', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('approver', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->orderBy('created_at', 'DESC')->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('admin.leaves.table', compact('leaves'))->render();
        }
            return view('admin.leaves.index', compact('leaves'));
    }
    public function create()
    {
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        return view('admin.leaves.create', compact('employees', 'leaveTypes'));
    }
    public function export()
    {
        return Excel::download(new LeavesExport(), 'leaves_export.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new LeaveImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Leave records imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function store(LeaveRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';
        $data['approved_by'] = auth()->id();
        Leave::create($data);
        Cache::flush();
        return redirect()->route('leaves.index')->with('success', 'Leave added successfully.');
    }
    public function edit(string $id)
    {
        $leave=Leave::findOrFail($id);
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        return view('admin.leaves.edit', compact('leave', 'employees', 'leaveTypes'));
    }
    public function update(LeaveRequest $request, string $id)
    {
        $leave = Leave::with(['employee', 'approver'])->findOrFail($id);
        $oldStatus = $leave->status->value;
        $newStatus = $request->status;

        $leave->update(array_merge($request->validated(), ['approved_by' => Auth::id()]));
        Cache::flush();
        if (($newStatus === 'approved' || $newStatus === 'rejected') && $oldStatus !== $newStatus) {
            if ($leave->employee->user) {
                $leave->employee->user->notify(new LeaveUpdatedNotification($leave));
            }
        }
        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }
    public function destroy(string $id)
    {
        $leave=Leave::findOrFail($id);
        $leave->delete();
        Cache::flush();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
