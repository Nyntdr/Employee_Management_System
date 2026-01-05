<?php

namespace App\Http\Controllers;

use App\Exports\LeaveTypesExport;
use App\Imports\LeaveTypeImport;
use App\Models\LeaveType;
use App\Http\Requests\LeaveTypeRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class LeaveTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $cacheKey = 'leave_types_' . md5($search);

        $leave_types = Cache::remember($cacheKey, now()->addSeconds(30), function () use ($search) {
            return LeaveType::query()
                ->when($search, function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->get();
        });

        if ($request->ajax()) {
            return view('admin.leave-types.table', compact('leave_types'))->render();
        }

        return view('admin.leave-types.index', compact('leave_types'));
    }


    public function create()
    {
        return view('admin.leave-types.create');
    }
    public function export()
    {
        return Excel::download(new LeaveTypesExport(), 'leave_types_export.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new LeaveTypeImport(), $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function store(LeaveTypeRequest $request)
    {
        LeaveType::create($request->validated());
        Cache::flush();
        return redirect()->route('leave-types.index')->with('success', 'LeaveType added successfully!');
    }

    public function edit(string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        return view('admin.leave-types.edit', compact('leave_type'));
    }

    public function update(LeaveTypeRequest $request, string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        $leave_type->update($request->validated());
        Cache::flush();
        return redirect()->route('leave-types.index')->with('success', 'LeaveType updated successfully!');
    }

    public function destroy(string $id)
    {
        $leave_type = LeaveType::findOrFail($id);
        $leave_type->delete();
        return redirect()->route('leave-types.index')->with('success', 'LeaveType deleted successfully!');
    }
}
