<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
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

class LeaveImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                if (empty($row['employee_email']) || empty($row['leave_type'])) {
                    Log::warning('Skipped empty needed values leave record row', $row);
                    continue;
                }

                $user = User::where('email', $row['employee_email'])->first();
                if (!$user) {
                    Log::error('Employee not found with email: ' . $row['employee_email']);
                    continue;
                }

                $employee = Employee::where('user_id', $user->id)->first();
                if (!$employee) {
                    Log::error('Employee record not found for user: ' . $user->id);
                    continue;
                }

                $leaveType = LeaveType::where('name', $row['leave_type'])->first();
                if (!$leaveType) {
                    Log::error('Leave type not found: ' . $row['leave_type']);
                    continue;
                }

                $startDate = $this->parseDate($row['start_date']);
                $endDate = $this->parseDate($row['end_date']);

                if (!$startDate || !$endDate) {
                    Log::error('Invalid date format in row: ', $row);
                    continue;
                }

                $approvedBy = null;
                if (!empty($row['approved_by'])) {
                    $approver = User::where('name', $row['approved_by'])->first();
                    $approvedBy = $approver?->id;
                }

                $status = $row['status'] ?? 'pending';

                Leave::create([
                    'employee_id' => $employee->employee_id,
                    'leave_type_id' => $leaveType->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'reason' => $row['reason'] ?? '',
                    'status' => $status,
                    'approved_by' => $approvedBy,
                ]);
            }
            DB::commit();
            Log::info('Leave record import completed successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Leave record import failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'employee_email' => 'required|exists:users,email',
            'leave_type' => 'required|exists:leave_types,name',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required|string|max:500',
            'status' => 'string|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,name',
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
