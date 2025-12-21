<?php

namespace App\Http\Controllers;

use App\Enums\JobTitle;
use App\Exports\ContractsExport;
use App\Models\Contract;
use App\Models\Employee;
use App\Enums\ContractType;
use Illuminate\Http\Request;
use App\Enums\ContractStatus;
use App\Http\Requests\ContractRequest;
use Maatwebsite\Excel\Facades\Excel;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('employee')->latest()->paginate(6);
        return view('admin.contracts.index', compact('contracts'));
    }
    public function create()
{
    $employees = Employee::with('latestContract')->get();

    $contractTypes = ContractType::cases();
    $contractStatuses = ContractStatus::cases();
    $jobTitles = JobTitle::cases();

    return view('admin.contracts.create', compact('employees','contractTypes','contractStatuses','jobTitles' ));
}
    public function export()
    {
        return Excel::download(new ContractsExport(), 'contracts_export.xlsx');
    }
    public function store(ContractRequest $request)
    {
        Contract::create($request->validated());
            return redirect()->route('contracts.index')
                ->with('success', 'Contract created successfully!');
    }
    public function edit(string $id)
    {
        $contract=Contract::findOrFail($id);
        $employees = Employee::orderBy('first_name')->orderBy('last_name')->get();
        $contractTypes = ContractType::cases();
        $contractStatuses = ContractStatus::cases();
        $jobTitles = JobTitle::cases();

        return view('admin.contracts.edit', compact('contract', 'employees', 'contractTypes', 'contractStatuses', 'jobTitles'));
    }
    public function update(ContractRequest $request, string $id)
    {
        $contract = Contract::findOrFail($id);

        $contract->update($request->validated());

        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully!');
    }
    public function destroy(string $id)
    {
        $contract=Contract::findOrFail($id);
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
