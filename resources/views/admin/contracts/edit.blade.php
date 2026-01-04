@extends('layouts.navbars')

@section('title', 'Edit Contract')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Contract</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('contracts.update', $contract->contract_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="form-alert form-alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <fieldset class="form-fieldset">
                                <legend>Contract Information</legend>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="employee_id" class="form-label form-label-required">Employee</label>
                                        <select name="employee_id" id="employee_id" class="form-select" required>
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->employee_id }}" {{ old('employee_id', $contract->employee_id) == $employee->employee_id ? 'selected' : '' }}>
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="contract_type" class="form-label form-label-required">Contract Type</label>
                                        <select name="contract_type" id="contract_type" class="form-select" required>
                                            <option value="">Select Contract Type</option>
                                            @foreach($contractTypes as $type)
                                                @php
                                                    // Get the current value for comparison
                                                    $currentContractType = old('contract_type', $contract->contract_type->value);
                                                @endphp
                                                <option value="{{ $type->value }}"
                                                    {{ $currentContractType == $type->value ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $type->value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('contract_type')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="job_title" class="form-label form-label-required">Job Title</label>
                                        <select name="job_title" id="job_title" class="form-select" required>
                                            <option value="">Select Job Title</option>
                                            @foreach($jobTitles as $title)
                                                @php
                                                    // Get the current value for comparison
                                                    $currentJobTitle = old('job_title', $contract->job_title->value);
                                                @endphp
                                                <option value="{{ $title->value }}"
                                                    {{ $currentJobTitle == $title->value ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $title->value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('job_title')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="start_date" class="form-label form-label-required">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                               value="{{ old('start_date', $contract->start_date ? $contract->start_date->format('Y-m-d') : '') }}" required>
                                        @error('start_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                               value="{{ old('end_date', $contract->end_date ? $contract->end_date->format('Y-m-d') : '') }}">
                                        @error('end_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="probation_period" class="form-label">Probation Period (days)</label>
                                        <input type="number" name="probation_period" id="probation_period" class="form-control"
                                               value="{{ old('probation_period', $contract->probation_period) }}" min="0" max="365">
                                        @error('probation_period')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="salary" class="form-label form-label-required">Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" step="0.01" name="salary" id="salary" class="form-control"
                                                   value="{{ old('salary', $contract->salary) }}" required min="0">
                                        </div>
                                        @error('salary')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="contract_status" class="form-label form-label-required">Contract Status</label>
                                        <select name="contract_status" id="contract_status" class="form-select" required>
                                            <option value="">Select Status</option>
                                            @foreach($contractStatuses as $status)
                                                @php
                                                    // Get the current value for comparison
                                                    $currentContractStatus = old('contract_status', $contract->contract_status->value);
                                                @endphp
                                                <option value="{{ $status->value }}"
                                                    {{ $currentContractStatus == $status->value ? 'selected' : '' }}>
                                                    {{ ucfirst($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('contract_status')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('contracts.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Contract
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
