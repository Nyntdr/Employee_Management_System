@extends('layouts.navbars')
@section('title','All Roles')
@section('content')
<h1>Roles List</h1>
<a href="{{ route('roles.create') }}">Create a role</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Role Name</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $role)
            <tr>
                <td>{{ $role->role_id }}</td>
                <td>{{ $role->role_name }}</td>
                <td>{{ $role->created_at->diffForHumans()}}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->role_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('roles.destroy', $role->role_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this role?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>No roles found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection