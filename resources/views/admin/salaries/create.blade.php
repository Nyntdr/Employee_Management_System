@extends('layouts.navbars')

@section('title', 'Add Salary Record')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Add New Salary Record</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('payrolls.store') }}" method="POST">
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

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="employee_id" class="form-label form-label-required">Employee</label>
                                    <select name="employee_id" id="employee_id" class="form-select" required>
                                        <option value="">-- Select Employee --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->employee_id }}" {{ old('employee_id') == $employee->employee_id ? 'selected' : '' }}>
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
                                <div class="form-col-12">
                                    <label for="month_year" class="form-label form-label-required">Month Year (YYYY-MM)</label>
                                    <input type="month" name="month_year" id="month_year" class="form-control"
                                           value="{{ old('month_year') }}" required>
                                    @error('month_year')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="basic_salary" class="form-label form-label-required">Basic Salary</label>
                                    <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control"
                                           value="{{ old('basic_salary') }}" required>
                                    @error('basic_salary')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="overtime_pay" class="form-label">Overtime Pay</label>
                                    <input type="number" step="0.01" name="overtime_pay" id="overtime_pay" class="form-control"
                                           value="{{ old('overtime_pay', 0) }}">
                                    @error('overtime_pay')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="bonus" class="form-label">Bonus</label>
                                    <input type="number" step="0.01" name="bonus" id="bonus" class="form-control"
                                           value="{{ old('bonus', 0) }}">
                                    @error('bonus')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="deductions" class="form-label">Deductions</label>
                                    <input type="number" step="0.01" name="deductions" id="deductions" class="form-control"
                                           value="{{ old('deductions', 0) }}">
                                    @error('deductions')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="status" class="form-label form-label-required">Status</label>
                                    <select name="payment_status" id="status" class="form-select" required>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('status') == $status->value || $status->value == 'active' ? 'selected' : '' }}>
                                                {{ ucfirst($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_status')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="paid_date" class="form-label">Paid Date (if paid)</label>
                                    <input type="date" name="paid_date" id="paid_date" class="form-control"
                                           value="{{ old('paid_date') }}">
                                    @error('paid_date')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('payrolls.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Save Salary Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
