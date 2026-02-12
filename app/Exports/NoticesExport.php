<?php

namespace App\Exports;

use App\Models\Notice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NoticesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Notice::query()->with(['poster']);
    }

    public function map($notice): array
    {
        return [
            $notice->title,
            $notice->content,
            $notice->poster->name,
            Date::dateTimeToExcel($notice->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'Content',
            'Posted By',
            'Created At',
        ];
    }
}
