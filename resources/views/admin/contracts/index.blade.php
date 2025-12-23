@extends('layouts.navbars')
@section('title','All Contracts')
@section('content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 header-flex">
            <div>
                <h1 class="h3 mb-0">Contract List</h1>
                <p class="text-muted mb-0">Manage employee contracts</p>
            </div>
            <a href="{{ route('contracts.create') }}" class="btn btn-primary">Add Contract</a>
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
                    <form action="{{ route('contracts.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('importFile').click()" class="btn btn-outline-primary">Import</button>
                    </form>
                    <a href="{{ route('contracts.export') }}" class="btn btn-outline-secondary">Export</a>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Employee & ID</th>
                            <th scope="col">Contract Type</th>
                            <th scope="col">Job Title</th>
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
                                <td colspan="6" class="text-center py-5">
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
    </div>

@endsection
