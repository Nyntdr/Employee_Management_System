<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Asset::query();
    }

    public function map($asset): array
    {
        return [
            $asset->asset_code,
            $asset->name,
            $asset->category,
            $asset->brand,
            $asset->model,
            $asset->serial_number,
            Date::dateTimeTOExcel($asset->purchase_date),
            $asset->purchase_cost,
            Date::dateTimeTOExcel($asset->warranty_until),
            $asset->type->value,
            $asset->status->value,
            $asset->current_condition->value,
            Date::dateTimeTOExcel($asset->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Asset Code',
            'Asset Name',
            'Category',
            'Brand',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Purchase Price',
            'Warranty Date',
            'Asset Type',
            'Status',
            'Current Condition',
            'Created At',
        ];
    }
}
