<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendancesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::all();
    }
    public function headings(): array
    {
        return [
          'Attendance ID',
           'Employee ID',
           'Date',
           'Check In',
           'Check Out',
           'Total Hours',
           'Status',
           'Created At',
           'Updated At',
        ];
    }
}
