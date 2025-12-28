@extends('layouts.navbars')

@section('title', 'Edit Asset Assignment')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Asset Assignment</h1>
                        <p class="mb-0 form-text-muted">Assignment ID: ASG-{{ str_pad($asset_assign->assignment_id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="form-card-body">
                        @if (session('error'))
                            <div class="form-alert form-alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('asset-assignments.update', $asset_assign->assignment_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="form-alert form-alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <fieldset class="form-fieldset">
                                <legend>Assignment Details</legend>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="asset_id" class="form-label form-label-required">Select Asset</label>
                                        <select name="asset_id" id="asset_id" class="form-select" required>
                                            <option value="">-- Select Asset --</option>
                                            @foreach ($assets as $asset)
                                                <option value="{{ $asset->asset_id }}"
                                                    {{ old('asset_id', $asset_assign->asset_id) == $asset->asset_id ? 'selected' : '' }}>
                                                    {{ $asset->asset_code }} - {{ $asset->name }} ({{ $asset->current_condition }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('asset_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="employee_id" class="form-label form-label-required">Assign To Employee</label>
                                        <select name="employee_id" id="employee_id" class="form-select" required>
                                            <option value="">-- Select Employee --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->employee_id }}"
                                                    {{ old('employee_id', $asset_assign->employee_id) == $employee->employee_id ? 'selected' : '' }}>
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label class="form-label">Assigned By</label>
                                        <div class="form-control-static">
                                            {{ $asset_assign->assigner->name ?? auth()->user()->name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="assigned_date" class="form-label form-label-required">Assigned Date</label>
                                        <input type="date" name="assigned_date" id="assigned_date" class="form-control"
                                               value="{{ old('assigned_date', $asset_assign->assigned_date->format('Y-m-d')) }}" required>
                                        @error('assigned_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="returned_date" class="form-label">Returned Date</label>
                                        <input type="date" name="returned_date" id="returned_date" class="form-control"
                                               value="{{ old('returned_date', $asset_assign->returned_date ? $asset_assign->returned_date->format('Y-m-d') : '') }}">
                                        @error('returned_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="purpose" class="form-label form-label-required">Purpose/Reason</label>
                                        <textarea name="purpose" id="purpose" class="form-control" rows="3" required>{{ old('purpose', $asset_assign->purpose) }}</textarea>
                                        @error('purpose')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-fieldset">
                                <legend>Status & Condition</legend>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="status" class="form-label form-label-required">Status</label>
                                        <select name="status" id="status" class="form-select" required>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ old('status', $asset_assign->status) == $status->value ? 'selected' : '' }}>
                                                    {{ ucfirst($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="condition_at_assignment" class="form-label form-label-required">Asset Condition at Assignment</label>
                                        <select name="condition_at_assignment" id="condition_at_assignment" class="form-select" required>
                                            <option value="">-- Select Condition --</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->value }}"
                                                    {{ old('condition_at_assignment', $asset_assign->condition_at_assignment) == $condition->value ? 'selected' : '' }}>
                                                    {{ ucfirst($condition->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('condition_at_assignment')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="condition_at_return" class="form-label">Asset Condition at Return</label>
                                        <select name="condition_at_return" id="condition_at_return" class="form-select">
                                            <option value="">-- Select Condition (if returned) --</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->value }}"
                                                    {{ old('condition_at_return', $asset_assign->condition_at_return) == $condition->value ? 'selected' : '' }}>
                                                    {{ ucfirst($condition->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('condition_at_return')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('asset-assignments.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Assignment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
