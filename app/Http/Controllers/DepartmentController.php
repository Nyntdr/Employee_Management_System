<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments=Department::all();
        return view('admin.departments.index',compact('departments'));
    }
    public function create()
    {
        return view('admin.departments.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100|unique:departments,name',
            'manager_id' => 'nullable|integer|exists:employees,employee_id',
        ]);
        Department::create([
            'name' => $request->name,
            'manager_id'=>$request->manager_id]);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }
    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);
       $request->validate([
            'name'       => 'required|string|max:100|unique:departments,name',
            'manager_id' => 'nullable|integer|exists:employees,employee_id',
        ]);
        $department->update([
            'name' => $request->name,
            'manager_id'=>$request->manager_id,
        ]);
        return redirect()->route('admin.departments.index');
    }
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index');
    }
}
