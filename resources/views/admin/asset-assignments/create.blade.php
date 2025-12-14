@extends('layouts.navbars')
@section('title', 'Assign Asset')
@section('content')
<div class="container">
    <h2>Assign Asset to Employee</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('asset-assignments.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="asset_id">Select Asset *</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                <option value="">-- Select Asset --</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->asset_id }}" 
                        {{ old('asset_id') == $asset->asset_id ? 'selected' : '' }}>
                        {{ $asset->asset_code }} - {{ $asset->name }} ({{ $asset->current_condition }})
                    </option>
                @endforeach
            </select>
            @error('asset_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="employee_id">Assign To Employee *</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->employee_id }}" 
                        {{ old('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="assigned_date">Assigned Date *</label>
            <input type="date" name="assigned_date" id="assigned_date" 
                   class="form-control" value="{{ old('assigned_date', date('Y-m-d')) }}" required>
            @error('assigned_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status *</label>
            <select name="status" id="status" class="form-control" required>
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" 
                        {{ old('status') == $status->value || $status->value == 'active' ? 'selected' : '' }}>
                        {{ ucfirst($status->value) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="condition_at_assignment">Asset Condition at Assignment *</label>
            <select name="condition_at_assignment" id="condition_at_assignment" class="form-control" required>
                <option value="">-- Select Condition --</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->value }}" 
                        {{ old('condition_at_assignment') == $condition->value ? 'selected' : '' }}>
                        {{ ucfirst($condition->value) }}
                    </option>
                @endforeach
            </select>
            @error('condition_at_assignment')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="purpose">Purpose/Reason *</label>
            <textarea name="purpose" id="purpose" class="form-control" rows="3" 
                      placeholder="Why is this asset being assigned?" required>{{ old('purpose') }}</textarea>
            @error('purpose')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Assign Asset</button>
            <a href="{{ route('asset-assignments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-group {
        margin-bottom: 1rem;
    }
    label {
        font-weight: bold;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .text-danger {
        color: red;
        font-size: 0.875rem;
    }
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 4px;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endsection