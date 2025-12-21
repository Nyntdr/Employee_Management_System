<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContractsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contract::all();
    }
    public function headings(): array
    {
        return [
            'Contract ID',
            'Employee ID',
            'Contract Type',
            'Job Title',
            'Start Date',
            'End Date',
            'Probation Period',
            'Working Hours',
            'Salary',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

}
