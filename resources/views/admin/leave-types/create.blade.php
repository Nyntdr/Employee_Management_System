
@extends('layouts.navbars')
@section('title','Add Leave Type')
@section('content')
<h2>Add Leave Type</h2>
    <form action="{{ route('leave-types.store') }}" method="POST">
        @csrf
        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Max Days Per Year:</label><br>
        <input type="text" name="max_days_per_year" value="{{ old('max_days_per_year') }}" required>
        @error('max_days_per_year')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <button type="submit">Add</button>
    </form>
    <br>
@endsection