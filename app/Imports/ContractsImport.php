<?php

namespace App\Imports;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Enums\JobTitle;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ContractsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows) : void
    {
            DB::beginTransaction();
        try{
            foreach ($rows as $row)
            {
                if (empty($row['employee_email']) || empty($row['contract_type'])) {
                    Log::warning('Skipped empty needed values contract row ',$row);
                    continue;
                }
                $user = User::where('email', $row['employee_email'])->first();
                if ($user)
                {
                    $employee = Employee::where('user_id', $user->id)->first();
                }
                else{
                    Log::error('Employee not found');
                    continue;
                }
                Contract::create([
                    'employee_id' => $employee->employee_id,
                    'contract_type' => $row['contract_type'],
                    'job_title' => $row['job_title'],
                    'start_date' => $this->parseDate($row['start_date']),
                    'end_date' => $this->parseDate($row['end_date'] ?? null),
                    'probation_period' => $row['probation_days'] ?? null,
                    'working_hours' => $row['working_hours'] ?? null,
                    'salary' => $row['salary'],
                    'contract_status' => $row['contract_status'],
                ]);
                Log::info('Contract created',$row->toArray());
          }
          DB::commit();
        }
        catch (\Throwable $e){
            DB::rollBack();
            Log::error('Contract import failed'.$e->getMessage());
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'employee_email' => 'required|exists:users,email',
            'contract_type' => 'required|in:'. implode(',', array_column(ContractType::cases(), 'value')),
            'job_title' => 'required|in:'. implode(',', array_column(JobTitle::cases(), 'value')),
            'start_date' => 'required|numeric',
            'end_date' => 'nullable|numeric|after:start_date',
            'probation_days' => 'nullable|integer|min:0|max:365',
            'working_hours' => 'nullable|string|max:100',
            'salary' => 'required|numeric|min:0',
            'contract_status' => 'required|in:'. implode(',', array_column(ContractStatus::cases(), 'value')),
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
