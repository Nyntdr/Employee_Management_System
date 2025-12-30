@extends('layouts.navbars')
@section('title','All Roles')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-midnight mb-2">Roles List</h1>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                Add Role
            </a>

        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" width="60">S/N</th>
                            <th scope="col">Role Name</th>
                            <th scope="col">Total Employees/Users </th>
                            <th scope="col">Created on</th>
                            <th scope="col" width="150">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $role->role_name }}</strong>
                                </td>
                                <td>{{$role->users_count}}</td>
                                <td class="text-muted">
                                    <small>{{ $role->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('roles.edit', $role->role_id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit">Edit
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->role_id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this role?')"
                                                    title="Delete">Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">No roles found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        .btn-outline-primary, .btn-outline-danger {
            border-width: 1px;
            padding: 0.25rem 0.5rem;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
    </style>
@endsection
