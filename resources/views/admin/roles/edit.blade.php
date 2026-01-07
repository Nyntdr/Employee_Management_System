@extends('layouts.navbars')

@section('title', 'Edit Role')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Role</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('roles.update', $role->role_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="role_name" class="form-label form-label-required">Role Name</label>
                                    <input type="text" name="role_name" id="role_name"
                                           class="form-control"
                                           value="{{ old('role_name', $role->role_name) }}"
                                           required>
                                    @error('role_name')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('roles.index') }}" class="form-btn-outline">
                                    Back to Roles
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
