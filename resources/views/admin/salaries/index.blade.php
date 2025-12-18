@extends('layouts.navbars')
@section('title','Salaries')
@section('content')
<h2>Salary Records</h2>
<a href="{{ route('payrolls.create') }}">Add salary record</a>
<table border="1">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Month Year</th> 
            <th>Basic Salary</th>
            <th>Overtime Pay</th>
            <th>Bonus</th>
            <th>Deductions</th>
            <th>Net Salary</th>
             <th>Paid Date</th>
            <th>Status</th>
            <th>Generator</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payrolls as $payroll)
            <tr>
                <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                <td>{{ $payroll->month_year->format('Y-m') }}</td>
                <td>{{ $payroll->basic_salary }}</td>
                <td>{{ $payroll->overtime_pay }}</td>
                <td>{{ $payroll->bonus }}</td>
                <td>{{ $payroll->deductions }}</td>
                <td>{{ $payroll->net_salary }}</td>
                <td>{{ $payroll->paid_date?->format('M d, Y') ?? 'N/A'}}</td>
                <td>{{ ucwords($payroll->payment_status->value) }}</td>
                <td>{{ $payroll->generator->name}}</td>
                <td>
                    <a href="{{ route('payrolls.edit',$payroll->payroll_id) }}">Edit</a>
                    <br>
                    <form action="{{ route('payrolls.destroy',$payroll->payroll_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this payroll?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11">No payrolls made yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection