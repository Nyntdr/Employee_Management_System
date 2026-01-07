@extends('layouts.navbars')

@section('title', 'Add Leave Type')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Add Leave Type</h1>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('leave-types.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="name" class="form-label form-label-required">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col-12">
                                    <label for="max_days_per_year" class="form-label form-label-required">Max Days Per Year</label>
                                    <input type="number" name="max_days_per_year" id="max_days_per_year" class="form-control"
                                           value="{{ old('max_days_per_year') }}" min="1"  required>
                                    @error('max_days_per_year')
                                    <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-btn-group">
                                <a href="{{ route('leave-types.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Add Leave Type
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
