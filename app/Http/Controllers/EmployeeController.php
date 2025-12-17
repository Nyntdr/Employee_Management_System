<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->paginate(6);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        $deps = Department::all();
        return view('admin.employees.create', compact('roles', 'deps'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => $validated['role_id'],
        ]);
        Employee::create([
            'user_id'           => $user->id,
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'gender'            => $validated['gender'],
            'phone'             => $validated['phone'],
            'secondary_phone'   => $validated['secondary_phone'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'department_id'     => $validated['department_id'],
            'position'          => $validated['position'],
            'date_of_birth'     => $validated['dob'],
            'date_of_joining'   => $validated['doj'],
            'employment_status' => $validated['status'],
        ]);

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
        $user = $employee->user;
        $userData = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role_id' => $validated['role_id'],
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }
        $user->update($userData);
        $employee->update([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'gender'            => $validated['gender'],
            'phone'             => $validated['phone'],
            'secondary_phone'   => $validated['secondary_phone'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'department_id'     => $validated['department_id'],
            'position'          => $validated['position'],
            'date_of_birth'     => $validated['dob'],
            'date_of_joining'   => $validated['doj'],
            'employment_status' => $validated['status'],
        ]);

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

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}