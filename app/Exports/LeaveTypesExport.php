<?php

namespace App\Exports;

use App\Models\LeaveType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveTypesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LeaveType::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Max Days Per Year',
            'Created At',
            'Updated At',
        ];
    }
}
