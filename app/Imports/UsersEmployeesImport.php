<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class UsersEmployeesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
                $user = User::create([
                    'name'     => $row['username'],
                    'email'    => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role_id'  => $row['role'] ?? 3,
                    'is_active' => true,
                    'profile_picture' => $row['profile'] ?? null,
                ]);
                Employee::create([
                    'user_id'         => $user->id,
                    'first_name'      => $row['first_name'] ?? '',
                    'last_name'       => $row['last_name'] ?? '',
                    'gender'          => $row['gender'] ?? null,
                    'phone'           => $row['phone'] ?? null,
                    'department_id'   => $row['department'] ?? 1,
                    'date_of_birth'   => empty($row['birth_date']) ? null : Carbon::parse($row['birth_date']),
                    'date_of_joining' => empty($row['join_date']) ? null : Carbon::parse($row['join_date']),
                ]);
        }
    }
}
