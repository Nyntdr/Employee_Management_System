@extends('layouts.navbars')
@section('title','Leave types')
@section('content')
<h2>Leave Types</h2>
<a href="{{ route('leave-types.create') }}">Add a leave type</a> <br> <br>
<a href="{{ route('leaves.index') }}">Leaves</a>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Days/Year</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($leave_types as $leave_type)
            <tr>
                <td>{{ $leave_type->name }}</td>
                <td>{{ $leave_type->max_days_per_year }}</td>
                <td>
                    <a href="{{ route('leave-types.edit',$leave_type->id) }}">Edit</a>
                    <form action="{{ route('leave-types.destroy',$leave_type->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this leave type?')">Delete</button>
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