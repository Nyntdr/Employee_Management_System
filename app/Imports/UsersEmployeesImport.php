<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersEmployeesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row)
            {
                if (empty($row['username']) || empty($row['email']) || empty($row['password'])) {
                    Log::warning("Skipping row - missing required fields");
                    continue;
                }
                $role = Role::where('role_name', $row['role'])->first();
                $roleId = $role ? $role->role_id : 3;
                $department = Department::where('name', $row['department'])->first();
                $departmentId = $department ? $department->department_id : 1;
                $email = trim($row['email']);
                if (User::where('email', $email)->exists()) {
                    Log::warning("Email already exists: {$email}");
                    continue;
                }
                $user = User::create([
                    'name' => trim($row['username']),
                    'email' => $email,
                    'password' => Hash::make($row['password']),
                    'role_id' => $roleId,
                    'is_active' => true,
                    'profile_picture' => $row['profile'] ?? null,
                ]);
                Employee::create([
                    'user_id' => $user->id,
                    'first_name' => trim($row['first_name'] ?? ''),
                    'last_name' => trim($row['last_name'] ?? ''),
                    'gender' => $row['gender'],
                    'phone' => $row['phone'],
                    'secondary_phone' => $row['secondary'] ?? null,
                    'emergency_contact' => $row['emergency'] ?? null,
                    'department_id' => $departmentId,
                    'date_of_birth' => $this->parseDate($row['birth_date']),
                    'date_of_joining' => $this->parseDate($row['join_date']),
                ]);
                Log::info("Imported user: {$email}");
            }
            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Import failed: ' . $e->getMessage());
            throw $e;
        }
    }
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|string|exists:roles,role_name',
            'department' => 'required|string|max:255|exists:departments,name',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|digits:10',
            'secondary' => 'nullable|digits:10',
            'emergency' => 'nullable|string|max:255',
            'birth_date' => 'required',
            'join_date' => 'required',
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
