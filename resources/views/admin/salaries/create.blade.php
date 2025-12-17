@extends('layouts.navbars')

@section('title', 'Add Salary Record')

@section('content')
    <h2>Add New Salary Record</h2>

    <form action="{{ route('payrolls.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
            @error('employee_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="month_year">Month Year (e.g 2025-12)</label>
            <input type="month" name="month_year" id="month_year" class="form-control" value="{{ old('month_year') }}" required>
            @error('month_year')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="basic_salary">Basic Salary</label>
            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" value="{{ old('basic_salary') }}" required>
            @error('basic_salary')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="overtime_pay">Overtime Pay</label>
            <input type="number" step="0.01" name="overtime_pay" id="overtime_pay" class="form-control" value="{{ old('overtime_pay', 0) }}">
            @error('overtime_pay')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" step="0.01" name="bonus" id="bonus" class="form-control" value="{{ old('bonus', 0) }}">
            @error('bonus')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="deductions">Deductions</label>
            <input type="number" step="0.01" name="deductions" id="deductions" class="form-control" value="{{ old('deductions', 0) }}">
            @error('deductions')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" 
                        {{ old('status') == $status->value || $status->value == 'active' ? 'selected' : '' }}>
                        {{ ucfirst($status->value) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="paid_date">Paid Date (if paid)</label>
            <input type="date" name="paid_date" id="paid_date" class="form-control" value="{{ old('paid_date') }}">
            @error('paid_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Salary Record</button>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection