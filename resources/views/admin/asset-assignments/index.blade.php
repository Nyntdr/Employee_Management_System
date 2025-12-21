@extends('layouts.navbars')
@section('title', 'All Assigned Assets')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Assigned Assets</h1>
                <p class="text-muted mb-0">Manage asset assignments to employees</p>
            </div>
            <div>
                <a href="{{ route('asset-assignments.create') }}" class="btn btn-primary me-2">Assign Asset</a>
                <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">Assets</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3 import-export-row">
            <div class="col-md-6">
                <div class="d-flex gap-2 btn-gap">
                    <form action="{{ route('departments.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()" class="btn btn-outline-primary">
                            Import
                        </button>
                    </form>
                    <a href="{{ route('asset-assignments.export') }}" class="btn btn-outline-secondary">Export</a>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" width="60">S/N</th>
                            <th scope="col">Asset</th>
                            <th scope="col">Assigned To</th>
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
            </div>
        </div>
    </div>

@endsection
