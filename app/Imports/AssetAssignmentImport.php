<?php

namespace App\Imports;

use App\Enums\AssetConditions;
use App\Enums\AssignmentStatus;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetAssignmentImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {

                $asset = Asset::where('name', $row['asset_name'])->first();
                $user  = User::where('email', $row['employee_email'])->first();
                $employee = $user
                    ? Employee::where('user_id', $user->id)->first()
                    : null;
                $assigner = User::where('name', $row['assigner_username'])->first();

                AssetAssignment::create([
                    'asset_id' => $asset->asset_id,
                    'employee_id' => $employee->employee_id,
                    'assigned_by' => $assigner->id,
                    'assigned_date' => $this->parseDate($row['assigned_date']),
                    'returned_date' => $this->parseDate($row['returned_date'] ?? null),
                    'status' => AssignmentStatus::from($row['status']),
                    'purpose' => $row['purpose'],
                    'condition_at_assignment' => AssetConditions::from($row['condition_at_assignment']),
                    'condition_at_return' => !empty($row['condition_at_return'])
                        ? AssetConditions::from($row['condition_at_return'])
                        : AssetConditions::UNRETURNED,

                ]);

                $asset->update(['status' => 'assigned']);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            '*.asset_name' => ['required', 'exists:assets,name'],
            '*.employee_email' => ['required', 'exists:users,email'],
            '*.assigner_username' => ['required', 'exists:users,name'],
            '*.assigned_date' => ['required'],
            '*.returned_date' => ['nullable'],
            '*.status' => ['required', Rule::enum(AssignmentStatus::class)],
            '*.purpose' => ['required', 'string', 'max:50'],
            '*.condition_at_assignment' => ['required', Rule::enum(AssetConditions::class)],
            '*.condition_at_return' => ['nullable', Rule::enum(AssetConditions::class)],
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
