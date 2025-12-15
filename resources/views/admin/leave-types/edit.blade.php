@extends('layouts.navbars')
@section('title', 'Edit Leave Type')
@section('content')
    <h1>Edit Leave Type</h1>
    <form action="{{ route('leave-types.update', $leave_type->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name',$leave_type->name) }}" required>
        @error('name')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Days/Year:</label><br>
        <input type="text" name="max_days_per_year" value="{{ old('max_days_per_year',$leave_type->max_days_per_year) }}" required>
        @error('max_days_per_year')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('leave-types.index') }}">Go back</a>
@endsection
