@extends('layouts.navbars')
@section('title','Add Leave')

@section('content')
<h2>Add New Leave</h2>

<form action="{{ route('leaves.store') }}" method="POST">
    @csrf
    
    <label>Employee:</label><br>
    <select name="employee_id" required>
        <option value="">Select Employee</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->employee_id }}">{{ $employee->first_name}} {{ $employee->last_name}}</option>
        @endforeach
    </select>
    @error('employee_id')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Leave Type:</label><br>
    <select name="leave_type_id" required>
        <option value="">Select Leave Type</option>
        @foreach($leaveTypes as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
    @error('leave_type_id')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Start Date:</label><br>
    <input type="date" name="start_date" value="{{ old('start_date') }}" required>
    @error('start_date')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>End Date:</label><br>
    <input type="date" name="end_date" value="{{ old('end_date') }}" required>
    @error('end_date')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Reason:</label><br>
    <textarea name="reason" rows="4" required>{{ old('reason') }}</textarea>
    @error('reason')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <button type="submit">Add Leave</button>
    <a href="{{ route('leaves.index') }}" style="margin-left: 10px;">Cancel</a>
</form>
@endsection