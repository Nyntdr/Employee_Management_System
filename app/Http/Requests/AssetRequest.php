<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\AssetTypes;
use App\Enums\AssetStatuses;
use App\Enums\AssetConditions;

class AssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset') ?? null;

        $rules = [
            'asset_code' => 'required|string|max:30',
            'name' => 'required|string|max:30',
            'type' => 'required|string|in:' . implode(',', array_column(AssetTypes::cases(), 'value')),
            'category' => ['nullable','string','max:30',new AlphaSpaces],
            'brand' => 'nullable|string|max:20',
            'model' => 'nullable|string|max:20',
            'serial_number' => 'required|string|max:50',
            'purchase_date' => 'nullable|date|before_or_equal:today',
            'purchase_cost' => 'nullable|numeric|min:0',
            'warranty_until' => 'nullable|date',
            'status' => 'required|string|in:' . implode(',', array_column(AssetStatuses::cases(), 'value')),
            'current_condition' => 'required|string|in:' . implode(',', array_column(AssetConditions::cases(), 'value')),
            'requested_by' => 'nullable|exists:employees,employee_id',
            'requested_at' => 'nullable|date',
            'request_reason' => 'nullable|string|max:20',
        ];

        if ($this->isMethod('POST')) {
            $rules['asset_code'] .= '|unique:assets,asset_code';
            $rules['serial_number'] .= '|unique:assets,serial_number';
        } else {
            $rules['asset_code'] .= '|unique:assets,asset_code,' . $assetId . ',asset_id';
            $rules['serial_number'] .= '|unique:assets,serial_number,' . $assetId . ',asset_id';
        }

        return $rules;
    }
}
