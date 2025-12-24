<?php

namespace App\Exports;

use App\Models\Department;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Department::query()->with('manager');
    }
    public function map($department): array
    {
        return [
            $department->name,
            $department->manager ? $department->manager->first_name. ' ' . $department->manager->last_name : 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            'Department',
            'Manager',

        ];
    }
}
