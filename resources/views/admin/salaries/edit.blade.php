@extends('layouts.navbars')

@section('title', 'Edit Salary Record')

@section('content')
    <h2>Edit Salary Record</h2>

    <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Employee</label>
            <p>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
        </div>

        <div class="form-group">
            <label for="month_year">Month Year</label>
            <input type="month" name="month_year" id="month_year" class="form-control" value="{{ old('month_year', $payroll->month_year) }}" required>
            @error('month_year')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="basic_salary">Basic Salary</label>
            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" value="{{ old('basic_salary', $payroll->basic_salary) }}" required>
            @error('basic_salary')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="overtime_pay">Overtime Pay</label>
            <input type="number" step="0.01" name="overtime_pay" id="overtime_pay" class="form-control" value="{{ old('overtime_pay', $payroll->overtime_pay) }}">
            @error('overtime_pay')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" step="0.01" name="bonus" id="bonus" class="form-control" value="{{ old('bonus', $payroll->bonus) }}">
            @error('bonus')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="deductions">Deductions</label>
            <input type="number" step="0.01" name="deductions" id="deductions" class="form-control" value="{{ old('deductions', $payroll->deductions) }}">
            @error('deductions')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="paid" {{ old('status', $payroll->status->value) == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ old('status', $payroll->status->value) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ old('status', $payroll->status->value) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="paid_date">Paid Date</label>
            <input type="date" name="paid_date" id="paid_date" class="form-control" 
                   value="{{ old('paid_date', $payroll->paid_date?->format('Y-m-d')) }}">
            @error('paid_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Salary Record</button>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection