@extends('layouts.navbars')
@section('title','All Departments')
@section('content')
<h1>departments List</h1>
<a href="{{ route('departments.create') }}">Create a department</a>
<table border="1">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Department Name</th>
            <th>Manager Id</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($departments as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->manager_id}}</td>
                <td>
                    <a href="{{ route('departments.edit', $d->department_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('departments.destroy', $d->department_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this d$d?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>No departments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection