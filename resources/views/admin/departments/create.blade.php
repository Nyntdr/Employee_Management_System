
@extends('layouts.navbars')
@section('title','Add Departments')
@section('content')
<h1>Create New Department</h1>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <label>Department Name:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Manager Id:</label><br>
        <input type="text" name="manager_id" value="{{ old('manager_id') }}" placeholder="Can be empty hai">
        @error('manager_id')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <button type="submit">Save Department</button>
    </form>
    <br>
@endsection