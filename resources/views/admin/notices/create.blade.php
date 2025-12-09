
@extends('layouts.navbars')
@section('title','Add Notice')
@section('content')
<h1>Create New Role</h1>
    <form action="#" method="POST">
        @csrf
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Content:</label><br>
        <textarea name="contenr" value="{{ old('content') }}" required ></textarea>
        @error('content')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Save Role</button>
    </form>
    <br>
@endsection