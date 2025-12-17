<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Enums\PayStatus;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls=Payroll::with('employee','generator')->get();
        return view('admin.salaries.index',compact('payrolls'));
    }
    public function create()
    {
        $employees=Employee::all();
        $statuses=PayStatus::cases();
        return view('admin.salaries.create', compact('statuses','employees'));
    }
    public function store(Request $request)
    {
        //
    }
    public function edit(string $id)
    {
        $employees=Employee::all();
        $statuses=PayStatus::cases();
        return view('admin.salaries.edit', compact('statuses','employees'));
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
