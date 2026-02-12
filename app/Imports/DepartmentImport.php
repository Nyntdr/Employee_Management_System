<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
use App\Rules\AlphaSpaces;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                if (empty($row['department_name'])) {
                    Log::warning('Skipped empty department row', $row);
                    continue;
                }
                $manager = Employee::where('first_name', trim($row['manager_name']))->first();
                $managerId = $manager ? $manager->employee_id : null;

                Department::create([
                    'name' => trim($row['department_name']),
                    'manager_id' => $managerId,
                ]);
            }
            DB::commit();
            Log::info('Department import completed successfully');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Department import failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
//validation uses excel column names
    public function rules(): array
    {
        return [
            'department_name' => ['required','string','max:50','unique:departments,name',new AlphaSpaces],
            'manager_name' => 'nullable|string|exists:employees,first_name',
        ];
    }
}
