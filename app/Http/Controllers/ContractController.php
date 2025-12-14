<?php

namespace App\Http\Controllers;

use App\Enums\JobTitle;
use App\Models\Contract;
use App\Models\Employee;
use App\Enums\ContractType;
use Illuminate\Http\Request;
use App\Enums\ContractStatus;
use App\Http\Requests\ContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with('employee')->latest()->get();
        return view('admin.contracts.index', compact('contracts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::orderBy('first_name')->orderBy('last_name')->get();
        $contractTypes = ContractType::cases();
        $contractStatuses = ContractStatus::cases();
        $jobTitles = JobTitle::cases();
        
        return view('admin.contracts.create', compact('employees', 'contractTypes', 'contractStatuses', 'jobTitles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractRequest $request)
    {
        Contract::create($request->validated());
            return redirect()->route('contracts.index')
                ->with('success', 'Contract created successfully!');

    }

    public function edit(string $id)
    {
        $employees = Employee::orderBy('first_name')->orderBy('last_name')->get();
        $contractTypes = ContractType::cases();
        $contractStatuses = ContractStatus::cases();
        $jobTitles = JobTitle::cases();
        
        return view('admin.contracts.edit', compact('contract', 'employees', 'contractTypes', 'contractStatuses', 'jobTitles'));

    }
    public function update(ContractRequest $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        $contract=Contract::findOrFail($id);
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully!');

    }
}
