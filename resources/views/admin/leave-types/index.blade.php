@extends('layouts.navbars')
@section('title','Leave Types')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Leave Types</h1>
                <p class="text-muted mb-0">Manage different types of leave</p>
            </div>
            <a href="{{ route('leave-types.create') }}" class="btn btn-primary">Add Leave Type</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3 import-export-row">
            <div class="col-md-6">
                <div class="d-flex gap-2 btn-gap">
                    <a href="{{ route('leaves.index') }}" class="btn btn-outline-secondary">Leave Records</a>
                    <form action="{{ route('departments.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()" class="btn btn-outline-primary">Import</button>
                    </form>
                    <a href="{{ route('leave-types.export') }}" class="btn btn-outline-secondary">Export</a>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Days/Year</th>
                            <th scope="col" width="120" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($leave_types as $leave_type)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $leave_type->name }}</div>
                                </td>
                                <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ $leave_type->max_days_per_year }} days
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('leave-types.edit', $leave_type->id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Leave Type">Edit</a>
                                        <form action="{{ route('leave-types.destroy', $leave_type->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this leave type?')" title="Delete Leave Type">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <h5 class="text-muted">No leave types found</h5>
                                        <p class="text-muted mb-4">Get started by adding your first leave type</p>
                                        <a href="{{ route('leave-types.create') }}" class="btn btn-primary">Add First Leave Type</a>
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

@endsection
