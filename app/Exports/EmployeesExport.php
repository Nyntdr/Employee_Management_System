<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Employee::query()->with(['user', 'department']);
    }

    public function map($employee): array
    {
        return [
            $employee->user->name ?? 'N/A',
            $employee->department->name ?? 'N/A',
            $employee->first_name,
            $employee->last_name,
            ucfirst($employee->gender),
            $employee->phone,
            $employee->secondary_phone,
            $employee->emergency_contact,
            Date::dateTimeToExcel($employee->date_of_birth),
            Date::dateTimeToExcel($employee->date_of_joining),
            ];
    }

    public function headings(): array
    {
        return [
            'Username',
            'Department',
            'First Name',
            'Last Name',
            'Gender',
            'Phone',
            'Secondary Phone',
            'Emergency Contact',
            'Birth Date',
            'Hire Date',
        ];
    }
}
