
<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Contract Type</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="120" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($contracts as $contract)
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $contract->employee->first_name.' '.$contract->employee->last_name }}</div>
                        </td>
                        <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ ucwords(str_replace('_', ' ', $contract->contract_type->value)) }}
                                    </span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ ucwords(str_replace('_', ' ', $contract->job_title->value)) }}</span>
                        </td>
                        <td><span class="table-badge badge-opacity-info">{{$contract->working_hours}}</span></td>
                        <td> {{$contract->salary}}</td>
                        <td>
                            <span class="fw-medium">{{ $contract->start_date->format('M d, Y') }}</span>
                        </td>
                        <td>
                            @php
                                $status = $contract->contract_status->value ?? (string) $contract->contract_status;
                                $badgeClass = match(strtolower($status)) {
                                    'active' => 'badge-opacity-success',
                                    'renewed' => 'badge-opacity-success',
                                    'expired' => 'badge-opacity-warning',
                                    'terminated' => 'badge-opacity-danger',
                                    default => 'badge-opacity-secondary'
                                };
                            @endphp
                            <span class="table-badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('contracts.edit', $contract->contract_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Contract">Edit</a>
                                <form action="{{ route('contracts.destroy', $contract->contract_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this contract?')" title="Delete Contract">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No contracts found</h5>
                                <p class="text-muted mb-4">Get started by adding a new contract</p>
                                <a href="{{ route('contracts.create') }}" class="btn btn-primary">Add First Contract</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($contracts->hasPages())
            <div class="pagination-wrapper">
                <div class="d-flex justify-content-center">
                    {{ $contracts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
