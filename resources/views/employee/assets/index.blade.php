@extends('layouts.employee_navbar')
@section('title', 'Assigned Assets')
@section('content')
<h2>Assigned Assets</h2>
<a href="#">Request Assets</a> <br><br>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Asset Name</th> 
            <th>Reason</th>  
            <th>Current Status</th> 
            <th>Assigned Condition</th>  
            <th>Assigner</th> 
        </tr>
    </thead>
    <tbody>
        @forelse($asset_assigns as $asset_assign)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset_assign->asset->asset_code. ' ' .$asset_assign->asset->name }}</td>
                <td>{{ $asset_assign->purpose}}</td>
                <td>{{ $asset_assign->status }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $asset_assign->condition_at_assignment->value)) ?? 'N/S' }}</td>
                <td>{{ $asset_assign->assigner->name}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="13" style="text-align: center;">No assets assigned to anyone.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection 