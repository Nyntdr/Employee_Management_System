<?php

namespace App\Exports;

use App\Models\Notice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoticesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Notice::all();
    }
    public function headings(): array
    {
        return [
            'Notice ID',
            'Title',
            'Content',
            'Posted By',
            'Published On',
            'Created At',
            'Updated At',
        ];
    }
}
