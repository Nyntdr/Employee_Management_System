@extends('layouts.navbars')
@section('title','Edit Leave')

@section('content')
<h2>Edit Leave</h2>

<form action="{{ route('leaves.update', $leave->leave_id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>Employee:</label><br>
    <select name="employee_id" required>
        <option value="">Select Employee</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->employee_id }}" {{ $leave->employee_id == $employee->employee_id ? 'selected' : '' }}>
                {{ $employee->first_name }} {{ $employee->last_name }}
            </option>
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
            <option value="{{ $type->id }}" {{ $leave->leave_type_id == $type->id ? 'selected' : '' }}>
                {{ $type->name }}
            </option>
        @endforeach
    </select>
    @error('leave_type_id')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Start Date:</label><br>
    <input type="date" name="start_date" value="{{ $leave->start_date->format('Y-m-d') }}" required>
    @error('start_date')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>End Date:</label><br>
    <input type="date" name="end_date" value="{{ $leave->end_date->format('Y-m-d') }}" required>
    @error('end_date')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Reason:</label><br>
    <textarea name="reason" rows="4" required>{{ $leave->reason }}</textarea>
    @error('reason')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <label>Status:</label><br>
    <select name="status">
        <option value="pending" {{ $leave->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
        <option value="cancelled" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Cancelled</option>
    </select>
    @error('status')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <br><br>
    
    <button type="submit">Update Leave</button>
    <a href="{{ route('leaves.index') }}" style="margin-left: 10px;">Cancel</a>
</form>
@endsection