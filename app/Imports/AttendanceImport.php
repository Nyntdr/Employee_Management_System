<?php

namespace App\Imports;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AttendanceImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {

                // Skip empty essential fields
                if (empty($row['employee_email']) || empty($row['date'])) {
                    Log::warning('Skipping row due to missing email or date', $row->toArray());
                    continue;
                }

                // Find user by email
                $user = User::where('email', $row['employee_email'])->first();
                if (!$user) {
                    Log::error('User not found: ' . $row['employee_email']);
                    continue;
                }

                // Find employee
                $employee = Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    Log::error('Employee record not found for user: ' . $row['employee_email']);
                    continue;
                }

                // Parse times
                $clockIn  = $this->parseTime($row['clock_in'] ?? null);
                $clockOut = $this->parseTime($row['clock_out'] ?? null);

                // Calculate total hours
                $totalHours = null;
                if ($clockIn && $clockOut) {
                    $totalHours = Carbon::parse($clockOut)
                        ->diff(Carbon::parse($clockIn))
                        ->format('%H:%I:%S');
                }

                Attendance::create([
                    'employee_id' => $employee->employee_id,
                    'date'        => $this->parseDate($row['date']),
                    'clock_in'    => $clockIn,
                    'clock_out'   => $clockOut,
                    'total_hours' => $totalHours,
                    'status'      => $row['status'],
                ]);
            }

            DB::commit();
            Log::info('Attendance Excel import completed successfully');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Attendance import failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            '*.employee_email' => 'required|exists:users,email',
            '*.date'           => 'required',
            '*.clock_in'       => 'nullable',
            '*.clock_out'      => 'nullable',
            '*.status'         => ['required', Rule::enum(AttendanceStatus::class)],
        ];
    }

    private function parseDate($value): ?string
    {
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseTime($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('H:i:s');
            }
            return Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
