@extends('layouts.navbars')
@section('title', 'Edit Attendance')
@section('content')
    <h2>Edit Attendance</h2>
    <a href="{{ route('attendances.index') }}">Back to List</a>
    <br><br>
    <form action="{{ route('attendances.update', $attendance->attendance_id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="employee_id">Employee *</label><br>
        <select name="employee_id" id="employee_id" required {{ $attendance->employee_id ? 'disabled' : '' }}>
            <option value="">Select Employee</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->employee_id }}"
                    {{ $attendance->employee_id == $employee->employee_id ? 'selected' : '' }}>
                    (EM-{{ $employee->employee_id }}) {{ $employee->first_name }} {{ $employee->last_name }}
                </option>
            @endforeach
        </select>
        @if($attendance->employee_id)
            <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
        @endif
        @error('employee_id')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <label for="date">Date *</label><br>
        <input type="date" name="date" id="date"
               value="{{ old('date', $attendance->date ? $attendance->date->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('date')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <label for="clock_in">Clock In</label><br>
        <input type="time" name="clock_in" id="clock_in"
               value="{{ old('clock_in', $attendance->clock_in ? $attendance->clock_in->format('H:i') : '') }}">
        @error('clock_in')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <label for="clock_out">Clock Out</label><br>
        <input type="time" name="clock_out" id="clock_out"
               value="{{ old('clock_out', $attendance->clock_out ? $attendance->clock_out->format('H:i') : '') }}">
        @error('clock_out')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <label for="status">Status *</label><br>
        <select name="status" id="status" required>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ old('status', $attendance->status->value) == $status->value ? 'selected' : '' }}>
                    {{ ucfirst($status->value) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Update Attendance</button>
        <button type="reset">Reset</button>
    </form>
@endsection
