<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\AssetAssignment;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AssetAssignmentRequest;
use App\Enums\AssignmentStatus;
use App\Enums\AssetConditions;

class AssetAssignmentController extends Controller
{
    public function index()
    {
        $asset_assigns = AssetAssignment::with(['asset', 'employee', 'assigner'])->latest()->paginate(6);
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

    public function store(AssetAssignmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['assigned_by'] = auth()->id();
        AssetAssignment::create($validated);
        Asset::where('asset_id', $request->asset_id)
            ->update(['status' => 'assigned']);
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

        return redirect()->route('asset-assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}