<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Leave Type</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Approver</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total Days</th>
                    <th scope="col">Created on</th>
                </tr>
                </thead>
                <tbody>
                @forelse($leaves as $leave)
                    @php
                        $daysCount = $leave->start_date->diffInDays($leave->end_date) + 1;
                        $status = $leave->status->value ?? (string) $leave->status;
                        $badgeClass = match(strtolower($status)) {
                            'approved' => 'badge-opacity-success',
                            'pending' => 'badge-opacity-warning',
                            'rejected' => 'badge-opacity-danger',
                            'cancelled' => 'badge-opacity-secondary',
                            default => 'badge-opacity-secondary'
                        };
                    @endphp
                    <tr>
                        <td>
                                <span class="table-badge badge-opacity-info">
                                    {{ $leave->leaveType->name }}
                                </span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $leave->start_date->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $leave->end_date->format('M d, Y')}}</span>
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
                                <span class="table-badge {{ $badgeClass }}">
                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                </span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $daysCount }} day{{ $daysCount > 1 ? 's' : '' }}</span>
                        </td>
                        <td>
                            {{$leave->created_at->format('Y-m-d')}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No leave requests found</h5>
                                <p class="text-muted mb-4">Get started by requesting your first leave</p>
                                <a href="{{route('leave-requests.create')}}" class="btn btn-primary">Request First Leave</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
