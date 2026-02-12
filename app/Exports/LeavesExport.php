<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LeavesExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Leave::query()->with(['employee', 'leaveType', 'approver']);
    }

    public function map($leave): array
    {
        return [
            $leave->employee->first_name . ' ' . $leave->employee->last_name,
            $leave->leaveType->name,
            Date::dateTimeToExcel($leave->start_date),
            Date::dateTimeToExcel($leave->end_date),
            $leave->reason,
            $leave->status->value,
            $leave->approver->name ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Leave Type',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
            'Approver',
        ];
    }
}
