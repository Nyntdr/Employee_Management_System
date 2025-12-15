@extends('layouts.navbars')

@section('title', 'Edit Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Edit Employee</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.update', $employee->employee_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h4 class="mb-4">User Account Details</h4>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $employee->user->name) }}" class="form-control">
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $employee->user->email) }}" class="form-control">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select name="role_id" id="role_id"
                                    class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                            {{ old('role_id', $employee->user->role_id) == $role->role_id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>

                            <hr class="my-5">

                            <h4 class="mb-4">Employee Personal & Job Details</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" name="first_name" id="first_name"
                                            value="{{ old('first_name', $employee->first_name) }}"
                                            class="form-control">
                                        @error('first_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"
                                            value="{{ old('last_name', $employee->last_name) }}"
                                            class="form-control">
                                        @error('last_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender"
                                    class="form-control">
                                    <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $employee->phone) }}"
                                    class="form-control">
                                @error('phone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                <input type="text" name="secondary_phone" id="secondary_phone"
                                    value="{{ old('secondary_phone', $employee->secondary_phone) }}"
                                    class="form-control">
                                @error('secondary_phone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact" id="emergency_contact"
                                    value="{{ old('emergency_contact', $employee->emergency_contact) }}"
                                    class="form-control">
                                @error('emergency_contact')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select name="department_id" id="department_id"
                                    class="form-control">
                                    @foreach ($deps as $dep) 
                                        <option value="{{ $dep->department_id }}"
                                            {{ old('department_id', $employee->department_id) == $dep->id ? 'selected' : '' }}>
                                            {{ $dep->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" id="dob"
                                    value="{{ old('dob', $employee->date_of_birth?->format('Y-m-d')) }}"
                                    class="form-control">
                                @error('dob')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="doj" class="form-label">Date of Joining</label>
                                <input type="date" name="doj" id="doj"
                                    value="{{ old('doj', $employee->date_of_joining?->format('Y-m-d')) }}"
                                    class="form-control">
                                @error('doj')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update Employee</button>
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection