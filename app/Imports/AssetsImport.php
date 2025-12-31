<?php

namespace App\Imports;

use App\Enums\AssetConditions;
use App\Enums\AssetStatuses;
use App\Enums\AssetTypes;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {

        DB::beginTransaction();
        try{
            foreach ($rows as $row) {
                if (empty($row['asset_code']) || empty($row['asset_name'])) {
                    Log::warning('Skipped empty asset row',$row);
                    continue;
                }
                Asset::create([
                    'asset_code' => $row['asset_code'],
                    'name' => $row['asset_name'],
                    'category' => $row['category'],
                    'brand' => $row['brand'],
                    'model' => $row['model'],
                    'serial_number' => $row['serial_number'],
                    'purchase_date' => $this->parseDate($row['purchase_date'] ?? null),
                    'purchase_cost' => $row['purchase_cost'],
                    'warranty_until' => $this->parseDate($row['warranty_until'] ?? null),
                    'type' => $row['type'],
                    'status' => $row['status'],
                    'current_condition' => $row['current_condition'],
                ]);
                Log::info('Assets imported',$row->toArray());
            }

            DB::commit();
        }
        catch (\Throwable $e){
            DB::rollBack();
            Log::error('Asset import failed'.$e->getMessage());
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'asset_code' => 'required|string|max:50',
            'asset_name' => 'required|string|max:100',
            'type' => 'required|string|in:' . implode(',', array_column(AssetTypes::cases(), 'value')),
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'required|string|max:100',
            'purchase_date' => 'nullable|numeric',
            'purchase_cost' => 'nullable|numeric|min:0',
            'warranty_until' => 'nullable|numeric',
            'status' => 'required|string|in:' . implode(',', array_column(AssetStatuses::cases(), 'value')),
            'current_condition' => 'required|string|in:' . implode(',', array_column(AssetConditions::cases(), 'value')),
        ];
    }
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
