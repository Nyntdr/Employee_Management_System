@extends('layouts.employee_navbar')
@section('title', 'All Assets')
@section('content')
<h2>My Assets List</h2>
<a href="#">Ask Assets</a> <br><br>
<table border="1" style="text-align: center;">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Asset Code</th>
            <th>Asset Name</th>
            <th>Status</th>
            <th>Current Condition</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assets as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->asset_code }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $asset->status->value)) }}</td> 
                <td>{{ ucfirst($asset->current_condition->value) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">No assets found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection