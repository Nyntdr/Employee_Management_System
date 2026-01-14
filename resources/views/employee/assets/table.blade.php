<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Asset Details</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Condition at Assignment</th>
                    <th scope="col">Assigner</th>
                </tr>
                </thead>
                <tbody>
                @forelse($asset_assigns as $asset_assign)
                    @php
                        $status = is_object($asset_assign->status) ? $asset_assign->status->value : $asset_assign->status;
                        $condition = is_object($asset_assign->condition_at_assignment)
                            ? $asset_assign->condition_at_assignment->value
                            : $asset_assign->condition_at_assignment ?? 'N/A';

                        $statusBadgeClass = match(strtolower((string) $status)) {
                            'active' => 'badge-opacity-success',
                            'returned' => 'badge-opacity-info',
                            'lost' => 'badge-opacity-danger',
                            'damaged' => 'badge-opacity-warning',
                            default => 'badge-opacity-secondary'
                        };

                        $conditionBadgeClass = match(strtolower((string) $condition)) {
                            'new' => 'badge-opacity-success',
                            'good' => 'badge-opacity-primary',
                            'fair' => 'badge-opacity-warning',
                            'poor' => 'badge-opacity-danger',
                            default => 'badge-opacity-secondary'
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $asset_assign->asset->asset_code }} - {{ $asset_assign->asset->name }}</div>
                            <div class="text-muted small">{{ $asset_assign->asset->category ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="text-muted" style="max-width: 200px; line-height: 1.4;">
                                {{ Str::limit($asset_assign->purpose, 80) }}
                            </div>
                        </td>
                        <td>
                                <span class="table-badge {{ $statusBadgeClass }}">
                                    {{ ucwords($status) }}
                                </span>
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
                        <td>
                                <span class="table-badge badge-opacity-primary">
                                    {{ $asset_assign->assigner->name }}
                                </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No assets assigned</h5>
                                <p class="text-muted mb-4">You don't have any assets assigned to you</p>
                                <a href="{{route('asset-requests.index')}}" class="btn btn-midnight">
                                    Request Asset
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
