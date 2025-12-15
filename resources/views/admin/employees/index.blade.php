@extends('layouts.navbars')
@section('title','All Employees')
@section('content')
<h1>Employees List</h1>
<a href="{{ route('employees.create') }}">Add Employee</a> <br><br>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
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
        @forelse($employees as $e)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $e->first_name.' '.$e->last_name }}</td>
                <td>{{ $e->gender}}</td>
                <td>{{ $e->phone }}</td>
                <td>{{ $e->secondary_phone}}</td>
                <td>{{ $e->emergency_contact}}</td>
                <td>{{ $e->position }}</td>
                <td>{{ $e->date_of_birth->format('F j,Y') }}</td>
                <td>{{ $e->date_of_joining->format('F j,Y')}}</td>
                <td>{{ $e->employment_status }}</td>
                <td>
                    <a href="{{ route('employees.edit',$e->employee_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('employees.destroy',$e->employee_id) }}" method="POST" style="display:inline;">
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