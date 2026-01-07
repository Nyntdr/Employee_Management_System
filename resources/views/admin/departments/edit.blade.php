@extends('layouts.navbars')

@section('title', 'Edit Department')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Department</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('departments.update', $department->department_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="name" class="form-label form-label-required">Department Name</label>
                                    <input type="text" name="name" id="name"
                                           class="form-control"
                                           value="{{ old('name', $department->name) }}"
                                           required>
                                    @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="manager_id" class="form-label">Manager</label>
                                    <select name="manager_id" id="manager_id" class="form-select">
                                        <option value="">-- No Manager --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->employee_id }}"
                                                {{ old('manager_id', $department->manager_id) == $employee->employee_id ? 'selected' : '' }}>
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                                @if($employee->department)
                                                    - {{ $employee->department->name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('manager_id')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('departments.index') }}" class="form-btn-outline">
                                    Back to Departments
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Department
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
