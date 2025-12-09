
@extends('layouts.navbars')
@section('title','Edit Department')
@section('content')
<h1>Edit Role</h1>
<form action="{{ route('departments.update', $department->department_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Department Name:</label><br>
    <input type="text" name="name" value="{{ old('name', $department->name) }}" required>
    @error('name')
        <span>{{ $message }}</span>
    @enderror
    <br><br>
    <label>Manager Id:</label><br>
    <input type="text" name="manager_id" value="{{ old('manager_id', $department->manager_id) }}">
    @error('manager_id')
        <span>{{ $message }}</span>
    @enderror
    <br><br>

    <button type="submit">Update Department</button>
</form>

<br>
<a href="{{ route('departments.index') }}">Back to Departments</a>
@endsection