<?php

namespace App\Exports;

use App\Models\LeaveType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeaveTypesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return LeaveType::query();
    }

    public function map($leaveType): array
    {
        return [
            $leaveType->name ?? 'N/A',
            $leaveType->max_days_per_year,
        ];

    }

    public function headings(): array
    {
        return [
            'Name',
            'Max Days Per Year',
        ];
    }
}
