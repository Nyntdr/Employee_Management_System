@extends('layouts.employee_navbar')
@section('title','All Notices')
@section('content')
<h1>Notices List</h1>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Content</th>
            <th>Poster</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notices as $notice)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->content }}</td>
                <td>{{ $notice->poster->name }}</td>
                <td>{{ $notice->created_at->diffForHumans()}}</td>
            </tr>
        @empty
            <tr>
                <td>No notices found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection