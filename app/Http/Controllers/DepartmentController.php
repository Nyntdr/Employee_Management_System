<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentsExport;
use App\Exports\EmployeesExport;
use App\Http\Requests\DepartmentRequest;
use App\Imports\DepartmentImport;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
//        $departmentCount = Department::withCount('employees')->paginate(5);
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $cacheKey = 'departments_index_' . md5($search . '_page_' . $page);

        $departments = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Department::query()->with(['manager'])
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['name'], 'like', "%{$search}%")
                            ->orWhereHas('manager', function ($q) use ($search) {
                                $q->whereAny(['first_name', 'last_name'], 'like', "%{$search}%");
                            });
                    })
                    ->withCount('employees')->paginate(5);
            }
        );
        if ($request->ajax()) {
            return view('admin.departments.table', compact('departments'))->render();
        }

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $employees = Employee::with('department')->get();
        return view('admin.departments.create', compact('employees'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new DepartmentImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Departments imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new DepartmentsExport(), 'departments.xlsx');
    }

    public function store(DepartmentRequest $request)
    {
        $validated = $request->validated();
        Department::create($validated);
        Cache::flush();
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        $employees = Employee::where('department_id', $department->department_id)->with('department')->get();
        return view('admin.departments.edit', compact('department', 'employees'));
    }

    public function update(DepartmentRequest $request, string $id)
    {
        $department = Department::findOrFail($id);
        $validated = $request->validated();
        $department->update($validated);
        Cache::flush();
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $employeeCount = $department->employees()->count();
        if ($employeeCount > 0) {
            return redirect()->route('departments.index')
                ->with('error',
                    "Cannot delete the department because it has {$employeeCount} employees assigned. Please reassign all employees to another department first."
                );
        }

        $department->delete();
        Cache::flush();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
