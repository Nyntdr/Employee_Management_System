@extends('layouts.employee_navbar')

@section('title', 'Leave Request')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Request Leave</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('leave-requests.store') }}" method="POST">
                            @csrf
                            <fieldset class="form-fieldset">
                                <legend>Leave Details</legend>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="leave_type_id" class="form-label form-label-required">Leave Type</label>
                                        <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                                            <option value="">Select Leave Type</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }} ({{$type->max_days_per_year}} days per year)
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
                                        <input type="date" name="start_date" id="start_date"
                                               class="form-control" value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="end_date" class="form-label form-label-required">End Date</label>
                                        <input type="date" name="end_date" id="end_date"
                                               class="form-control" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="reason" class="form-label form-label-required">Reason</label>
                                        <textarea name="reason" id="reason" rows="4"
                                                  class="form-control" required>{{ old('reason') }}</textarea>
                                        @error('reason')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('employee.leaves.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Request Leave
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
