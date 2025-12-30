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
                                <button type="submit" class="btn btn-success px-4">
                                    Clock In
                                </button>
                            </form>

                            <form action="{{ route('clockout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning px-4">
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
                        <h6 class="stat-label mb-2">Assets Taken</h6>
                        <h2 class="stat-number mb-0">{{ $totalAssets }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Leaves Taken</h6>
                        <h2 class="stat-number mb-0">{{ $totalLeaves }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Total Notices</h6>
                        <h2 class="stat-number mb-0">{{ $totalNotices ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Total Events</h6>
                        <h2 class="stat-number mb-0">{{ $totalEvents ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
