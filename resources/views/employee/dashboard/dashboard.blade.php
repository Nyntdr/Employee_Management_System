@extends('layouts.employee_navbar')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="text-midnight mb-2">Employee Dashboard</h1>
                        <p class="text-muted mb-1">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">You are currently
                            <strong class="{{ $isAllowed ? 'text-success' : 'text-danger' }}">
                                {{ $isAllowed ? 'logged into' : 'not logged into' }}
                            </strong>
                            the office network
                        </p>
                        @if(!$isAllowed)
                            <div class="alert alert-warning alert-dismissible fade show d-inline-block" style="font-size: 0.875rem;">
                                You need to be connected to office network for full access
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    </div>
                    <div class="clock-section p-3">
                        <h6 class="mb-2 text-midnight">Clock Status</h6>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-2" style="font-size: 0.875rem;">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-2" style="font-size: 0.875rem;">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <form action="{{ route('clockin') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success px-4" {{ !$isAllowed ? 'disabled' : '' }}>
                                    Clock In
                                </button>
                            </form>

                            <form action="{{ route('clockout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning px-4" {{ !$isAllowed ? 'disabled' : '' }}>
                                    Clock Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-midnight">Quick Links</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('employee.events.index') }}" class="btn btn-midnight">
                                View Events
                            </a>
                            <a href="{{ route('employee.notices.index') }}" class="btn btn-midnight">
                                View Notices
                            </a>
                            <a href="{{ route('asset-requests.index') }}" class="btn btn-midnight">
                                Request Asset
                            </a>
                            <a href="{{ route('leave-requests.create') }}" class="btn btn-midnight">
                                Request Leave
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <div>
                            <h6 class="stat-label mb-2">Assets Taken</h6>
                            <h2 class="stat-number mb-0">{{ $totalAssets }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <div>
                            <h6 class="stat-label mb-2">Leaves Taken</h6>
                            <h2 class="stat-number mb-0">{{ $totalLeaves }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <div>
                            <h6 class="stat-label mb-2">Total Notices</h6>
                            <h2 class="stat-number mb-0">{{ $totalNotices ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <div>
                            <h6 class="stat-label mb-2">Total Events</h6>
                            <h2 class="stat-number mb-0">{{ $totalEvents ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-midnight mb-0">Latest Notice</h5>
                            <span class="badge bg-info" style="font-size: 0.75rem;">
                                {{ $latestNotice ? $latestNotice->created_at->format('M d Y') : 'N/A' }}
                            </span>
                        </div>

                        @if($latestNotice)
                            <div class="latest-item">
                                <h6 class="text-midnight mb-2">{{ $latestNotice->title }}</h6>
                                <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                    {{ Str::limit($latestNotice->content, 150) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info">
                                       Poster: {{ $latestNotice->poster->name ?? 'Admin' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No notices available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-midnight mb-0">Upcoming Event</h5>
                            @if($latestEvent)
                                <span class="badge bg-info" style="font-size: 0.75rem;">
                                    {{ $latestEvent->start_time->format('M d Y') }}
                                </span>
                            @endif
                        </div>

                        @if($latestEvent)
                            <div class="latest-item">
                                <h6 class="text-midnight mb-2">{{ $latestEvent->title }}</h6>

                                <div class="event-details mb-3">
                                    <div class="mb-2">
                                        <small class="text-muted">
                                          <strong> Time Duration:</strong>  {{ $latestEvent->start_time->format('h:i A') }} -
                                            {{ $latestEvent->end_time->format('h:i A') }}
                                        </small>
                                    </div>
                                </div>

                                <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                   <strong>Brief Description:</strong> {{ Str::limit($latestEvent->description, 120) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info">
                                       Poster: {{ $latestEvent->creator->name ?? 'Admin' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No upcoming events</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

