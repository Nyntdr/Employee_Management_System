<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeavesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Leave::all();
    }
    public function headings(): array
    {
        return [
            'Leave ID',
            'Employee ID',
            'Leave Type ID',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
            'Approver',
            'Created at',
            'Updated at',
        ];
    }
}
