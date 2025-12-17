@extends('layouts.employee_navbar')
@section('title','My Attendance')
@section('content')
<h2>Attendance List</h2>
<a href="#">Raise an Issue</a> <br><br>
<table border="1" style="text-align: center;">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Date</th>
            <th>Clock In</th> 
            <th>Clock Out</th>  
            <th>Total Hours</th> 
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $attendance)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->clock_in }}</td>
                <td>{{ $attendance->clock_out ?? 'N/A' }}</td>
                <td>{{ $attendance->total_hours }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $attendance->status->value)) }}</td> 
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">No attendance record found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection