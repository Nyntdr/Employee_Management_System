@extends('layouts.navbars')
@section('title','All Employees')
@section('content')
<h1>Employees List</h1>
<a href="{{ route('employees.create') }}">Add Employee</a> <br><br>
<a href="{{ route('roles.index') }}">Roles</a>
<table border="1">
    <thead>
        <tr>
            <th>Role</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Contact</th> 
            <th>Secondary Contact</th>  
            <th>Emergency Contact</th> 
            <th>Postion</th>  
            <th>DOB</th>  
            <th>DOJ</th>
            <th>Status</th> 
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
            <tr>
                <td>{{ $employee->user->role->role_name}}</td>
                <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
                <td>{{ $employee->gender}}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->secondary_phone}}</td>
                <td>{{ $employee->emergency_contact}}</td>
                <td>{{ $employee->contracts()->latest()->first()->job_title ?? 'N/A' }}</td>
                <td>{{ $employee->date_of_birth->format('F j,Y') }}</td>
                <td>{{ $employee->date_of_joining->format('F j,Y')}}</td>
                <td>{{ $employee->contracts()->latest()->first()->contract_status ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('employees.edit',$employee->employee_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('employees.destroy',$employee->employee_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this employee?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>No employees found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection