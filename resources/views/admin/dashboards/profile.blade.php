@extends('layouts.navbars')
@section('title', 'My Profile')
@section('content')
    @php
        $u = Auth::user();
        $e = $u->employee;
    @endphp

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile-clean-card mb-4">
                    <div class="profile-clean-header">
                        <h3>PROFILE PICTURE</h3>
                    </div>
                    <div class="profile-clean-body text-center">
                        <div class="profile-pic-wrapper">
                            @if($u->profile_picture)
                                <img src="{{ asset('storage/'.$u->profile_picture) }}" alt="Profile">
                            @else
                                <img src="{{ asset('images/icon.jpg') }}" alt="Default">
                            @endif
                        </div>

                        <h4 class="mb-1">{{ $u->name }}</h4>
                        <p class="text-muted mb-3">{{ $u->role->role_name }}</p>

                        <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="profileImage" name="image" accept="image/*" class="d-none">
                            <button type="button" onclick="document.getElementById('profileImage').click()"
                                    class="btn-pic-change mb-2">Change Picture</button>

                            <div id="imagePreviewSection" class="mt-3" style="display: none;">
                                <img id="previewImage" class="rounded-circle mb-2" width="80" height="80">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Save
                                    </button>
                                    <button type="button" onclick="cancelUpload()" class="btn btn-danger btn-sm">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($e)
                    <div class="profile-clean-card">
                        <div class="profile-clean-header">
                            <h3>QUICK INFO</h3>
                        </div>
                        <div class="profile-clean-body">
                            <div class="info-row">
                                <div class="info-label">Employee ID</div>
                                <div class="info-value">EMP-{{ $e->employee_id }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Joined Date</div>
                                <div class="info-value">
                                    {{ $e->date_of_joining->format('M d, Y') }}
                                    <small class="text-muted d-block">{{ $e->date_of_joining->diffForHumans() }}</small>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Contract Type & Status</div>
                                <div class="info-value">
                                    <span class="status-badge status-active">{{ ucwords(str_replace('_', ' ', $e->latestContract->contract_type->value)) ?? 'Not specified' }}</span>
                                    @if($e->latestContract->contract_status->value == 'active')
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">{{ ucfirst($e->latestContract->contract_status->value) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Age</div>
                                <div class="info-value">{{ $e->date_of_birth->age }} years</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="profile-clean-card mb-4">
                    <div class="profile-clean-header">
                        <h3>USER INFORMATION</h3>
                    </div>
                    <div class="profile-clean-body">
                        <div class="simple-grid">
                            <div class="info-row">
                                <div class="info-label">Username</div>
                                <div class="info-value">{{ $u->name }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Email Address</div>
                                <div class="info-value">{{ $u->email }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">User Role</div>
                                <div class="info-value">{{ $u->role->role_name }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Last Login</div>
                                <div class="info-value">{{ $u->last_login->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($e)
                    <div class="profile-clean-card mb-4">
                        <div class="profile-clean-header">
                            <h3>PERSONAL DETAILS</h3>
                        </div>
                        <div class="profile-clean-body">
                            <div class="simple-grid">
                                <div class="info-row">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value">{{ $e->first_name }} {{ $e->last_name }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Gender</div>
                                    <div class="info-value">{{ ucfirst($e->gender) }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value">{{ $e->date_of_birth->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-clean-card mb-4">
                        <div class="profile-clean-header">
                            <h3>CONTACT INFORMATION</h3>
                        </div>
                        <div class="profile-clean-body">
                            <div class="simple-grid">
                                <div class="contact-box">
                                    <div class="info-label">Primary Phone</div>
                                    <div class="info-value mt-2">{{ $e->phone }}</div>
                                </div>

                                <div class="contact-box">
                                    <div class="info-label">Secondary Phone</div>
                                    <div class="info-value mt-2">{{ $e->secondary_phone ?? 'Not provided' }}</div>
                                </div>

                                <div class="contact-box">
                                    <div class="info-label">Emergency Contact</div>
                                    <div class="info-value mt-2">{{ $e->emergency_contact ?? 'Not provided' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-clean-card">
                        <div class="profile-clean-header">
                            <h3>JOB DETAILS</h3>
                        </div>
                        <div class="profile-clean-body">
                            <div class="simple-grid">
                                <div class="info-row">
                                    <div class="info-label">Job Title</div>
                                    <div class="info-value">{{ ucwords(str_replace('_', ' ', $e->latestContract->job_title->value)) ?? 'Not specified' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Monthly Salary</div>
                                    <div class="info-value">
                                        @if($e->latestContract && $e->latestContract->salary)
                                            Rs {{ number_format($e->latestContract->salary, 2) }}
                                        @else
                                            Not specified
                                        @endif
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Contract Start Date</div>
                                    <div class="info-value">
                                        @if($e->latestContract && $e->latestContract->start_date)
                                            {{ $e->latestContract->start_date->format('M d, Y') }}
                                        @else
                                            Not specified
                                        @endif
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Contract End Date</div>
                                    <div class="info-value">
                                        @if($e->latestContract && $e->latestContract->end_date)
                                            {{ $e->latestContract->end_date->format('M d, Y') }}
                                        @else
                                            Not specified / Open-ended
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="profile-clean-card">
                        <div class="profile-clean-body text-center py-4">
                            <div class="mb-3">
                                <div class="profile-pic-wrapper mx-auto" style="width: 80px; height: 80px;">
                                    <img src="{{ asset('images/icon.jpg') }}" alt="Default">
                                </div>
                            </div>
                            <h5 class="text-muted">No Employee Data</h5>
                            <p class="text-muted mb-0">Your user account is not linked to any employee record.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profileImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewSection = document.getElementById('imagePreviewSection');
            const previewImage = document.getElementById('previewImage');

            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewSection.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        function cancelUpload() {
            document.getElementById('profileImage').value = '';
            document.getElementById('imagePreviewSection').style.display = 'none';
        }
    </script>
@endsection
