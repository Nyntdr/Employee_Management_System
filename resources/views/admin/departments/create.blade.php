@extends('layouts.navbars')
@section('title','Add Departments')
@section('content')
    <h1>Create New Department</h1>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <label>Department Name:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
        <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <label>Manager:</label><br>
        <select name="manager_id">
            <option value="">-- Select Manager --</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->employee_id }}"
                    {{ old('manager_id') == $employee->employee_id ? 'selected' : '' }}>
                    {{ $employee->first_name }} {{ $employee->last_name }}
                    @if($employee->department)
                        ({{ $employee->department->name }})
                    @endif
                </option>
            @endforeach
        </select>
        @error('manager_id')
        <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Save Department</button>
    </form>
    <br>
@endsection
