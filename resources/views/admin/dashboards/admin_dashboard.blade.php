@extends('layouts.navbars')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="text-midnight mb-2">Admin Dashboard</h1>
                        <p class="text-muted mb-1">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">Here's a quick overview of your organization</p>
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
                        <h5 class="card-title mb-4 text-midnight">Quick Actions</h5>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('employees.index') }}" class="btn btn-midnight">
                                Manage Employees
                            </a>
                            <a href="{{ route('departments.index') }}" class="btn btn-midnight">
                                Manage Departments
                            </a>
                            <a href="{{ route('contracts.index') }}" class="btn btn-midnight">
                                Manage Contracts
                            </a>
                            <a href="{{ route('notices.index') }}" class="btn btn-midnight">
                                Manage Notices
                            </a>
                            <a href="{{ route('assets.index') }}" class="btn btn-midnight">
                                Manage Assets
                            </a>
                            <a href="{{ route('events.index') }}" class="btn btn-midnight">
                                Manage Events
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
                        <h6 class="stat-label mb-2">Total Users</h6>
                        <h2 class="stat-number mb-0">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Total Employees</h6>
                        <h2 class="stat-number mb-0">{{ $totalEmployees }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Total Departments</h6>
                        <h2 class="stat-number mb-0">{{ $totalDepartments }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body stat-card">
                        <h6 class="stat-label mb-2">Total Notices</h6>
                        <h2 class="stat-number mb-0">{{ $totalNotices }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card chart-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-midnight">Organization Overview</h5>
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="overviewChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-midnight">Quick Stats</h5>
                        <div class="d-flex flex-column gap-3">
                            <div class="quick-stat-item">
                                <div>
                                    <h6 class="mb-1 text-muted">Total Assets</h6>
                                    <h4 class="mb-0 fw-bold text-midnight">{{ $totalAssets }}</h4>
                                </div>
                            </div>

                            <div class="quick-stat-item">
                                <div>
                                    <h6 class="mb-1 text-muted">Total Events</h6>
                                    <h4 class="mb-0 fw-bold text-midnight">{{ $totalEvents }}</h4>
                                </div>
                            </div>

                            <div class="quick-stat-item">
                                <div>
                                    <h6 class="mb-1 text-muted">Total Leave Requests</h6>
                                    <h4 class="mb-0 fw-bold text-midnight">{{ $totalLeaves }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-midnight">Employee Department Distribution</h5>
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin_chart.js') }}"></script>
    <script>
        window.dashboardData = {
            totalUsers: {{ $totalUsers }},
            totalEmployees: {{ $totalEmployees }},
            totalDepartments: {{ $totalDepartments }},
            totalNotices: {{ $totalNotices }},
            totalAssets: {{ $totalAssets }},
            totalEvents: {{ $totalEvents }},
            totalLeaves:{{$totalLeaves}},
            employeesByDepartment: {!! json_encode($employeesByDepartment) !!}
        };
    </script>
@endsection
