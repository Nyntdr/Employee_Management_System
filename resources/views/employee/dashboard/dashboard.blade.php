@extends('layouts.employee_navbar')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Employee Dashbaord</h1>
            <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p>Here's a quick stats on some of your employee stuffs.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Leaves Taken</h6>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Active Days</h6>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Salary</h6>
                    
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Notices</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Assets</h6>
                   
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Events</h6>
                    
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
                        <a href="#" class="btn btn-primary">View Events</a>
                        <a href="#" class="btn btn-primary">View Notices</a>
                        <a href="#" class="btn btn-primary">Request Asset</a>
                        <a href="#" class="btn btn-primary">Request Leave</a>
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