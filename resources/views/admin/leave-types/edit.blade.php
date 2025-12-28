@extends('layouts.navbars')

@section('title', 'Edit Leave Type')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Edit Leave Type</h1>
                        <p class="mb-0 form-text-muted">Leave Type ID: LT-{{ str_pad($leave_type->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('leave-types.update', $leave_type->id) }}" method="POST">
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
                                    <label for="name" class="form-label form-label-required">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name', $leave_type->name) }}" required>
                                    @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="max_days_per_year" class="form-label form-label-required">Max Days Per Year</label>
                                    <input type="number" name="max_days_per_year" id="max_days_per_year" class="form-control"
                                           value="{{ old('max_days_per_year', $leave_type->max_days_per_year) }}" min="1" max="365" required>
                                    @error('max_days_per_year')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('leave-types.index') }}" class="form-btn-outline">
                                    Go Back
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Update Leave Type
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
