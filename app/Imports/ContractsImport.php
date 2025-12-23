<?php

namespace App\Imports;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Enums\JobTitle;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContractsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            DB::beginTransaction();
        try{
          if (empty($row['employee_id']) || empty($row['contract_type'])) {
             Log::warning('Skipped empty contract row',$row);
             DB::rollBack();
             return null;
          }
          $contract = new Contract([
              'employee_id' => $row['employee_id'],
              'contract_type' => $row['contract_type'],
              'job_title' => $row['job_title'],
              'start_date' => $this->excelDateToCarbon($row['start_date'] ?? null),
              'end_date' => $this->excelDateToCarbon($row['end_date'] ?? null),
              'probation_period' => $row['probation_days'] ?? null,
              'working_hours' => $row['working_hours'] ?? null,
              'salary' => $row['salary'],
              'contract_status' => $row['contract_status'],
          ]);
          $contract->save();
          DB::commit();
          return $contract;
        }
        catch (\Throwable $e){
            DB::rollBack();
            Log::error('Contract import failed', [
                'row' => $row,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,employee_id',
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
    private function excelDateToCarbon($value): ?string
    {
        if (!$value) {
            return null;
        }
        return Carbon::createFromTimestamp(
            ((int)$value - 25569) * 86400
        )->format('Y-m-d');
    }
}
