
@extends('layouts.navbars')
@section('title','Add Notice')
@section('content')
<h1>Publish Notice</h1>
    <form action="{{ route('notices.store') }}" method="POST">
        @csrf
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Content:</label><br>
        <textarea name="content" value="{{ old('content') }}" rows="5" cols="25" required ></textarea>
        @error('content')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Publish</button>
    </form>
    <br>
@endsection