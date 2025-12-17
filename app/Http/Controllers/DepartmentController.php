<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments=Department::paginate(5);
        return view('admin.departments.index',compact('departments'));
    }
    public function create()
    {
        return view('admin.departments.create');
    }
    public function store(DepartmentRequest $request)
    {
        $validated=$request->validated();
        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }
    public function update(DepartmentRequest $request, string $id)
    {
        $department = Department::findOrFail($id);
        $validated=$request->validated();
        $department->update($validated);

        return redirect()->route('departments.index');
    }
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index');
    }
}
