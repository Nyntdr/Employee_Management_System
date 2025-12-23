@extends('layouts.employee_navbar')
@section('title','All Notices')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Notices List</h1>
                <p class="text-muted mb-0">All company notices and announcements</p>
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
                                    <span class="text-muted">{{ $notice->created_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <h5 class="text-muted">No notices found</h5>
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
