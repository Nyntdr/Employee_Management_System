<?php

namespace App\Exports;

use App\Models\AssetAssignment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetAssignmentsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return AssetAssignment::query()->with(['employee','asset','assigner']);
    }
    public function map($asset_assign): array
    {
        return [
            $asset_assign->asset->name,
            $asset_assign->employee->first_name.' '.$asset_assign->employee->last_name,
            $asset_assign->assigner->name,
            Date::dateTimeToExcel($asset_assign->assigned_date),
            $asset_assign->returned_date ? Date::dateTimeToExcel($asset_assign->returned_date) : 'N/A',
            $asset_assign->purpose,
            $asset_assign->status->value,
            $asset_assign->condition_at_assignment->value,
            $asset_assign->condition_at_return->value,
        ];
    }
    public function headings(): array
    {
        return [
            'Asset Name',
            'Employee',
            'Assigner',
            'Assigned Date',
            'Return Date',
            'Purpose',
            'Status',
            'Condition At Assignment',
            'Condition At Return'
        ];
    }
}
