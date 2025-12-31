<?php

namespace App\Imports;

use App\Models\LeaveType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LeaveTypeImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                if (empty($row['leave_name'])) {
                    Log::warning('Skipped empty leave type row', $row);
                    continue;
                }

                LeaveType::create([
                    'name' => trim($row['leave_name']),
                    'max_days_per_year' => $row['max_days_per_year'],
                ]);
            }
            DB::commit();
            Log::info('Leave Type import completed successfully');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Leave Type import failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
//validation uses excel column names
    public function rules(): array
    {
        return [
            'leave_name' => 'required|string|unique:leave_types,name',
            'max_days_per_year' => 'required|numeric',
        ];
    }
}
