@extends('layouts.navbars')

@section('title', 'Create Contract')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Create New Contract</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('contracts.store') }}" method="POST">
                            @csrf

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
                                            @foreach ($employees as $employee)
                                                @php
                                                    $latestContract = $employee->latestContract;
                                                @endphp
                                                <option value="{{ $employee->employee_id }}"
                                                    {{ old('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                    @if ($latestContract)
                                                        - Current:
                                                        {{ ucwords(str_replace('_', ' ', $latestContract->job_title->value ?? $latestContract->job_title)) }}
                                                        ({{ ucfirst($latestContract->contract_status->value ?? $latestContract->contract_status) }})
                                                    @else
                                                        - No Existing Contract
                                                    @endif
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
                                            @foreach ($contractTypes as $type)
                                                <option value="{{ $type->value }}" {{ old('contract_type') == $type->value ? 'selected' : '' }}>
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
                                            @foreach ($jobTitles as $title)
                                                <option value="{{ $title->value }}" {{ old('job_title') == $title->value ? 'selected' : '' }}>
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
                                               value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                               value="{{ old('end_date') }}">
                                        @error('end_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="probation_period" class="form-label">Probation Period (days)</label>
                                        <input type="number" name="probation_period" id="probation_period" class="form-control"
                                               value="{{ old('probation_period', 0) }}" min="0" max="365">
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
                                                   value="{{ old('salary') }}" required min="0">
                                        </div>
                                        @error('salary')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="contract_status" class="form-label form-label-required">Contract Status</label>
                                        <select name="contract_status" id="contract_status" class="form-select" required>
                                            <option value="">Select Status</option>
                                            @foreach ($contractStatuses as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ old('contract_status', 'active') == $status->value ? 'selected' : '' }}>
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
                                    Create Contract
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .input-group {
            display: flex;
            align-items: stretch;
        }

        .input-group-text {
            background-color: var(--form-bg-light);
            border: 1px solid var(--form-border-color);
            border-right: none;
            border-radius: var(--form-radius-md) 0 0 var(--form-radius-md);
            padding: 0.75rem 0.75rem;
            color: var(--form-text-secondary);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--form-radius-md) var(--form-radius-md) 0;
        }
    </style>
@endpush
