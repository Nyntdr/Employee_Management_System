<?php

namespace App\Http\Controllers;

use App\Enums\JobTitle;
use App\Exports\ContractsExport;
use App\Imports\ContractsImport;
use App\Models\Contract;
use App\Models\Employee;
use App\Enums\ContractType;
use Illuminate\Http\Request;
use App\Enums\ContractStatus;
use App\Http\Requests\ContractRequest;
use Maatwebsite\Excel\Facades\Excel;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $contracts = Contract::query()->with('employee')
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['contract_type','job_title','contract_status'], 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($q) use ($search) {
                        $q->whereAny(['first_name', 'last_name'], 'like', "%{$search}%");
                    });
            })
            ->latest()->paginate(6)->withQueryString();
        if ($request->ajax()) {
            return view('admin.contracts.table', compact('contracts'))->render();
        }
//        $contracts = Contract::with('employee')->latest()->paginate(6);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $employees = Employee::with('latestContract')->get();

        $contractTypes = ContractType::cases();
        $contractStatuses = ContractStatus::cases();
        $jobTitles = JobTitle::cases();

        return view('admin.contracts.create', compact('employees', 'contractTypes', 'contractStatuses', 'jobTitles'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new ContractsImport(), $request->file('file'));
        return back()->with('success', 'All good!');
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
        $contract = Contract::findOrFail($id);
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
        $contract = Contract::findOrFail($id);
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
