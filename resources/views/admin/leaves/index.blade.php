@extends('layouts.navbars')
@section('title','Leaves')
@section('content')
<h2>Leave Types</h2>
<a href="{{ route('leaves.create') }}">Add a leave</a>
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
            <th>Total Days</th>
            <th>Actions</th>
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
                <td>{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} </td>
                <td>
                    <a href="{{ route('leaves.edit',$leave->leave_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('leaves.destroy',$leave->leave_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this leave?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>No leave type found. Create a new one.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection