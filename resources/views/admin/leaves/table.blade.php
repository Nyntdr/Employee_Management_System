
<div class="card table-card">
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col">Employee & ID</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Reason</th>
                <th scope="col">Approver</th>
                <th scope="col">Status</th>
                <th scope="col">Days</th>
                <th>Requested Date</th>
                <th scope="col" width="120" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($leaves as $leave)
                @php
                    $daysCount = $leave->start_date->diffInDays($leave->end_date) + 1;
                @endphp
                <tr>
                    <td>
                        <div class="fw-medium">{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</div>
                        <div class="text-muted small">EMP-{{ $leave->employee->employee_id }}</div>
                    </td>
                    <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ $leave->leaveType->name }}
                                    </span>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $leave->start_date->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $leave->end_date->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <div class="text-muted" style="max-width: 200px; line-height: 1.4;">
                            {{ Str::limit($leave->reason, 80) }}
                        </div>
                    </td>
                    <td>
                                    <span class="table-badge badge-opacity-primary">
                                        {{ $leave->approver->name ?? 'N/A' }}
                                    </span>
                    </td>
                    <td>
                        @php
                            $status = $leave->status->value ?? (string) $leave->status;
                            $badgeClass = match(strtolower($status)) {
                                'approved' => 'badge-opacity-success',
                                'pending' => 'badge-opacity-warning',
                                'rejected' => 'badge-opacity-danger',
                                'cancelled' => 'badge-opacity-secondary',
                                default => 'badge-opacity-secondary'
                            };
                        @endphp
                        <span class="table-badge {{ $badgeClass }}">
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </span>
                    </td>
                    <td>
                        <span class="fw-bold">{{ $daysCount }} day{{ $daysCount > 1 ? 's' : '' }}</span>
                    </td>
                    <td>
                        {{$leave->created_at->diffForHumans()}}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('leaves.edit', $leave->leave_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Leave">Edit</a>
                            <form action="{{ route('leaves.destroy', $leave->leave_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this leave record?')" title="Delete Leave">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="py-4">
                            <h5 class="text-muted">No leave records found</h5>
                            <p class="text-muted mb-4">Get started by adding a leave record</p>
                            <a href="{{ route('leaves.create') }}" class="btn btn-midnight">Add First Leave</a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($leaves->hasPages())
        <div class="pagination-wrapper">
            <div class="d-flex justify-content-center">
                {{ $leaves->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
</div>
