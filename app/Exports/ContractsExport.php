<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ContractsExport implements FromQuery, WithHeadings , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Contract::query()->with('employee');
    }
    public function map($contract): array
    {
      return[
          $contract->employee->first_name . ' ' . $contract->employee->last_name,
          $contract->contract_type->value,
          $contract->job_title->value,
          Date::dateTimeToExcel($contract->start_date),
          Date::dateTimeToExcel($contract->end_date),
          $contract->probation_period ,
          $contract->working_hours,
          $contract->salary,
          $contract->contract_status->value,
      ];
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Contract Type',
            'Job Title',
            'Start Date',
            'End Date',
            'Probation Period',
            'Working Hours',
            'Salary',
            'Status',
        ];
    }

}
