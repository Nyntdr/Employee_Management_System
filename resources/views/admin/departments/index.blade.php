@extends('layouts.navbars')
@section('title','All Departments')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Department List</h1>
                <p class="text-muted mb-0">Manage employee departments</p>
            </div>
            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                Add Department
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3 import-export-row">
            <div class="col-md-6">
                <div class="d-flex gap-2 btn-gap">
                    <form action="{{ route('departments.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()" class="btn btn-outline-primary">
                            Import
                        </button>
                    </form>
                    <a href="{{ route('departments.export') }}" class="btn btn-outline-secondary">Export</a>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Department Name</th>
                            <th scope="col">Manager</th>
                            <th scope="col" width="150" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($departments as $d)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $d->name }}</div>
                                </td>
                                <td>
                                    @if($d->manager_id)
                                        <span class="table-badge badge-opacity-info">
                                            {{ $d->manager->first_name }} {{ $d->manager->last_name }}
                                        </span>
                                    @else
                                        <span class="table-badge badge-opacity-secondary">
                                            Not Assigned
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('departments.edit', $d->department_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Department">Edit</a>
                                        <form action="{{ route('departments.destroy', $d->department_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete {{ $d->name }}?')" title="Delete Department">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="py-4">
                                        <h5 class="text-muted">No departments found</h5>
                                        <p class="text-muted mb-4">Get started by adding a new department</p>
                                        <a href="{{ route('departments.create') }}" class="btn btn-primary">
                                            Add First Department
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($departments->hasPages())
                    <div class="pagination-wrapper">
                        <div class="d-flex justify-content-center">
                            {{ $departments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
