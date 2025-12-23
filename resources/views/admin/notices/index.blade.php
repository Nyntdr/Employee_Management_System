@extends('layouts.navbars')
@section('title','All Notices')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Notices List</h1>
                <p class="text-muted mb-0">Manage company notices and announcements</p>
            </div>
            <a href="{{ route('notices.create') }}" class="btn btn-primary">
                Create Notice
            </a>
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
                    <form action="{{ route('notices.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()" class="btn btn-outline-primary">
                            Import
                        </button>
                    </form>
                    <a href="{{ route('notices.export') }}" class="btn btn-outline-secondary">Export</a>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" width="60">S/N</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Posted By</th>
                            <th scope="col">Time</th>
                            <th scope="col" width="120" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($notices as $notice)
                            <tr>
                                <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-medium">{{ $notice->title }}</div>
                                </td>
                                <td>
                                    <div class="text-muted" style="max-width: 300px;">
                                        {{ Str::limit($notice->content, 100) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ $notice->poster->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $notice->updated_at->diffForHumans() }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('notices.edit', $notice->notice_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Notice">Edit</a>
                                        <form action="{{ route('notices.destroy', $notice->notice_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this notice?')" title="Delete Notice">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <h5 class="text-muted">No notices found</h5>
                                        <p class="text-muted mb-4">Get started by creating your first notice</p>
                                        <a href="{{ route('notices.create') }}" class="btn btn-primary">
                                            Create First Notice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($notices->hasPages())
                    <div class="pagination-wrapper">
                        <div class="d-flex justify-content-center">
                            {{ $notices->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
