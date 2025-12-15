<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Http\Requests\LeaveTypeRequest;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leave_types = LeaveType::all();
        return view('admin.leave-types.index', compact('leave_types'));
    }

    public function create()
    {
        return view('admin.leave-types.create'); 
    }

    public function store(LeaveTypeRequest $request)
    {
        LeaveType::create($request->validated(),);
        return redirect()->route('leave-types.index')->with('success', 'LeaveType added successfully!');
    }

    public function edit(string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        return view('admin.leave-types.edit', compact('leave_type'));
    }

    public function update(LeaveTypeRequest $request, string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        $leave_type->update($request->validated());
        return redirect()->route('leave-types.index')->with('success', 'LeaveType updated successfully!');
    }

    public function destroy(string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        $leave_type->delete();
        return redirect()->route('leave-types.index')->with('success', 'LeaveType deleted successfully!');
    }
}