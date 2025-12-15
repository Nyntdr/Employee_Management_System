create
@extends('layouts.navbars')
@section('title', 'Create Contract')
@section('content')

<div class="container">
    <h1>Create New Contract</h1>
    
    <form action="{{ route('contracts.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="employee_id">Employee*</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->employee_id }}" {{ old('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="contract_type">Contract Type *</label>
            <select name="contract_type" id="contract_type" class="form-control" required>
                <option value="">Select Contract Type</option>
                @foreach($contractTypes as $type)
                    <option value="{{ $type->value }}" {{ old('contract_type') == $type->value ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                    </option>
                @endforeach
            </select>
            @error('contract_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="job_title">Job Title *</label>
            <select name="job_title" id="job_title" class="form-control" required>
                <option value="">Select Job Title</option>
                @foreach($jobTitles as $title)
                    <option value="{{ $title->value }}" {{ old('job_title') == $title->value ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $title->value)) }}
                    </option>
                @endforeach
            </select>
            @error('job_title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" 
                           value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" 
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="probation_period">Probation Period (days)</label>
                    <input type="number" name="probation_period" id="probation_period" class="form-control" 
                           value="{{ old('probation_period', 0) }}" min="0" max="365">
                    @error('probation_period')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="working_hours">Working Hours</label>
                    <input type="text" name="working_hours" id="working_hours" class="form-control" 
                           value="{{ old('working_hours') }}" placeholder=" Eg: 9AM - 5PM">
                    @error('working_hours')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="salary">Salary *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rs</span>
                        </div>
                        <input type="number" step="0.01" name="salary" id="salary" class="form-control" 
                               value="{{ old('salary') }}" required min="0">
                    </div>
                    @error('salary')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contract_status">Contract Status *</label>
                    <select name="contract_status" id="contract_status" class="form-control" required>
                        <option value="">Select Status</option>
                        @foreach($contractStatuses as $status)
                            <option value="{{ $status->value }}" {{ old('contract_status', 'active') == $status->value ? 'selected' : '' }}>
                                {{ ucfirst($status->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('contract_status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Contract</button>
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@endsection