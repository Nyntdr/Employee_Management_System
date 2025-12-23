<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class UsersEmployeesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row)
            {
                if (empty($row['username']) || empty($row['email']) || empty($row['password']))
                {
                    Log::warning("Skipped row at index {$index}", $row->toArray());
                    continue;
                }
                $user = User::create([
                    'name' => trim($row['username']),
                    'email' => trim($row['email']),
                    'password' => Hash::make($row['password']),
                    'role_id' => $row['role'] ?? 3,
                    'is_active' => true,
                    'profile_picture' => $row['profile'] ?? null,
                ]);
                Employee::create([
                    'user_id' => $user->id,
                    'first_name' => trim($row['first_name'] ?? ''),
                    'last_name' => trim($row['last_name'] ?? ''),
                    'gender' => $row['gender'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'secondary_phone' => $row['secondary'] ?? null,
                    'emergency_contact' => $row['emergency'] ?? null,
                    'department_id' => $row['department'] ?? 1,
                    'date_of_birth' => $this->excelDateToCarbon($row['birth_date'] ?? null),
                    'date_of_joining' => $this->excelDateToCarbon($row['join_date'] ?? null),
                ]);
                Log::info("Imported user: {$row['email']}");
            }
            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Excel Import Failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'username'   => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required|integer|exists:roles,role_id',

            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'gender'     => 'nullable|in:male,female',
            'phone'      => 'required|digits:10',
            'secondary'  => 'nullable|digits:10',
            'emergency'  => 'nullable|string|max:255',
            'department' => 'required|integer|exists:departments,department_id',
            'birth_date' => 'nullable|numeric',
            'join_date'  => 'nullable|numeric',
        ];
    }
    private function excelDateToCarbon($value): ?string
    {
        if (!$value) {
            return null;
        }
        return Carbon::createFromTimestamp(
            ((int)$value - 25569) * 86400
        )->format('Y-m-d');
    }
}
