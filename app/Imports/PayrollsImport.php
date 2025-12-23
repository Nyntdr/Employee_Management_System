<?php

namespace App\Imports;

use App\Enums\PayStatus;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PayrollsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        Log::debug('Importing Payrolls', ['row' => $row]);

        try {
            Log::info('Importing Payrollss', ['row' => $row]);
            if (empty($row['employee_id'])) {
                Log::warning('Skipped empty payroll row', $row);

                return null;
            }
            $payroll = new Payroll([
                'employee_id' => $row['employee_id'],
                'month_year' =>  $this->excelDateToCarbonM($row['month_year'] ?? null),
                'basic_salary' => $row['basic_salary'],
                'overtime_pay' => $row['overtime'] ?? null,
                'bonus' => $row['bonus'] ?? null,
                'deductions' => $row['deductions'] ?? null,
                'net_salary' => $row['net_salary'],
                'payment_status' => $row['payment_status'],
                'paid_date' => $this->excelDateToCarbon($row['paid_date'] ?? null),
                'generated_by' => $row['generator'],
            ]);
            $payroll->save();

            return $payroll;
        } catch (\Throwable $e) {

            Log::error('Payroll import failed', [
                'row' => $row,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

//    public function rules(): array
//    {
//        return[
//            'employee_id' => 'required|exists:employees,employee_id',
//            'month_year' => 'required|numeric',
//            'basic_salary' => 'required|numeric|min:0',
//            'overtime' => 'nullable|numeric|min:0',
//            'bonus' => 'nullable|numeric|min:0',
//            'deductions' => 'nullable|numeric|min:0',
//            'payment_status' => 'required|in:' . implode(',', array_column(PayStatus::cases(), 'value')),
//            'paid_date' => 'nullable|numeric',
//            'generator' =>'required|integer|exists:users,id',
//        ];
//    }

    private function excelDateToCarbon($value): ?string
    {
        if (!$value) {
            return null;
        }
        return Carbon::createFromTimestamp(
            ((int)$value - 25569) * 86400
        )->format('Y-m-d');
    }
    private function excelDateToCarbonM($value): ?string
    {
        if (!$value) {
            return null;
        }
        return Carbon::createFromTimestamp(
            ((int)$value - 25569) * 86400
        )->format('Y-m');
    }
}



