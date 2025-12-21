<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Event::all();
    }
    public function headings(): array
    {
        return [
            'Event ID',
            'Event Title',
            'Description',
            'Event Date',
            'Start Time',
            'End Time',
            'Created By',
            'Created Date',
            'Updated Date',
        ];
    }
}
