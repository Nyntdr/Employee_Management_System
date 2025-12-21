<?php

namespace App\Exports;

use App\Models\Department;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Department::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Department Name',
            'Manager ID',
            'Created At',
            'Updated At',
        ];
    }
}
