@extends('layouts.navbars')
@section('title','Edit Department')
@section('content')
    <h1>Edit Department</h1>
    <form action="{{ route('departments.update', $department->department_id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Department Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $department->name) }}" required>
        @error('name')
        <span>{{ $message }}</span>
        @enderror
        <br><br>

        <label>Manager:</label><br>
        <select name="manager_id">
            <option value="">-- No Manager --</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->employee_id }}"
                    {{ old('manager_id', $department->manager_id) == $employee->employee_id ? 'selected' : '' }}>
                    {{ $employee->first_name }} {{ $employee->last_name }}
                    @if($employee->department)
                        - {{ $employee->department->name }}
                    @endif
                </option>
            @endforeach
        </select>
        @error('manager_id')
        <span>{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Update Department</button>
    </form>

    <br>
    <a href="{{ route('departments.index') }}">Back to Departments</a>
@endsection
