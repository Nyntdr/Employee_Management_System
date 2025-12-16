@extends('layouts.employee_navbar')
@section('title','Leaves')
@section('content')
<h2>Leave Types</h2>
<a href="#">Request leave</a>
<table border="1">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Approver</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($leaves as $leave)
            <tr>
                <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                <td>{{ $leave->leaveType->name }}</td>
                <td>{{ $leave->start_date->format('M d, Y') }}</td>
                <td>{{ $leave->end_date->format('M d, Y')}}</td>
                <td>{{ $leave->reason }}</td>
                <td>{{ $leave->approver->name }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $leave->status->value)) }}</td>
        @empty
            <tr>
                <td>No leave type taken. Request one.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection