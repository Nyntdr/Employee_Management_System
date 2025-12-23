<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class DepartmentImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            if (empty($row['name'])) {
                Log::warning('Skipped empty department row', $row);
                DB::rollBack();
                return null;
            }
            $department = new Department([
                'name' => $row['name'],
                'manager_id' => $row['manager_id'] ?? null,
            ]);
            $department->save();
            DB::commit();
            return $department;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Department import failed', [
                'row' => $row,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:departments,name',
            'manager_id' => 'nullable|integer|exists:employees,employee_id',
        ];
    }
}
