@extends('layouts.navbars')
@section('title','All Departments')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Departments</h5>
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    Add New Department
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Manager</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $d)
                            <tr>
                                <td><strong>{{ $d->name }}</strong></td>
                                <td>
                                    @if($d->manager_id)
                                        <span class="badge bg-info">
                                            {{ $d->manager->first_name }} {{ $d->manager->last_name  }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Not Assigned
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('departments.edit', $d->department_id) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('departments.destroy', $d->department_id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete {{ $d->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <h5>No Departments Found</h5>
                                    <p class="text-muted mb-4">Get started by creating your first department</p>
                                    <a href="{{ route('departments.create') }}" class="btn btn-primary">
                                        Create Department
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($departments->hasPages())
                <div class="mt-4">
                    {{ $departments->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection