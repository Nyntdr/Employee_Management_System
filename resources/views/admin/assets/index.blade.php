@extends('layouts.navbars')
@section('title', 'All Assets')
@section('content')
<h2>Assets List</h2>
<a href="{{ route('assets.create') }}">Add Asset</a> <br><br>
<a href="{{ route('asset-assignments.index') }}">Assign Asset</a> <br><br>
<table border="1" style="text-align: center;">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Asset Code</th>
            <th>Asset Name</th>
            <th>Type</th> 
            <th>Category</th>  
            <th>Brand</th> 
            <th>Model</th>  
            <th>Serial No</th>  
            <th>Purchase Date</th>
            <th>Warranty</th> 
            <th>Status</th>
            <th>Current Condition</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assets as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->asset_code }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ ucfirst($asset->type->value) }}</td>
                <td>{{ $asset->category ?? 'N/A' }}</td>
                <td>{{ $asset->brand ?? 'N/A' }}</td>
                <td>{{ $asset->model ?? 'N/A' }}</td>
                <td>{{ $asset->serial_number }}</td>
                <td>{{ $asset->purchase_date ? $asset->purchase_date->format('F j, Y') : 'N/A' }}</td>
                <td>{{ $asset->warranty_until ? $asset->warranty_until->format('F j, Y') : 'N/A' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $asset->status->value)) }}</td> 
                <td>{{ ucfirst($asset->current_condition->value) }}</td>
                <td>
                    <a href="{{ route('assets.edit', $asset->asset_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('assets.destroy', $asset->asset_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this asset?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="13" style="text-align: center;">No assets found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection