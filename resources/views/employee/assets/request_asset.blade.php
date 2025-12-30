@extends('layouts.employee_navbar')

@section('title', 'Request Asset Form')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <div class="form-card-header">
                        <h1>Request Asset</h1>
                    </div>
                    <div class="form-card-body">
                        <form method="POST" action="{{ route('asset-requests.update', $asset->asset_id) }}">
                            @csrf
                            @method('PUT')

                            <fieldset class="form-fieldset">
                                <legend>Requested Asset Details</legend>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Asset Code</label>
                                        <div class="form-control-plaintext">{{ old('asset_code', $asset->asset_code) }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Asset Name</label>
                                        <div class="form-control-plaintext">{{ $asset->name }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Asset Type</label>
                                        <div class="form-control-plaintext">{{ ucfirst($asset->type->value) }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Category</label>
                                        <div class="form-control-plaintext">{{ $asset->category }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Brand</label>
                                        <div class="form-control-plaintext">{{ $asset->brand }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Model</label>
                                        <div class="form-control-plaintext">{{ $asset->model }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Serial Number</label>
                                        <div class="form-control-plaintext">{{ $asset->serial_number ?? '—' }}</div>
                                    </div>
                                </div>
                            </fieldset>

                            <hr class="form-divider">

                            <fieldset class="form-fieldset">
                                <legend>Reason for request</legend>
                                <div class="form-row">
                                    <div class="form-col-12">
                                        <label for="reason" class="form-label form-label-required">Reason</label>
                                        <textarea name="reason" id="reason" class="form-control" rows="3"
                                                  placeholder="Why is this asset being requested?" required>{{ old('purpose') }}</textarea>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-btn-group mt-4">
                                <a href="{{ route('asset-requests.index') }}" class="form-btn-outline">Cancel</a>
                                <button type="submit" class="form-btn-primary">Request Asset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
