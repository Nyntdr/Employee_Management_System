@extends('layouts.navbars')
@section('title', 'Update Notice')
@section('content')
    <h1>Edit Role</h1>
    <form action="{{ route('notices.update', $notice->notice_id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title',$notice->title) }}" required>
        @error('title')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="25" required>{{ old('content',$notice->content)}}</textarea>
        @error('content')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('notices.index') }}">Back to Notices</a>
@endsection
