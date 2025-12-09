
@extends('layouts.navbars')
@section('title','Edit Role')
@section('content')
<h1>Edit Role</h1>
<form action="{{ route('roles.update', $role->role_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Role Name:</label><br>
    <input type="text" name="role_name" value="{{ old('role_name', $role->role_name) }}" required>
    @error('role_name')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <button type="submit">Update Role</button>
</form>

<br>
<a href="{{ route('roles.index') }}">Back to Roles</a>
@endsection