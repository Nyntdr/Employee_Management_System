<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Employee & ID</th>
                    <th scope="col">Month Year</th>
                    <th scope="col">Basic Salary</th>
                    <th scope="col">Overtime Pay</th>
                    <th scope="col">Bonuses</th>
                    <th scope="col">Deductions</th>
                    <th scope="col">Net Salary</th>
                    <th scope="col">Paid Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Generator</th>
                    <th scope="col" width="120" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payrolls as $payroll)
                    @php
                        $overtimePay = $payroll->overtime_pay ?? 0;
                        $bonuses = $payroll->bonus ?? 0;
                        $deductions = $payroll->deductions ?? 0;
                        $netSalary = $payroll->basic_salary + $overtimePay + $bonuses - $deductions;
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</div>
                            <div class="text-muted small">EMP-{{ $payroll->employee->employee_id }}</div>
                        </td>
                        <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ $payroll->month_year->format('M Y') }}
                                    </span>
                        </td>
                        <td>
                            <span class="fw-semibold">NPR {{ number_format($payroll->basic_salary, 2) }}</span>
                        </td>
                        <td>
                            <span class="text-warning fw-semibold">+ NPR {{ number_format($overtimePay, 2) }}</span>
                        </td>
                        <td>
                            <span class="text-success fw-semibold">+ NPR {{ number_format($bonuses, 2) }}</span>
                        </td>
                        <td>
                            <span class="text-danger fw-semibold">- NPR {{ number_format($deductions, 2) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">NPR {{ number_format($netSalary, 2) }}</span>
                        </td>
                        <td>
                            @if($payroll->paid_date)
                                <span class="text-muted">{{ $payroll->paid_date->format('M d, Y') }}</span>
                            @else
                                <span class="table-badge badge-opacity-secondary">Not Paid</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $status = $payroll->payment_status->value ?? (string) $payroll->payment_status;
                                $badgeClass = match(strtolower($status)) {
                                    'paid' => 'badge-opacity-success',
                                    'pending' => 'badge-opacity-warning',
                                    'failed' => 'badge-opacity-danger',
                                    'cancelled' => 'badge-opacity-secondary',
                                    default => 'badge-opacity-secondary'
                                };
                            @endphp
                            <span class="table-badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                        </td>
                        <td><span class="table-badge badge-opacity-primary">{{$payroll->generator->name}}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('payrolls.edit', $payroll->payroll_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Salary Record">Edit</a>
                                <form action="{{ route('payrolls.destroy', $payroll->payroll_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this salary record?')" title="Delete Salary Record">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No salary records found</h5>
                                <p class="text-muted mb-4">Get started by adding salary records</p>
                                <a href="{{ route('payrolls.create') }}" class="btn btn-primary">Add First Salary Record</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($payrolls->hasPages())
            <div class="pagination-wrapper">
                <div class="d-flex justify-content-center">
                    {{ $payrolls->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
