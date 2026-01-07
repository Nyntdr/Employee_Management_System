@extends('layouts.navbars')

@section('title', 'Edit Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Employee</h1>
                        <p class="mb-0 form-text-muted">Employee ID: EMP-{{ $employee->employee_id }}</p>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('employees.update', $employee->employee_id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <fieldset class="form-fieldset">
                                <legend>User Account Details</legend>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="name" class="form-label form-label-required">Username</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ old('name', $employee->user->name) }}"
                                               class="form-control" required>
                                        <div class="form-hint">Only alphanumeric and underscores allowed and also unique per users </div>
                                        @error('name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="email" class="form-label form-label-required">Email</label>
                                        <input type="email" name="email" id="email"
                                               value="{{ old('email', $employee->user->email) }}"
                                               class="form-control" required>
                                        @error('email')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="role_id" class="form-label form-label-required">Role</label>
                                        <select name="role_id" id="role_id" class="form-select" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role_id }}"
                                                    {{ old('role_id', $employee->user->role_id) == $role->role_id ? 'selected' : '' }}>
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
                                    <div class="form-col-6">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" id="password"
                                               class="form-control"
                                               placeholder="Leave blank to keep current password">
                                        @error('password')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                        <div class="form-hint">6~8 characters with a uppercase, lowercase, alphanumeric and one special symbol</div>
                                    </div>

                                    <div class="form-col-6">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" name="password_confirmation"
                                               id="password_confirmation" class="form-control"
                                               placeholder="Confirm new password">
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
                                               value="{{ old('first_name', $employee->first_name) }}"
                                               class="form-control" required>
                                        @error('first_name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-col-6">
                                        <label for="last_name" class="form-label form-label-required">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"
                                               value="{{ old('last_name', $employee->last_name) }}"
                                               class="form-control" required>
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
                                            <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="phone" class="form-label form-label-required">Phone</label>
                                        <input type="tel" name="phone" id="phone"
                                               value="{{ old('phone', $employee->phone) }}"
                                               class="form-control" required>
                                        @error('phone')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                        <input type="tel" name="secondary_phone" id="secondary_phone"
                                               value="{{ old('secondary_phone', $employee->secondary_phone) }}"
                                               class="form-control">
                                        @error('secondary_phone')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="emergency_contact" class="form-label form-label-required">Emergency Contact</label>
                                        <input type="text" name="emergency_contact" id="emergency_contact"
                                               value="{{ old('emergency_contact', $employee->emergency_contact) }}"
                                               class="form-control" required
                                               placeholder="Name (Relationship - Phone Number)">
                                        @error('emergency_contact')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                        <div class="form-hint">Format: Name (Relationship - Phone Number)</div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="department_id" class="form-label form-label-required">Department</label>
                                        <select name="department_id" id="department_id" class="form-select" required>
                                            <option value="">-- Select Department --</option>
                                            @foreach ($deps as $dep)
                                                <option value="{{ $dep->department_id }}"
                                                    {{ old('department_id', $employee->department_id) == $dep->department_id ? 'selected' : '' }}>
                                                    {{ $dep->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="dob" class="form-label form-label-required">Date of Birth</label>
                                        <input type="date" name="dob" id="dob"
                                               value="{{ old('dob', $employee->date_of_birth?->format('Y-m-d')) }}"
                                               class="form-control" required>
                                        @error('dob')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="doj" class="form-label form-label-required">Date of Joining</label>
                                        <input type="date" name="doj" id="doj"
                                               value="{{ old('doj', $employee->date_of_joining?->format('Y-m-d')) }}"
                                               class="form-control" required>
                                        @error('doj')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('employees.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Employee
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password validation
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');

            function validatePasswords() {
                if (passwordField.value && confirmPasswordField.value) {
                    if (passwordField.value !== confirmPasswordField.value) {
                        confirmPasswordField.classList.add('is-invalid');
                        confirmPasswordField.classList.remove('is-valid');
                    } else {
                        confirmPasswordField.classList.remove('is-invalid');
                        confirmPasswordField.classList.add('is-valid');
                    }
                } else {
                    confirmPasswordField.classList.remove('is-invalid', 'is-valid');
                }
            }

            passwordField?.addEventListener('input', validatePasswords);
            confirmPasswordField?.addEventListener('input', validatePasswords);

            // Date validation
            const dobInput = document.getElementById('dob');
            const dojInput = document.getElementById('doj');

            // Set max date for DOB (16 years minimum)
            if (dobInput) {
                const today = new Date();
                const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
                dobInput.max = maxDate.toISOString().split('T')[0];
            }

            // Set max date for DOJ (today)
            if (dojInput) {
                const today = new Date().toISOString().split('T')[0];
                dojInput.max = today;
            }

            // Auto-capitalize names
            function capitalizeName(input) {
                if (input.value) {
                    input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
                }
            }

            document.getElementById('first_name')?.addEventListener('blur', function(e) {
                capitalizeName(e.target);
            });

            document.getElementById('last_name')?.addEventListener('blur', function(e) {
                capitalizeName(e.target);
            });

            // Form validation
            const form = document.querySelector('form.needs-validation');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }
        });
    </script>
@endpush
