<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AttendancesExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Attendance::query()->with('employee');
    }
    public function map($attendance): array
    {
        return [
            $attendance->employee->first_name.' '.$attendance->employee->last_name,
            Date::dateTimeToExcel($attendance->date),
            $attendance->clock_in,
            $attendance->clock_out ?? 'N/A',
            $attendance->total_hours ? Date::dateTimeToExcel($attendance->total_hours) : 'N/A',
            $attendance->status->value,
        ];
    }

    public function headings(): array
    {
        return [
           'Employee',
           'Date',
           'Check In',
           'Check Out',
           'Total Hours',
           'Status',
        ];
    }
}
