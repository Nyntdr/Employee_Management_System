<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Enums\AssetStatuses;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        return view('admin.assets.create');
    }
    public function export()
    {
        return Excel::download(new AssetsExport(), 'assets_export.xlsx');
    }
    public function store(AssetRequest $request)
    {
        $validated = $request->validated();
        if (!isset($validated['status'])) {
            $validated['status'] = AssetStatuses::AVAILABLE->value;
        }
        Asset::create($validated);
        return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
    }

    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(AssetRequest $request, string $id)
    {
        $asset = Asset::findOrFail($id);

        $isCurrentlyAssigned = $asset->status->value === AssetStatuses::ASSIGNED->value;
        $data = $request->validated();
        if ($isCurrentlyAssigned && isset($data['status']) && $data['status'] !== AssetStatuses::ASSIGNED->value) {
            $hasActiveAssignments = $asset->assignments()
                ->where('status', 'active')
                ->exists();

            if ($hasActiveAssignments) {
                return redirect()->back()
                    ->withErrors(['status' => 'Cannot change status while asset has active assignments. Return the asset first.'])
                    ->withInput();
            }
        }
        $asset->update($data);
        return redirect()->route('assets.index')->with('success', 'Asset updated successfully!');
    }

    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->assignments()->exists()) {
            return redirect()->route('assets.index')
                ->with('error', 'Cannot delete asset that has assignment records. Delete assignments first.');
        }
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully!');
    }
}
