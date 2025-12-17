@extends('layouts.navbars')
@section('title', 'My Profile')
@section('content')
    @php
        $u = Auth::user();
        $e = $u->employee;
    @endphp
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="mb-0">Profile Image</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            @if(!$u->profile_picture)
                                <img src="{{ asset('images/icon.jpg')}}" class="rounded-circle border border-primary" width="200" height="200">
                            @else
                                <img src="{{ asset('storage/'.$u->profile_picture) }}" class="rounded-circle border border-primary" width="200" height="200">
                            @endif
                        </div>
                        
                        <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="fileInput" class="btn btn-primary btn-sm">Choose New Image</label>
                                <input type="file" id="fileInput" name="image" accept="image/*" class="d-none">
                            </div>
                            <div class="mb-3">
                                <img id="imagePreview" alt="Preview" class="rounded-circle d-none" width="200" height="200">
                            </div>
                            <button type="submit" class="btn btn-success btn-sm" id="uploadButton" disabled>Upload Image</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="mb-0">User Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <p class="form-control-static">{{ $u->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control-static">{{ $u->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <p class="form-control-static">{{ $u->role->role_name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Login</label>
                            <p class="form-control-static">{{ $u->last_login->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if ($u && $u->employee)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="mb-0">Employee Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <p class="form-control-static">{{ $e->first_name }} {{ $e->last_name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <p class="form-control-static">{{ $e->gender }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of Birth</label>
                                <p class="form-control-static">{{ $e->date_of_birth->format('M d, Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Join Date</label>
                                <p class="form-control-static">
                                    {{ $e->date_of_joining->format('M d, Y') }}<br>
                                    <small class="text-muted">({{ $e->date_of_joining->diffForHumans() }})</small>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Current Status</label>
                                <p class="form-control-static">
                                    @if ($e->employment_status == 'active')
                                        <span class="badge bg-success">{{ $e->employment_status }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $e->employment_status }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Contacts</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Main Phone</label>
                                    <p class="form-control-static">{{ $e->phone }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Secondary Phone</label>
                                    <p class="form-control-static">{{ $e->secondary_phone }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Emergency Contact</label>
                                    <p class="form-control-static">{{ $e->emergency_contact }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagePreview = document.getElementById('imagePreview');
            const uploadButton = document.getElementById('uploadButton');
            
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    uploadButton.disabled = false;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('d-none');
                imagePreview.src = '';
                uploadButton.disabled = true;
            }
        });
    </script>
@endsection