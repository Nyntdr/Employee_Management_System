@extends('layouts.navbars')
@section('title','All Employees')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Employees</h1>
        <div>
            <a href="{{ route('employees.create') }}" class="btn btn-primary me-2">Add Employee</a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Roles</a>
        </div>
    </div>

    @if($employees->count() > 0)
        <div class="row">
            @foreach($employees as $employee)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($employee->user->profile_picture)
                                        <img src="{{ asset('storage/'.$employee->user->profile_picture) }}" class="rounded-circle border" width="60" height="60" alt="{{ $employee->first_name }}">
                                    @else
                                        <img src="{{ asset('images/icon.jpg') }}" class="rounded-circle border" width="60" height="60" alt="{{ $employee->first_name }}">
                                    @endif
                                </div>
                                <div class="flex">
                                    <h5 class="card-title mb-1">{{ $employee->first_name.' '.$employee->last_name }}</h5>
                                    <span class="badge bg-info">{{ $employee->user->role->role_name }}</span>
                                    <span class="badge bg-secondary ms-1">{{ $employee->gender }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Contact Information</h6>
                                <p class="mb-1"><strong>Phone:</strong> {{ $employee->phone }}</p>
                                <p class="mb-1"><strong>Secondary:</strong> {{ $employee->secondary_phone }}</p>
                                <p class="mb-0"><strong>Emergency:</strong> {{ $employee->emergency_contact }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Employment Details</h6>
                                <p class="mb-1"><strong>Position:</strong> {{ $employee->contracts()->latest()->first()->job_title ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ $employee->contracts()->latest()->first()->contract_status ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Personal Details</h6>
                                <p class="mb-1"><strong>DOB:</strong> {{ $employee->date_of_birth->format('F j, Y') }}</p>
                                <p class="mb-0"><strong>DOJ:</strong> {{ $employee->date_of_joining->format('F j, Y') }}</p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('employees.edit',$employee->employee_id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('employees.destroy',$employee->employee_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $employee->first_name }} {{ $employee->last_name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="text-muted mb-3">No employees found.</h4>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Your First Employee</a>
        </div>
    @endif
</div>
@endsection