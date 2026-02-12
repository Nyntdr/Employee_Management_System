@extends('layouts.navbars')

@section('title', 'Add Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Add Employee</h1>
                    </div>
                    <div class="form-card-body">
                        <form method="POST" action="{{ route('employees.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <fieldset class="form-fieldset">
                                <legend>User Account Details</legend>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="role_id" class="form-label form-label-required">Role</label>
                                        <select name="role_id" id="role_id" class="form-select" required>
                                            <option value="">-- Select Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                                    {{ $role->role_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="name" class="form-label form-label-required">Username</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                        <div class="form-hint">Only alphanumeric and underscores allowed and also unique per users </div>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="email" class="form-label form-label-required">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ old('email') }}" required>
                                        @error('email')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="password" class="form-label form-label-required">Password</label>
                                        <div class="form-input-group">
                                            <input type="password" name="password" id="password"
                                                   class="form-control" required>
                                        </div>
                                        @error('password')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                        <div class="form-hint">6~12 characters with a uppercase, lowercase, alphanumeric and one special symbol</div>

                                    </div>

                                    <div class="form-col-6">
                                        <label for="password_confirmation" class="form-label form-label-required">Confirm Password</label>
                                        <div class="form-input-group">
                                            <input type="password" name="password_confirmation"
                                                   id="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <hr class="form-divider">

                            <fieldset class="form-fieldset">
                                <legend>Employee Personal & Job Details</legend>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="first_name" class="form-label form-label-required">First Name</label>
                                        <input type="text" name="first_name" id="first_name"
                                               class="form-control" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="last_name" class="form-label form-label-required">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"
                                               class="form-control" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="gender" class="form-label form-label-required">Gender</label>
                                        <select name="gender" id="gender" class="form-select" required>
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="phone" class="form-label form-label-required">Contact Number</label>
                                        <input type="tel" name="phone" id="phone" class="form-control"
                                               value="{{ old('phone') }}" maxlength="10" required>
                                        @error('phone')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="secondary_phone" class="form-label">Secondary Contact Number</label>
                                        <input type="tel" name="secondary_phone" id="secondary_phone"
                                               class="form-control" value="{{ old('secondary_phone') }}" maxlength="10">
                                        @error('secondary_phone')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="emergency_contact" class="form-label form-label-required">Emergency Contact</label>
                                        <input type="text" name="emergency_contact" id="emergency_contact"
                                               class="form-control" value="{{ old('emergency_contact') }}"
                                               placeholder="e.g., Hari Bahadur (Father - 9876543XXX)" required>
                                        @error('emergency_contact')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                        <div class="form-hint">Format: Name (Relationship - Phone Number)</div>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="dob" class="form-label form-label-required">Date of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control"
                                               value="{{ old('dob') }}" required>
                                        @error('dob')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="doj" class="form-label form-label-required">Date of Joining</label>
                                        <input type="date" name="doj" id="doj" class="form-control"
                                               value="{{ old('doj') }}" required>
                                        @error('doj')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="department_id" class="form-label form-label-required">Department</label>
                                        <select name="department_id" id="department_id" class="form-select" required>
                                            <option value="">-- Select Department --</option>
                                            @foreach ($deps as $d)
                                                <option value="{{ $d->department_id }}" {{ old('department_id') == $d->department_id ? 'selected' : '' }}>
                                                    {{ $d->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('employees.index') }}" class="form-btn-outline">Cancel</a>
                                <button type="submit" class="form-btn-primary">Add Employee</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
