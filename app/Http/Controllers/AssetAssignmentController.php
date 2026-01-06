<?php

namespace App\Http\Controllers;

use App\Exports\AssetAssignmentsExport;
use App\Imports\AssetAssignmentImport;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\AssetAssignment;
use App\Notifications\AssetAssignedNotification;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AssetAssignmentRequest;
use App\Enums\AssignmentStatus;
use App\Enums\AssetConditions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AssetAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $asset_assigns = AssetAssignment::with(['asset', 'employee', 'assigner'])->latest()->paginate(6);
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'asset_assigns_index_' . md5($search . '_page_' . $page);

        $asset_assigns = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return AssetAssignment::query()->with(['asset', 'employee', 'assigner'])
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['purpose','status','condition_at_assignment','condition_at_return'], 'like', "%{$search}%")
                            ->orWhereHas('asset', function ($q) use ($search) {
                                $q->whereAny(['asset_code', 'name',], 'like', "%{$search}%");
                            })
                            ->orWhereHas('employee', function ($q) use ($search) {
                                $q->whereAny(['first_name', 'last_name',], 'like', "%{$search}%");
                            })
                            ->orWhereHas('assigner', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->latest()->paginate(6);
            }
        );
        if ($request->ajax()) {
            return view('admin.asset-assignments.table', compact('asset_assigns'))->render();
        }
        return view('admin.asset-assignments.index', compact('asset_assigns'));
    }

    public function create()
    {
        $assets = Asset::where('status', 'available')->get();
        $employees = Employee::all();
        $statuses = AssignmentStatus::cases();
        $conditions = AssetConditions::cases();
        return view('admin.asset-assignments.create', compact(
            'assets',
            'employees',
            'statuses',
            'conditions'
        ));
    }
    public function export()
    {
        return Excel::download(new AssetAssignmentsExport(), 'asset_assigns_export.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new AssetAssignmentImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Assignments imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function store(AssetAssignmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['assigned_by'] = auth()->id();

        $assignment = AssetAssignment::create($validated);

        Asset::where('asset_id', $request->asset_id)
            ->update(['status' => 'assigned']);
        Cache::flush();
        $employee = Employee::find($request->employee_id);
        if ($employee && $employee->user) {
            $asset = Asset::find($request->asset_id);
            $employee->user->notify(new AssetAssignedNotification($assignment, $asset));
        }

        return redirect()->route('asset-assignments.index')
            ->with('success', 'Asset assigned successfully!');
    }

    public function edit(string $id)
    {
        $asset_assign = AssetAssignment::findOrFail($id);
        $assets = Asset::all();
        $employees = Employee::all();
        $statuses = AssignmentStatus::cases();
        $conditions = AssetConditions::cases();

        return view('admin.asset-assignments.edit', compact(
            'asset_assign',
            'assets',
            'employees',
            'statuses',
            'conditions'
        ));
    }

    public function update(AssetAssignmentRequest $request, string $id): RedirectResponse
    {
        $asset_assign = AssetAssignment::findOrFail($id);

        $old_asset_id = $asset_assign->asset_id;
        $new_asset_id = $request->asset_id;

        $validated = $request->validated();
        unset($validated['assigned_by']);

        $asset_assign->update($validated);
        Cache::flush();
        if ($old_asset_id != $new_asset_id) {
            Asset::where('asset_id', $old_asset_id)->update(['status' => 'available']);
            Asset::where('asset_id', $new_asset_id)->update(['status' => 'assigned']);
        }
        return redirect()->route('asset-assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $asset_assign = AssetAssignment::findOrFail($id);
        Asset::where('asset_id', $asset_assign->asset_id)
            ->update(['status' => 'available']);

        $asset_assign->delete();
        Cache::flush();
        return redirect()->route('asset-assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}
