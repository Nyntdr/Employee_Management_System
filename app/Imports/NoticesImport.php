<?php

namespace App\Imports;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NoticesImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();
        try{
            foreach ($rows as $row) {
                if (empty($row['title']) || empty($row['content'])) {
                    Log::warning('Skipped empty notice row',$row);
                    continue;
                }
                $poster= User::where('name',trim($row['poster']))->first();
                $posterID = $poster->id;

                Notice::create([
                    'title' => trim($row['title']),
                    'content' => $row['content'],
                    'posted_by' => $posterID,
                ]);
            }
            DB::commit();
            Log::info('Notices imported');
        }
        catch (\Throwable $e){
            DB::rollBack();
            Log::error('Notice import failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
            'poster'   => 'required|string|exists:users,name',
        ];
    }
}
