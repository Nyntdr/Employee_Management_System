<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Http\Requests\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
//        $leaves = Leave::orderBy('created_at', 'DESC')->get();
        $search = $request->get('search', '');

        $leaves = Leave::query()->with(['employee', 'leaveType', 'approver'])
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
            ->orderBy('created_at', 'DESC')->paginate(8);
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
    public function store(LeaveRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';
        $data['approved_by'] = auth()->id();
        Leave::create($data);
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
        $leave=Leave::findOrFail($id);
        $leave->update(array_merge($request->validated(),['approved_by' => Auth::id()]));

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }
    public function destroy(string $id)
    {
        $leave=Leave::findOrFail($id);
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
