@extends('layouts.navbars')

@section('title', 'Add Asset')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Add New Asset</h1>
                    </div>
                    <div class="form-card-body">
                        <form method="POST" action="{{ route('assets.store') }}">
                            @csrf

                            @if($errors->any())
                                <div class="form-alert form-alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <fieldset class="form-fieldset">
                                <legend>Basic Asset Information</legend>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="asset_code" class="form-label form-label-required">Asset Code</label>
                                        <input type="text" name="asset_code" id="asset_code" class="form-control"
                                               value="{{ old('asset_code') }}" maxlength="50" required>
                                        <div class="form-hint">Unique identifier for the asset</div>
                                        @error('asset_code')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="name" class="form-label form-label-required">Asset Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name') }}" maxlength="100" required>
                                        @error('name')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="type" class="form-label form-label-required">Asset Type</label>
                                        <select name="type" id="type" class="form-select" required>
                                            <option value="">-- Select Type --</option>
                                            @foreach(App\Enums\AssetTypes::cases() as $type)
                                                <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                                    {{ ucfirst($type->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" name="category" id="category" class="form-control"
                                               value="{{ old('category') }}" maxlength="100">
                                        <div class="form-hint">e.g., Laptop, Chair, Car, etc.</div>
                                        @error('category')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" name="brand" id="brand" class="form-control"
                                               value="{{ old('brand') }}" maxlength="100">
                                        @error('brand')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" name="model" id="model" class="form-control"
                                               value="{{ old('model') }}" maxlength="100">
                                        @error('model')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="serial_number" class="form-label form-label-required">Serial Number</label>
                                        <input type="text" name="serial_number" id="serial_number" class="form-control"
                                               value="{{ old('serial_number') }}" maxlength="100" required>
                                        <div class="form-hint">Unique serial number for the asset</div>
                                        @error('serial_number')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <hr class="form-divider">

                            <fieldset class="form-fieldset">
                                <legend>Purchase & Warranty Details</legend>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                        <input type="date" name="purchase_date" id="purchase_date" class="form-control"
                                               value="{{ old('purchase_date') }}">
                                        @error('purchase_date')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="purchase_cost" class="form-label">Purchase Cost</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" name="purchase_cost" id="purchase_cost" class="form-control"
                                                   value="{{ old('purchase_cost') }}" step="0.01" min="0" max="9999999999.99">
                                        </div>
                                        @error('purchase_cost')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="warranty_until" class="form-label">Warranty Until</label>
                                        <input type="date" name="warranty_until" id="warranty_until" class="form-control"
                                               value="{{ old('warranty_until') }}">
                                        @error('warranty_until')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <hr class="form-divider">

                            <fieldset class="form-fieldset">
                                <legend>Current Status</legend>

                                <div class="form-row">
                                    <div class="form-col-6">
                                        <label for="status" class="form-label form-label-required">Asset Status</label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="">-- Select Status --</option>
                                            @foreach(App\Enums\AssetStatuses::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ old('status', 'available') == $status->value ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $status->value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-hint">New assets are typically set to 'available'</div>
                                        @error('status')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-col-6">
                                        <label for="current_condition" class="form-label form-label-required">Current Condition</label>
                                        <select name="current_condition" id="current_condition" class="form-select" required>
                                            <option value="">-- Select Condition --</option>
                                            @foreach(App\Enums\AssetConditions::cases() as $condition)
                                                <option value="{{ $condition->value }}" {{ old('current_condition') == $condition->value ? 'selected' : '' }}>
                                                    {{ ucfirst($condition->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('current_condition')
                                        <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group">
                                <a href="{{ route('assets.index') }}" class="form-btn-outline">
                                    Cancel
                                </a>
                                <button type="submit" class="form-btn-primary">
                                    Add Asset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
