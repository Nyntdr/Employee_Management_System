<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Http\Requests\LeaveRequest;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::all();
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
    public function show(Leave $leave)
    {
        return view('admin.leaves.show', compact('leave'));
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
        $leave->update($request->validated());

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }
    public function destroy(string $id)
    {
        $leave=Leave::findOrFail($id);
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
