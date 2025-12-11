@extends('layouts.navbars')
@section('title', 'All Assets')
@section('content')
<h1>Assets List</h1>
<a href="{{ route('assets.create') }}">Add Asset</a> <br><br>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
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
                <td>{{ $asset->asset_id }}</td>
                <td>{{ $asset->asset_code }}</td>
                <td>{{ $asset->name }}</td>
                {{-- FIX: Use ->value to get the string value --}}
                <td>{{ ucfirst($asset->type->value) }}</td>
                <td>{{ $asset->category ?? 'N/A' }}</td>
                <td>{{ $asset->brand ?? 'N/A' }}</td>
                <td>{{ $asset->model ?? 'N/A' }}</td>
                <td>{{ $asset->serial_number }}</td>
                <td>{{ $asset->purchase_date ? $asset->purchase_date->format('F j, Y') : 'N/A' }}</td>
                <td>{{ $asset->warranty_until ? $asset->warranty_until->format('F j, Y') : 'N/A' }}</td>
                {{-- FIX: Use ->value and format it --}}
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