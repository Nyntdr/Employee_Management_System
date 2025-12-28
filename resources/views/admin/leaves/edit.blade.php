@extends('layouts.navbars')

@section('title', 'Edit Leave')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Leave</h1>
                        <p class="mb-0 form-text-muted">Leave ID: LV-{{ str_pad($leave->leave_id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('leaves.update', $leave->leave_id) }}" method="POST">
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

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="employee_id" class="form-label form-label-required">Employee</label>
                                    <select name="employee_id" id="employee_id" class="form-select" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->employee_id }}" {{ old('employee_id', $leave->employee_id) == $employee->employee_id ? 'selected' : '' }}>
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
                                    <label for="leave_type_id" class="form-label form-label-required">Leave Type</label>
                                    <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                                        <option value="">Select Leave Type</option>
                                        @foreach($leaveTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('leave_type_id', $leave->leave_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leave_type_id')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-6">
                                    <label for="start_date" class="form-label form-label-required">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                           value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-col-6">
                                    <label for="end_date" class="form-label form-label-required">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                           value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="reason" class="form-label form-label-required">Reason</label>
                                    <textarea name="reason" id="reason" rows="4" class="form-control" required>{{ old('reason', $leave->reason) }}</textarea>
                                    @error('reason')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" {{ old('status', $leave->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $leave->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $leave->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="cancelled" {{ old('status', $leave->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('leaves.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Leave
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
