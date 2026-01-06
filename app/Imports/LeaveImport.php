<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LeaveImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows): void
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $rowIndex => $row) {
                $rowNumber = $rowIndex + 2;

                if (empty($row['employee_email']) || empty($row['leave_type'])) {
                    throw new \Exception("Row {$rowNumber}: Missing required fields");
                }

                $employee = Employee::whereHas('user', function($query) use ($row) {
                    $query->where('email', $row['employee_email']);
                })->first();

                if (!$employee) {
                    throw new \Exception("Row {$rowNumber}: Employee not found with email: " . $row['employee_email']);
                }

                $leaveType = LeaveType::where('name', $row['leave_type'])->first();
                if (!$leaveType) {
                    throw new \Exception("Row {$rowNumber}: Leave type not found: " . $row['leave_type']);
                }

                $startDate = $this->parseDate($row['start_date']);
                $endDate = $this->parseDate($row['end_date']);
                if (!$startDate || !$endDate) {
                    throw new \Exception("Row {$rowNumber}: Invalid date format");
                }

                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);
                if ($end->lt($start)) {
                    throw new \Exception("Row {$rowNumber}: End date must be after start date");
                }

                $requestedDays = $start->diffInDays($end) + 1;

                $usedDays = Leave::where('employee_id', $employee->employee_id)
                    ->where('leave_type_id', $leaveType->id)
                    ->whereYear('start_date', $start->year)
                    ->where('status', 'approved')
                    ->get()
                    ->sum(function ($leave) {
                        $leaveStart = Carbon::parse($leave->start_date);
                        $leaveEnd = Carbon::parse($leave->end_date);
                        return $leaveStart->diffInDays($leaveEnd) + 1;
                    });

                if (($usedDays + $requestedDays) > $leaveType->max_days_per_year) {
                    throw new \Exception("Row {$rowNumber}: Exceeds maximum days for '{$leaveType->name}'. Used: {$usedDays} days, Requested: {$requestedDays} days, Max: {$leaveType->max_days_per_year} days");
                }

                $approvedBy = null;
                if (!empty($row['approved_by'])) {
                    $approver = User::where('name', $row['approved_by'])->first();
                    $approvedBy = $approver?->id;
                }

                Leave::create([
                    'employee_id' => $employee->employee_id,
                    'leave_type_id' => $leaveType->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'reason' => $row['reason'] ?? '',
                    'status' => $this->getValidStatus($row['status'] ?? 'pending'),
                    'approved_by' => $approvedBy,
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
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
            'status' => 'nullable|string|in:pending,approved,rejected',
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
    private function getValidStatus($status): string
    {
        return in_array($status, ['pending', 'approved', 'rejected'])
            ? $status
            : 'pending';
    }
}
