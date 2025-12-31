<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EventImport implements ToCollection,  WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows): void
{
    DB::beginTransaction();
    try{
        foreach ($rows as $row) {
            if (empty($row['title']) || empty($row['description'])) {
                Log::warning('Skipped empty notice row',$row);
                continue;
            }
            $poster= User::where('name',trim($row['created_by']))->first();
            $posterID = $poster->id;

            Event::create([
                'title' => trim($row['title']),
                'description' => $row['description'],
                'event_date' => $this->parseDate($row['event_date']),
                'start_time' => Date::excelToDateTimeObject($row['start_time']),
                'end_time' => Date::excelToDateTimeObject($row['end_time']),
                'created_by' => $posterID,
            ]);
        }
        DB::commit();
        Log::info('Events imported');
    }
    catch (\Throwable $e){
        DB::rollBack();
        Log::error('Event import failed', [
            'message' => $e->getMessage(),
        ]);
        throw $e;
    }
}
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'event_date'  => 'required',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'created_by'  => 'required|string|exists:users,name',
        ];
    }
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
