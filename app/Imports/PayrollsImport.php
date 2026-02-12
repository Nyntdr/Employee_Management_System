<?php

namespace App\Imports;

use App\Enums\PayStatus;
use App\Models\Employee;
use App\Models\Payroll;
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

class PayrollsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function collection(Collection $rows): void
    {
        Log::debug("PayrollsImport collection started");

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                Log::debug("Processing payroll import row", $row->toArray());
                if (empty($row['employee_email'])) {
                    Log::warning('Skipped empty payroll row', $row);
                    continue;
                }

                $user = User::where('email', trim($row['employee_email']))->first();
                if (!$user) {
                    Log::error('User not found for email: ' . $row['employee_email']);
                    continue;
                }

                $employee = Employee::with(['contracts' => function($query) {
                    $query->where('contract_status', 'active')
                        ->orderBy('start_date', 'desc');
                }])->where('user_id', $user->id)->first();

                if (!$employee) {
                    Log::error('Employee not found for user: ' . $row['employee_email']);
                    continue;
                }
                if ($employee->contracts->isEmpty()) {
                    Log::error('Employee has no active contract: ' . $row['employee_email']);
                    continue;
                }

                $activeContract = $employee->contracts->first();
                $basicSalary = $activeContract->salary;

                if ($basicSalary < 0) {
                    Log::error('Employee contract has invalid salary: ' . $row['employee_email']);
                    continue;
                }
                $generator = User::where('name', trim($row['generator']))->first();
                if (!$generator) {
                    Log::error('Generator user not found: ' . $row['generator']);
                    continue;
                }
                $monthYear = $this->parseMonthYear($row['month_year'] ?? null);
                if (!$monthYear) {
                    Log::error('Invalid month_year format: ' . ($row['month_year'] ?? 'empty'));
                    continue;
                }

                $existingPayroll = Payroll::where('employee_id', $employee->employee_id)
                    ->where('month_year', $monthYear)
                    ->first();

                if ($existingPayroll) {
                    Log::warning('Payroll already exists for employee and month', [
                        'employee_id' => $employee->employee_id,
                        'month_year' => $monthYear
                    ]);
                    continue;
                }
                $paidDate = null;
                if (!empty($row['paid_date'])) {
                    $paidDate = $this->parseDate($row['paid_date']);
                }

                $overtimePay = $row['overtime'] ?? 0;
                $bonus = $row['bonus'] ?? 0;
                $deductions = $row['deductions'] ?? 0;
                $paymentStatus = $row['payment_status'] ?? PayStatus::PENDING->value;

                $netSalary = $basicSalary + $overtimePay + $bonus - $deductions;

                if ($paymentStatus === PayStatus::PAID->value && empty($paidDate)) {
                    $paidDate = now()->format('Y-m-d');
                } elseif ($paymentStatus !== PayStatus::PAID->value) {
                    $paidDate = null;
                }

                Payroll::create([
                    'employee_id' => $employee->employee_id,
                    'month_year' => $monthYear,
                    'basic_salary' => $basicSalary,
                    'overtime_pay' => $overtimePay,
                    'bonus' => $bonus,
                    'deductions' => $deductions,
                    'net_salary' => $netSalary,
                    'payment_status' => $paymentStatus,
                    'paid_date' => $paidDate,
                    'generated_by' => $generator->id,
                ]);

                Log::info("Payroll imported successfully", [
                    'employee_id' => $employee->employee_id,
                    'month_year' => $monthYear
                ]);
            }

            DB::commit();
            Log::info("PayrollsImport completed successfully");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Payroll import failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function parseMonthYear($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            $value = trim($value);

            if (is_numeric($value)) {
                $date = Date::excelToDateTimeObject($value);
                return $date->format('Y-m');
            }
            return Carbon::parse($value)->format('Y-m');

        } catch (\Exception $e) {
            Log::warning("Failed to parse month_year: {$value}", ['error' => $e->getMessage()]);
            return null;
        }
    }
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        try {
            $value = trim($value);
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Failed to parse date: {$value}", ['error' => $e->getMessage()]);
            return null;
        }
    }
    public function rules(): array
    {
        return [
            'employee_email' => 'required|exists:users,email',
            'month_year' => 'required',
            'overtime' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:' . implode(',', array_column(PayStatus::cases(), 'value')),
            'paid_date' => 'nullable',
            'generator' => 'required|exists:users,name',
        ];
    }
}
