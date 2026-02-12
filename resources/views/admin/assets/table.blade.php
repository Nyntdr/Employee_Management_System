<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col" width="60">S/N</th>
                    <th scope="col">Asset Code</th>
                    <th scope="col">Asset Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Category</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Warranty Until</th>
                    <th scope="col">Status</th>
                    <th scope="col">Condition</th>
                    <th scope="col" width="120" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($assets as $asset)
                    <tr>
                        <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                        <td>
                            <span class="table-badge badge-opacity-primary">{{ $asset->asset_code }}</span> <br>
                            <small class="text-muted-small">{{ $asset->serial_number}}</small>
                        </td>
                        <td>
                            <div class="fw-medium">{{ $asset->name }}</div>
                            <small class="text-muted-small">{{ $asset->brand ?? 'N/A' }}
                                | {{ $asset->model ?? 'N/A' }}</small>
                        </td>
                        <td>
                                    <span class="table-badge badge-opacity-info">
                                        {{ ucfirst($asset->type->value ?? $asset->type) }}
                                    </span>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $asset->category ?? 'N/A' }}</span>
                        </td>
                        <td>
                            @if($asset->purchase_date)
                                <span
                                    class="fw-medium">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('M d, Y') }}</span>
                                <br>
                                <small class="text-muted-small">NPR {{ $asset->purchase_cost ?? 'N/A'}}</small>
                            @else
                                <span class="table-badge badge-opacity-secondary">N/A</span>
                                <br>
                                <small class="text-muted-small">NPR {{ $asset->purchase_cost ?? 'N/A'}}</small>
                            @endif
                        </td>
                        <td>
                            @if($asset->warranty_until)
                                <span
                                    class="fw-medium">{{ \Carbon\Carbon::parse($asset->warranty_until)->format('M d, Y') }}</span>
                                <br><small
                                    class="text-muted-small"> {{  \Carbon\Carbon::parse($asset->warranty_until)->diffForHumans()}}</small>
                            @else
                                <span class="table-badge badge-opacity-secondary">No Warranty</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $status = is_object($asset->status) ? $asset->status->value : $asset->status;
                                $badgeClass = match(strtolower((string) $status)) {
                                    'available'     => 'badge-opacity-success',
                                    'assigned'      => 'badge-opacity-info',
                                    'requested'     => 'badge-opacity-danger',
                                    'under_repair'  => 'badge-opacity-warning',
                                    default         => 'badge-opacity-secondary'
                                };
                            @endphp

                            <span class="table-badge {{ $badgeClass }}">{{ ucwords(str_replace('_', ' ', $status)) }}</span>

                            @if(strtolower($status) === 'requested')
                                <div class="mt-1 small text-muted">
                                    <strong>By:</strong>
                                    {{ $asset->requestedBy ? $asset->requestedBy->full_name : 'Unknown' }}
                                    <br>
                                    <strong>Reason:</strong>
                                    {{ $asset->request_reason ?? 'Not provided' }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $condition = is_object($asset->current_condition) ? $asset->current_condition->value : $asset->current_condition;
                                $conditionBadgeClass = match(strtolower((string) $condition)) {
                                    'excellent' => 'badge-opacity-success',
                                    'good' => 'badge-opacity-info',
                                    'fair' => 'badge-opacity-warning',
                                    'poor' => 'badge-opacity-danger',
                                    'damaged' => 'badge-opacity-dark',
                                    default => 'badge-opacity-secondary'
                                };
                            @endphp
                            <span
                                class="table-badge {{ $conditionBadgeClass }}">{{ ucfirst($condition) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('assets.edit', $asset->asset_id) }}"
                                   class="btn table-btn-sm btn-outline-primary" title="Edit Asset">Edit</a>
                                <form action="{{ route('assets.destroy', $asset->asset_id) }}" method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn table-btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this asset?')"
                                            title="Delete Asset">Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="py-4">
                                <h5 class="text-muted">No assets found</h5>
                                <p class="text-muted mb-4">Get started by adding your first asset</p>
                                <a href="{{ route('assets.create') }}" class="btn btn-midnight">Add First Asset</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($assets->hasPages())
            <div class="pagination-wrapper">
                <div class="d-flex justify-content-center">
                    {{ $assets->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
