<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentsExport;
use App\Exports\EmployeesExport;
use App\Http\Requests\DepartmentRequest;
use App\Imports\DepartmentImport;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new DepartmentImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }
    public function export()
    {
        return Excel::download(new DepartmentsExport(), 'departments.xlsx');
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
