@extends('layouts.navbars')

@section('title', 'Edit Asset')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Update Asset</h1>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('assets.update', $asset->asset_id) }}">
                            @csrf
                            @method('PUT')
                            
                            <fieldset class="mb-4">
                                <legend>Basic Asset Information</legend>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="asset_code" class="form-label">Asset Code <span class="text-danger">*</span></label>
                                        <input type="text" name="asset_code" id="asset_code" class="form-control" 
                                               value="{{ old('asset_code', $asset->asset_code) }}" maxlength="50" required>
                                        <small class="text-muted">Unique identifier for the asset</small>
                                        @error('asset_code')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" 
                                               value="{{ old('name', $asset->name) }}" maxlength="100" required>
                                        @error('name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">Asset Type <span class="text-danger">*</span></label>
                                        <select name="type" id="type" class="form-select" required>
                                            <option value="">-- Select Type --</option>
                                            @foreach(App\Enums\AssetTypes::cases() as $type)
                                                <option value="{{ $type->value }}" 
                                                    {{ old('type', $asset->type->value) == $type->value ? 'selected' : '' }}>
                                                    {{ ucfirst($type->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" name="category" id="category" class="form-control" 
                                               value="{{ old('category', $asset->category) }}" maxlength="100">
                                        <small class="text-muted">e.g., Laptop, Chair, Car, etc.</small>
                                        @error('category')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" name="brand" id="brand" class="form-control" 
                                               value="{{ old('brand', $asset->brand) }}" maxlength="100">
                                        @error('brand')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" name="model" id="model" class="form-control" 
                                               value="{{ old('model', $asset->model) }}" maxlength="100">
                                        @error('model')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="serial_number" class="form-label">Serial Number <span class="text-danger">*</span></label>
                                    <input type="text" name="serial_number" id="serial_number" class="form-control" 
                                           value="{{ old('serial_number', $asset->serial_number) }}" maxlength="100" required>
                                    <small class="text-muted">Unique serial number for the asset</small>
                                    @error('serial_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </fieldset>

                            <hr>

                            <fieldset class="mb-4">
                                <legend>Purchase & Warranty Details</legend>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                        <input type="date" name="purchase_date" id="purchase_date" class="form-control" 
                                               value="{{ old('purchase_date', $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '') }}">
                                        @error('purchase_date')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="purchase_cost" class="form-label">Purchase Cost</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" name="purchase_cost" id="purchase_cost" class="form-control" 
                                                   value="{{ old('purchase_cost', $asset->purchase_cost) }}" step="0.01" min="0" max="9999999999.99">
                                        </div>
                                        @error('purchase_cost')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="warranty_until" class="form-label">Warranty Until</label>
                                    <input type="date" name="warranty_until" id="warranty_until" class="form-control" 
                                           value="{{ old('warranty_until', $asset->warranty_until ? $asset->warranty_until->format('Y-m-d') : '') }}">
                                    @error('warranty_until')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </fieldset>

                            <hr>

                            <fieldset class="mb-4">
                                <legend>Current Status</legend>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Asset Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="">-- Select Status --</option>
                                            @foreach(App\Enums\AssetStatuses::cases() as $status)
                                                <option value="{{ $status->value }}" 
                                                    {{ old('status', $asset->status->value) == $status->value ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $status->value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($asset->assignments()->where('status', 'active')->exists())
                                            <small class="text-warning">
                                                <i class="fas fa-exclamation-triangle"></i> This asset has active assignments. Status cannot be changed.
                                            </small>
                                        @endif
                                        @error('status')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="current_condition" class="form-label">Current Condition <span class="text-danger">*</span></label>
                                        <select name="current_condition" id="current_condition" class="form-select" required>
                                            <option value="">-- Select Condition --</option>
                                            @foreach(App\Enums\AssetConditions::cases() as $condition)
                                                <option value="{{ $condition->value }}" 
                                                    {{ old('current_condition', $asset->current_condition->value) == $condition->value ? 'selected' : '' }}>
                                                    {{ ucfirst($condition->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('current_condition')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Asset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection