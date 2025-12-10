@extends('layouts.navbars')

@section('title', 'Add Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Add Employee</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('employees.store') }}">
                            @csrf
                            <fieldset class="mb-4">
                                <legend>User Account Details</legend>
                                <div class="mb,mb-3">
                                    <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select name="role_id" id="role_id" class="form-select" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                            </fieldset>

                            <hr>

                            <fieldset class="mb-4">
                                <legend>Employee Personal & Job Details</legend>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-select" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Contact Number<span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" maxlength="20" required>
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="secondary_phone" class="form-label">Secondary Contact Number</label>
                                    <input type="text" name="secondary_phone" id="secondary_phone" class="form-control" value="{{ old('secondary_phone') }}" maxlength="20">
                                    @error('secondary_phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact<span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact" id="emergency_contact" class="form-control"
                                           value="{{ old('emergency_contact') }}" placeholder="e.g. John Doe (Father - 9876543210)" maxlength="150" required>
                                    @error('emergency_contact')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
                                    @error('dob')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="doj" class="form-label">Date of Joining <span class="text-danger">*</span></label>
                                    <input type="date" name="doj" id="doj" class="form-control" value="{{ old('doj') }}" required>
                                    @error('doj')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department_id" class="form-select" required>
                                        <option value="">-- Select Department --</option>
                                        @foreach ($deps as $d)
                                            <option value="{{ $d->department_id }}" {{ old('department_id') == $d->department_id ? 'selected' : '' }}>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="position" class="form-label">Job Title / Position</label>
                                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}">
                                    @error('position')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Employment Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                        <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Employee</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection