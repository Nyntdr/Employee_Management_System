
@extends('layouts.navbars')
@section('title','Create Event')
@section('content')
<h1>Create Event</h1>
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Description:</label><br>
        <textarea name="description" value="{{ old('description') }}" rows="5" cols="25"></textarea>
        @error('description')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Event Date:</label><br>
        <input type="date" name="event_date" value="{{ old('event_date') }}" required>
        @error('event_date')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Start Time:</label><br>
        <input type="time" name="start_time" value="{{ old('start_time') }}">
        @error('start_time')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>End Time:</label><br>
        <input type="time" name="end_time" value="{{ old('end_time') }}">
        @error('end_time')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <button type="submit">Create</button>
    </form>
    <br>
@endsection