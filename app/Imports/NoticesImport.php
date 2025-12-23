<?php

namespace App\Imports;

use App\Models\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NoticesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::beginTransaction();
        try{
            if (empty($row['title']) || empty($row['content'])) {
                Log::warning('Skipped empty notice row',$row);
                DB::rollBack();
                return null;
            }
            $notice = new Notice([
                'title' => $row['title'],
                'content' => $row['content'],
                'posted_by' => $row['poster'],
            ]);
            $notice->save();
            DB::commit();
            return $notice;
        }
        catch (\Throwable $e){
            DB::rollBack();
            Log::error('Notice import failed', [
                'row' => $row,
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
            'poster'   => 'required|integer|exists:users,id',
        ];
    }
}
