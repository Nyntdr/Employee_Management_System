@extends('layouts.navbars')
@section('title', 'Update Event')
@section('content')
    <h1>Update Event</h1>
    <form action="{{ route('events.update', $event->event_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title',$event->title) }}" required>
        @error('title')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Description:</label><br>
        <textarea name="description" rows="5" cols="25">{{ old('description',$event->description) }}</textarea>
        @error('description')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Event Date:</label><br>
        <input type="date" name="event_date" value="{{ old('event_date',$event->event_date->format('Y-m-d')) }}" required>
        @error('event_date')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Start Time:</label><br>
        <input type="time" name="start_time" value="{{ old('start_time', optional($event->start_time)->format('H:i')) }}">
        @error('start_time')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>End Time:</label><br>
        <input type="time" name="end_time" value="{{ old('end_time', optional($event->end_time)->format('H:i')) }}">
        @error('end_time')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <button type="submit">Update</button>
    </form>
    <br>
    <a href="{{ route('events.index') }}">Go Back</a>
@endsection
