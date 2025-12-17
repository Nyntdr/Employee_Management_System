@extends('layouts.navbars')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Admin Dashbaord</h1>
            <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p>Your clock in clock out.</p>
             @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div style="display: flex;">
                    <form action="{{ route('clockin') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Clock in</button>
                    </form>

                    <form action="{{ route('clockout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">Clock Out</button>
                    </form>
                </div>
                <p>Here's a quick stats on some employee related stuff.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Users</h6>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Employees</h6>
                    <h2 class="mb-0">{{ $totalEmployees }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Departments</h6>
                    <h2 class="mb-0">{{ $totalDepartments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Notices</h6>
                    <h2 class="mb-0">{{ $totalNotices }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Assets</h6>
                    <h2 class="mb-0">{{ $totalAssets }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Events</h6>
                    <h2 class="mb-0">{{ $totalEvents }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Quick Links</h5>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('employees.index') }}" class="btn btn-primary">Manage Employees</a>
                        <a href="{{ route('departments.index') }}" class="btn btn-primary">Manage Departments</a>
                        <a href="{{ route('contracts.index') }}" class="btn btn-primary">Manage Contracts</a>
                        <a href="{{ route('notices.index') }}" class="btn btn-primary">Manage Notice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 24px;
    }
    
    .card-body {
        padding: 1.5rem;
    }
</style>
@endsection