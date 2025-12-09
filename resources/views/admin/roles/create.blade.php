
@extends('layouts.navbars')
@section('title','Add Roles')
@section('content')
<h1>Create New Role</h1>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <label>Role Name:</label><br>
        <input type="text" name="role_name" value="{{ old('role_name') }}" required>
        @error('role_name')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Save Role</button>
    </form>
    <br>
@endsection