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
                    <th scope="col" width="200" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payrolls as $payroll)
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
                            <span class="fw-semibold">NPR {{$payroll->basic_salary}}</span>
                        </td>
                        <td>
                            <span class="text-warning fw-semibold">+ NPR {{ $payroll->overtime_pay}}</span>
                        </td>
                        <td>
                            <span class="text-success fw-semibold">+ NPR {{ $payroll->bonus }}</span>
                        </td>
                        <td>
                            <span class="text-danger fw-semibold">- NPR {{ $payroll->deductions }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">NPR {{ $payroll->net_salary}}</span>
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
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('payrolls.edit', $payroll->payroll_id) }}" class="btn table-btn-sm btn-outline-primary py-1 px-2" title="Edit Salary Record">Edit</a>
                                    <form action="{{ route('payrolls.destroy', $payroll->payroll_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn table-btn-sm btn-outline-danger py-1 px-2" onclick="return confirm('Are you sure you want to delete this salary record?')" title="Delete Salary Record">Delete</button>
                                    </form>
                                </div>

                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('payrolls.payslip', $payroll->payroll_id) }}" class="btn table-btn-sm btn-outline-success py-1 px-2" target="_blank">Payslip</a>
                                    <form action="{{ route('payrolls.email', $payroll->payroll_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn table-btn-sm btn-outline-info py-1 px-2" onclick="return confirm('Send payslip to {{ $payroll->employee->user->email }}?')" title="Send via email">Email</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No salary records found</h5>
                                <p class="text-muted mb-4">Get started by adding salary records</p>
                                <a href="{{ route('payrolls.create') }}" class="btn btn-midnight">Add First Salary Record</a>
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
