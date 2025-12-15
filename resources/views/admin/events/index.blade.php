@extends('layouts.navbars')
@section('title', 'All Events')
@section('content')
    <h1>Event List</h1>
    <a href="{{ route('events.create') }}">Create event</a>
    <table border="1">
        <thead>
            <tr>
                <th>S/N/th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Announcer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $e)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $e->title }}</td>
                    <td>{{ $e->description }}</td>
                    <td>{{ $e->event_date->format('M d,Y') }}</td>
                    <td>{{ $e->start_time->format('h:i A') . ' to ' . $e->end_time->format('h:i A') }}</td>
                    <td>
                        @if (now()->greaterThan($e->event_date))
                            <span style="color: green;"><b>Completed</b></span>
                        @else
                            <span style="color: blue;"><b>Upcoming</b></span>
                        @endif
                    </td>
                    <td>{{ $e->creator->name }}</td>
                    <td>
                        <a href="{{ route('events.edit', $e->event_id) }}">Edit</a>
                        <br>
                        <form action="{{ route('events.destroy', $e->event_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>No events done.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
