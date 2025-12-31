<?php

namespace App\Http\Controllers;

use App\Exports\PayrollsExport;
use App\Imports\PayrollsImport;
use App\Mail\PayslipMail;
use App\Models\Payroll;
use App\Enums\PayStatus;
use App\Models\Employee;
use App\Http\Requests\PayrollRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $payrolls = Payroll::query()->with(['employee', 'generator'])
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['payment_status','net_salary','month_year'], 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($q) use ($search) {
                        $q->whereAny(['first_name', 'last_name',], 'like', "%{$search}%");
                    })
                    ->orWhereHas('generator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('month_year', 'desc')
            ->orderBy('created_at', 'desc')->paginate(8);

        if ($request->ajax()) {
            return view('admin.salaries.table', compact('payrolls'))->render();
        }

        return view('admin.salaries.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();
        $statuses = PayStatus::cases();

        return view('admin.salaries.create', compact('statuses', 'employees'));
    }
    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Log::info("Importing file from payroll controller");
        Excel::import(new PayrollsImport(), $request->file('file'));
        Log::info("File imported successfully");
        return back()->with('success', 'All good!');
    }
    public function export()
    {
        return Excel::download(new PayrollsExport(), 'payrolls_export.xlsx');
    }
    public function store(PayrollRequest $request)
    {
        try {
            DB::beginTransaction();

            $employee = Employee::with(['contracts' => function($query) {
                $query->where('contract_status', 'active')
                    ->orderBy('start_date', 'desc');
            }])->findOrFail($request->employee_id);
            if ($employee->contracts->isEmpty()) {
                return redirect()->back()->withInput()
                    ->withErrors(['employee_id' => 'Employee does not have an active contract.']);
            }
            $activeContract = $employee->contracts->first();

            if (!$activeContract || empty($activeContract->salary) || $activeContract->salary < 0) {
                return redirect()->back()->withInput()
                    ->withErrors(['employee_id' => 'Employee contract has invalid or less than zero salary.']);
            }

            $payroll = new Payroll();
            $payroll->fill($request->validated());
            $payroll->basic_salary = $activeContract->salary;
            $payroll->generated_by = auth()->id();

            $payroll->overtime_pay = $request->overtime_pay ?? 0;
            $payroll->bonus = $request->bonus ?? 0;
            $payroll->deductions = $request->deductions ?? 0;

            $payroll->net_salary = $payroll->calculateNetSalary();

            if ($payroll->payment_status->value === PayStatus::PAID->value) {
                $payroll->paid_date = $request->paid_date ?? now()->format('Y-m-d');
            } else {
                $payroll->paid_date = null;
            }
            $payroll->save();

            DB::commit();

            return redirect()->route('payrolls.index')
                ->with('success', 'Payroll record created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payroll Store Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            return redirect()->back()->withInput()
                ->with('error', 'Failed to create payroll record. Error: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {

        $payroll = Payroll::with('employee', 'generator')->findOrFail($id);
        $statuses = PayStatus::cases();
        $employees = Employee::all();

        return view('admin.salaries.edit', compact('statuses', 'payroll', 'employees'));
    }

    public function update(PayrollRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $payroll = Payroll::with('employee')->findOrFail($id);
            $employee = Employee::with(['contracts' => function($query) {
                $query->where('contract_status', 'active')
                    ->orderBy('start_date', 'desc');
            }])->findOrFail($request->employee_id ?? $payroll->employee_id);

            if ($employee->contracts->isEmpty()) {
                return redirect()->back()->withInput()
                    ->withErrors(['employee_id' => 'Employee does not have an active contract.']);
            }
            $activeContract = $employee->contracts->first();

            if (!$activeContract || empty($activeContract->salary) || $activeContract->salary < 0) {
                return redirect()->back()->withInput()
                    ->withErrors(['employee_id' => 'Employee contract has invalid or less than zero salary.']);
            }

            $payroll->fill($request->validated());
            $payroll->basic_salary = $activeContract->salary;

            $payroll->overtime_pay = $request->overtime_pay ?? 0;
            $payroll->bonus = $request->bonus ?? 0;
            $payroll->deductions = $request->deductions ?? 0;

            $payroll->net_salary = $payroll->calculateNetSalary();

            if ($payroll->payment_status->value === PayStatus::PAID->value) {
                if ($request->filled('paid_date')) {
                    $payroll->paid_date = $request->paid_date;
                } elseif (!$payroll->paid_date) {
                    $payroll->paid_date = now()->format('Y-m-d');
                }
            } else {
                $payroll->paid_date = null;
            }
            $payroll->save();
            DB::commit();

            return redirect()->route('payrolls.index')
                ->with('success', 'Payroll record updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payroll Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Failed to update payroll record. Error: ' . $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            $payroll->delete();

            return redirect()->route('payrolls.index')
                ->with('success', 'Payroll record deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('payrolls.index')
                ->with('error', 'Failed to delete payroll record. Error: ' . $e->getMessage());
        }
    }
    public function generatePayslip($payrollId)
    {
        $payroll = Payroll::with(['employee.user', 'employee.latestContract', 'generator'])->findOrFail($payrollId);

        $pdf = Pdf::loadView('admin.salaries.payslip', compact('payroll'));

        return $pdf->download(
            'Payslip_'.$payroll->employee->first_name.'_'.$payroll->employee->last_name.'_'.$payroll->month_year.'.pdf'
        );
    }

    public function sendPayslipEmail($payrollId)
    {
        try {
            $payroll = Payroll::with(['employee.user', 'employee.latestContract', 'generator'])->findOrFail($payrollId);
            $downloadLink = route('payrolls.payslip', $payroll);
            Mail::to($payroll->employee->user->email)->send(new PayslipMail($payroll, $downloadLink));
            return redirect()->route('payrolls.index')
                ->with('success', 'Payslip download link sent to ' . $payroll->employee->user->email . '!');

        }
        catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return redirect()->route('payrolls.index')
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

}
