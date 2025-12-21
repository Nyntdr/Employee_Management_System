<?php

namespace App\Exports;

use App\Models\AssetAssignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetAssignmentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AssetAssignment::all();
    }
    public function headings(): array
    {
        return [
            'Assignment ID',
            'Asset ID',
            'Employee ID',
            'Assigner',
            'Assigned Date',
            'Return Date',
            'Purpose',
            'Created At',
            'Updated At',
            'Status',
            'Condition At Assignment',
            'Condition At Return'
        ];
    }
}
