<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Enums\PayStatus;
use App\Models\Employee;
use App\Http\Requests\PayrollRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee', 'generator')
            ->orderBy('month_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.salaries.index', compact('payrolls'));
    }
    
    public function create()
    {
        $employees = Employee::all();
        $statuses = PayStatus::cases();
        
        return view('admin.salaries.create', compact('statuses', 'employees'));
    }
    
    public function store(PayrollRequest $request)
    {
        try {
            DB::beginTransaction();
            $existingPayroll = Payroll::where('employee_id', $request->employee_id)
                ->where('month_year', $request->month_year)
                ->first();
                
            if ($existingPayroll) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['month_year' => 'Payroll already exists for this employee and month.']);
            }
            
            $payroll = new Payroll();
            $payroll->fill($request->validated());
            $payroll->generated_by = auth()->id();
            $payroll->net_salary =$payroll->calculateNetSalary();
            if ($payroll->payment_status !== PayStatus::PAID) {
                $payroll->paid_date = null;
            }
            
            $payroll->save();
            
            DB::commit();
            
            return redirect()->route('payrolls.index')
                ->with('success', 'Payroll record created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
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
            
            $payroll = Payroll::findOrFail($id);
            $existingPayroll = Payroll::where('employee_id', $request->employee_id)
                ->where('month_year', $request->month_year)
                ->where('payroll_id', '!=', $id)
                ->first();
                
            if ($existingPayroll) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['month_year' => 'Payroll already exists for this employee and month.']);
            }

            $oldNetSalary = $payroll->net_salary;
            
            $payroll->fill($request->validated());
            $payroll->net_salary = $payroll->calculateNetSalary();
            if ($payroll->payment_status !== PayStatus::PAID) {
                $payroll->paid_date = null;
            }
            
            $payroll->save();
            
            DB::commit();
            
            return redirect()->route('payrolls.index')
                ->with('success', 'Payroll record updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
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
}