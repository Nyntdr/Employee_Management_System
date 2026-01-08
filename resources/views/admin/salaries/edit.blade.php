@extends('layouts.navbars')

@section('title', 'Edit Salary Record')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Salary Record</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('payrolls.update', $payroll->payroll_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-col-12">
                                    <label class="form-label">Employee</label>
                                    <p>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
                                    <input type="hidden" name="employee_id" value="{{ $payroll->employee_id }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    @php
                                        $monthYear = substr(old('month_year', $payroll->month_year), 0, 7);
                                    @endphp
                                    <label for="month_year" class="form-label form-label-required">Month Year (YYYY-MM)</label>
                                    <input type="month" name="month_year" id="month_year" class="form-control"
                                           value="{{ $monthYear }}" required>
                                    @error('month_year')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="overtime_pay" class="form-label">Overtime Pay</label>
                                    <input type="number" step="10" name="overtime_pay" id="overtime_pay" class="form-control"
                                           value="{{ old('overtime_pay', $payroll->overtime_pay) }}" min="0">
                                    @error('overtime_pay')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="bonus" class="form-label">Bonus</label>
                                    <input type="number" step="10" name="bonus" id="bonus" class="form-control"
                                           value="{{ old('bonus', $payroll->bonus) }}" min="0">
                                    @error('bonus')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="deductions" class="form-label">Deductions</label>
                                    <input type="number" step="10" name="deductions" id="deductions" class="form-control"
                                           value="{{ old('deductions', $payroll->deductions) }}" min="0">
                                    @error('deductions')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="payment_status" class="form-label form-label-required">Payment Status</label>
                                    <select name="payment_status" id="payment_status" class="form-select" required>
                                        <option value="">-- Select Status --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('payment_status', $payroll->payment_status->value) == $status->value ? 'selected' : '' }}>
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
                                    <label for="paid_date" class="form-label">Paid Date</label>
                                    <input type="date" name="paid_date" id="paid_date" class="form-control"
                                           value="{{ old('paid_date', $payroll->paid_date ? $payroll->paid_date->format('Y-m-d') : '') }}">
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
                                    Update Salary Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
