@extends('layouts.navbars')
@section('title','All Notices')
@section('content')
<h1>Notices List</h1>
<a href="{{ route('notices.create') }}">Create notice</a>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->content }}</td>
                <td>{{ $notice->poster->name }}</td>
                <td>{{ $notice->created_at->diffForHumans()}}</td>
                <td>
                    <a href="{{ route('notices.edit',$notice->notice_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('notices.destroy',$notice->notice_id) }}" method="POST" style="display:inline;">
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