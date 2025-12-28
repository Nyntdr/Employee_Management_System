@extends('layouts.navbars')

@section('title', 'Edit Attendance')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Attendance</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('attendances.update', $attendance->attendance_id) }}" method="POST">
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
                                    <select name="employee_id" id="employee_id" class="form-select" required {{ $attendance->employee_id ? 'disabled' : '' }}>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->employee_id }}"
                                                {{ $attendance->employee_id == $employee->employee_id ? 'selected' : '' }}>
                                                (EM-{{ $employee->employee_id }}) {{ $employee->first_name }} {{ $employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($attendance->employee_id)
                                        <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                                    @endif
                                    @error('employee_id')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="date" class="form-label form-label-required">Date</label>
                                    <input type="date" name="date" id="date" class="form-control"
                                           value="{{ old('date', $attendance->date ? $attendance->date->format('Y-m-d') : date('Y-m-d')) }}" required>
                                    @error('date')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-6">
                                    <label for="clock_in" class="form-label">Clock In</label>
                                    <input type="time" name="clock_in" id="clock_in" class="form-control"
                                           value="{{ old('clock_in', $attendance->clock_in ? $attendance->clock_in->format('H:i') : '') }}">
                                    @error('clock_in')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-col-6">
                                    <label for="clock_out" class="form-label">Clock Out</label>
                                    <input type="time" name="clock_out" id="clock_out" class="form-control"
                                           value="{{ old('clock_out', $attendance->clock_out ? $attendance->clock_out->format('H:i') : '') }}">
                                    @error('clock_out')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="status" class="form-label form-label-required">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('status', $attendance->status) == $status->value ? 'selected' : '' }}>
                                                {{ ucfirst($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('attendances.index') }}" class="form-btn-outline">
                                    Back to List
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Attendance
                                </button>
                                <button type="reset" class="form-btn-outline">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
