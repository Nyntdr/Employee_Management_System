<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EventsExport implements FromQuery, WithHeadings, WithMapping
{

    public function query()
    {
        return Event::query()->with('creator');
    }
    public function map($event): array
    {
        return [
            $event->title,
            $event->description,
            Date::dateTimeToExcel($event->event_date),
            Date::dateTimeToExcel($event->start_time),
            Date::dateTimeToExcel($event->end_time),
            $event->creator->name ?? 'N/A',
            Date::dateTimeToExcel($event->created_at),
        ];
    }
    public function headings(): array
    {
        return [
            'Event Title',
            'Description',
            'Event Date',
            'Start Time',
            'End Time',
            'Created By',
            'Created Date',
        ];

    }
}
