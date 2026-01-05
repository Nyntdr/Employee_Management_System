<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'employees_index_' . md5($search . '_page_' . $page);

        $employees = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Employee::query()
                    ->with(['user', 'department', 'contracts'])
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(
                            ['first_name', 'last_name', 'phone', 'secondary_phone', 'emergency_contact'],
                            'like',
                            "%{$search}%"
                        )
                            ->orWhereHas('user', function ($q) use ($search) {
                                $q->whereAny(['name', 'email'], 'like', "%{$search}%");
                            })
                            ->orWhereHas('department', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->paginate(8);
            }
        );

        if ($request->ajax()) {
            return view('admin.employees.employee_data', compact('employees'))->render();
        }

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        $deps = Department::all();

        return view('admin.employees.create', compact('roles', 'deps'));
    }

    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees_export.xlsx');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        Employee::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'secondary_phone' => $validated['secondary_phone'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'department_id' => $validated['department_id'],
            'date_of_birth' => $validated['dob'],
            'date_of_joining' => $validated['doj'],
        ]);

        Cache::flush();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee added successfully!');
    }

    public function edit(string $id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        $roles = Role::all();
        $deps = Department::all();


        return view('admin.employees.edit', compact('employee', 'roles', 'deps'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $validated = $request->validated();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $employee->user->update($userData);

        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'secondary_phone' => $validated['secondary_phone'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'department_id' => $validated['department_id'],
            'date_of_birth' => $validated['dob'],
            'date_of_joining' => $validated['doj'],
        ]);

        Cache::flush();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(string $id)
    {
        $employee = Employee::with('user')->findOrFail($id);

        DB::transaction(function () use ($employee) {
            $employee->user->delete();
            $employee->delete();
        });

        Cache::flush(); // ✅ clear cache after delete

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}
