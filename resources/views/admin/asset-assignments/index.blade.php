@extends('layouts.navbars')
@section('title', 'All Assigned Assets')
@section('content')
<h2>Assigned Assets</h2>
<a href="{{ route('asset-assignments.create') }}">Assign Assets</a> <br><br>
<a href="{{ route('assets.index') }}">Assets</a> <br><br>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Asset Name</th>
            <th>Assigned To</th>
            <th>Assigner</th> 
            <th>Reason</th>  
            <th>Current Status</th> 
            <th>Assigned Condition</th>  
            <th>Returned Condition</th>
            <th>Returned Date</th> 
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($asset_assigns as $asset_assign)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset_assign->asset->asset_code. ' ' .$asset_assign->asset->name }}</td>
                <td>{{ $asset_assign->employee->first_name. ' '. $asset_assign->employee->last_name}}</td>
                <td>{{ $asset_assign->assigner->name}}</td>
                <td>{{ $asset_assign->purpose}}</td>
                <td>{{ $asset_assign->status }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $asset_assign->condition_at_assignment->value)) ?? 'N/S' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $asset_assign->condition_at_return->value)) ?? 'N/A'}}</td>
                <td>{{ $asset_assign->returned_date ?? 'N/A'}}</td>
                <td>
                    <a href="{{ route('asset-assignments.edit', $asset_assign->assignment_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('asset-assignments.destroy', $asset_assign->assignment_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this assignment?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="13" style="text-align: center;">No assets assigned to anyone.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection 