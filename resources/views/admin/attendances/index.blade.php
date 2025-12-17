@extends('layouts.navbars')
@section('title','Attendance')
@section('content')
<h2>Attendance List</h2>
<a href="{{ route('attendances.create') }}">Add Attendance</a> <br><br>
<table border="1" style="text-align: center;">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Employee Name</th>
            <th>Date</th>
            <th>Clock In</th> 
            <th>Clock Out</th>  
            <th>Total Hours</th> 
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $attendance)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                <td>{{ $attendance->date->format('Y-m-d') }}</td>
                <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : 'N/A' }}</td>
                <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : 'N/A' }}</td>
                <td>{{ $attendance->total_hours ?? 'N/A' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $attendance->status->value)) }}</td> 
                
                <td>
                    <a href="{{ route('attendances.edit', $attendance->attendance_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('attendances.destroy', $attendance->attendance_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this attendance?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center;">No attendances found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection