<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Asset::all();
    }

    public function headings(): array
    {
        return [
            'Asset ID',
            'Asset Code',
            'Asset Name',
            'Category',
            'Brand',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Purchase Price',
            'Warranty Date',
            'Created At',
            'Updated At',
            'Asset Type',
            'Status',
            'Current Condition',
        ];
    }
}
