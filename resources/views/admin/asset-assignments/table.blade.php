<div class="card table-card">
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col" width="60">S/N</th>
                <th scope="col">Asset</th>
                <th scope="col">Assigned To</th>
                <th scope="col">Purpose</th>
                <th scope="col">Status</th>
                <th scope="col">Condition</th>
                <th scope="col" width="120" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($asset_assigns as $asset_assign)
                <tr>
                    <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-medium">{{ $asset_assign->asset->name }}</div>
                        <small class="text-muted-small">{{ $asset_assign->asset->asset_code }}</small>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $asset_assign->employee->first_name }} {{ $asset_assign->employee->last_name }}</div>
                        <small class="text-muted-small">Assigner: {{ $asset_assign->assigner->name }}</small>
                    </td>
                    <td>{{$asset_assign->purpose}}</td>
                    <td>
                        @php
                            // Convert enum to string first
                            $status = $asset_assign->status->value ?? (string) $asset_assign->status;
                            $badgeClass = match(strtolower($status)) {
                                'returned' => 'badge-opacity-info',
                                'active' => 'badge-opacity-success',
                                'lost' => 'badge-opacity-warning',
                                'damaged' => 'badge-opacity-danger',
                                default => 'badge-opacity-secondary'
                            };
                        @endphp
                        <span class="table-badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    </td>
                    <td>
                        @php
                            // Convert enum condition to string
                            $assignedCondition = $asset_assign->condition_at_assignment->value ?? (string) $asset_assign->condition_at_assignment;
                            $returnedCondition = $asset_assign->condition_at_return->value ?? (string) $asset_assign->condition_at_return;
                        @endphp
                        @if($asset_assign->condition_at_return)
                            <div>
                                <small class="text-muted-small">Assigned:</small>
                                <span class="table-badge badge-opacity-info">
                                                {{ ucwords(str_replace('_', ' ', $assignedCondition ?? 'N/S')) }}
                                            </span>
                            </div>
                            <div class="mt-1">
                                <small class="text-muted-small">Returned:</small>
                                <span class="table-badge badge-opacity-success">
                                                {{ ucwords(str_replace('_', ' ', $returnedCondition ?? 'N/A')) }}
                                            </span>
                            </div>
                        @else
                            <span class="table-badge badge-opacity-info">
                                            {{ ucwords(str_replace('_', ' ', $assignedCondition ?? 'N/S')) }}
                                        </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('asset-assignments.edit', $asset_assign->assignment_id) }}" class="btn table-btn-sm btn-outline-primary" title="Edit Assignment">Edit</a>
                            <form action="{{ route('asset-assignments.destroy', $asset_assign->assignment_id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn table-btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this assignment?')" title="Delete Assignment">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="py-4">
                            <h5 class="text-muted">No assets assigned</h5>
                            <p class="text-muted mb-4">Get started by assigning assets to employees</p>
                            <a href="{{ route('asset-assignments.create') }}" class="btn btn-primary">
                                Assign First Asset
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($asset_assigns->hasPages())
        <div class="pagination-wrapper">
            <div class="d-flex justify-content-center">
                {{ $asset_assigns->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
</div>
