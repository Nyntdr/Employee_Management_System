@extends('layouts.navbars')
@section('title','All Notices')
@section('content')
<h1>Notices List</h1>
<a href="{{ route('notices.create') }}">Create notice</a>
<table border="1">
    <thead>
        <tr>
            <th>Nootice ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Poster</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notices as $notice)
            <tr>
                <td>{{ $notice->notice_id }}</td>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->content }}</td>
                <td>{{ $notice->posted_by }}</td>
                <td>{{ $notice->created_at->diffForHumans()}}</td>
                <td>
                    <a href="#">Edit</a>
                    <br>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this notice?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>No notices found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection