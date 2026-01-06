<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use App\Models\Employee;
use App\Notifications\AssetUpdatedNotification;
use Illuminate\Http\Request;
use App\Enums\AssetStatuses;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        $cacheKey = 'assets_index_' . md5($search . '_page_' . $page);

        $assets =Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($search) {
                return Asset::query()
                    ->when($search, function ($query) use ($search) {
                        $query->whereAny(['asset_code', 'name', 'category', 'brand', 'model','serial_number','type','status','current_condition'], 'like', "%{$search}%");
                    })
                    ->orderByRaw("CASE WHEN status = ? THEN 1 ELSE 2 END", [AssetStatuses::REQUESTED->value])
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
            }
        );
        if ($request->ajax()) {
            return view('admin.assets.table', compact('assets'))->render();
        }

        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.assets.create',compact('employees'));
    }

    public function export()
    {
        return Excel::download(new AssetsExport(), 'assets_export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new AssetsImport, $request->file('file'));
            Cache::flush();
            return back()->with('success', 'Assets imported successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function store(AssetRequest $request)
    {
        $validated = $request->validated();

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = AssetStatuses::AVAILABLE->value;
        }

        // Set requested_at if requested_by is set but requested_at is not
        if (isset($validated['requested_by']) && !isset($validated['requested_at'])) {
            $validated['requested_at'] = now();
        }

        Asset::create($validated);
        Cache::flush();
        return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
    }

    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        $employees = Employee::all();
        return view('admin.assets.edit', compact('asset', 'employees'));
    }

    public function update(AssetRequest $request, string $id)
    {
        $asset = Asset::with(['assignments', 'requestedBy.user'])->findOrFail($id);

        $isCurrentlyAssigned = $asset->status->value === AssetStatuses::ASSIGNED->value;
        $data = $request->validated();
        $oldStatus = $asset->status->value;
        $newStatus = $request->status;

        // Handle requested_at logic
        if (isset($data['requested_by']) && !isset($data['requested_at'])) {
            $data['requested_at'] = now();
        }

        // Clear requested fields if status is no longer REQUESTED
        if ($oldStatus === AssetStatuses::REQUESTED->value && $newStatus !== AssetStatuses::REQUESTED->value) {
            $data['requested_by'] = null;
            $data['requested_at'] = null;
            $data['request_reason'] = null;
        }

        // Check if asset has active assignments when changing from ASSIGNED status
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
        Cache::flush();

        // Send notification if asset request was rejected (changed from REQUESTED to AVAILABLE)
        if ($oldStatus === AssetStatuses::REQUESTED->value &&
            $newStatus === AssetStatuses::AVAILABLE->value &&
            $asset->requestedBy &&
            $asset->requestedBy->user) {
            $asset->requestedBy->user->notify(new AssetUpdatedNotification($asset));
        }

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
        Cache::flush();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully!');
    }
}
