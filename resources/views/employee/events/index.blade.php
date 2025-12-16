@extends('layouts.employee_navbar')
@section('title', 'All Events')
@section('content')
    <h1>Event List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Announcer</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->event_date->format('M d,Y') }}</td>
                    <td>{{ $event->start_time->format('h:i A') . ' to ' . $event->end_time->format('h:i A') }}</td>
                    <td>
                        @if (now()->greaterThan($event->event_date))
                            <span style="color: green;"><b>Completed</b></span>
                        @else
                            <span style="color: blue;"><b>Upcoming</b></span>
                        @endif
                    </td>
                    <td>{{ $event->creator->name }}</td>
                 
                </tr>
            @empty
                <tr>
                    <td>No events done.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
