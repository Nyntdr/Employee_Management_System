<?php

namespace App\Http\Controllers;

use App\Enums\AssetConditions;
use App\Enums\AssetStatuses;
use App\Enums\AssignmentStatus;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\AssetRequestNotification;
use Illuminate\Http\Request;

class AssetRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $assets = Asset::query()->whereIn('status', ['available','requested'])
            ->when($search, function ($query) use ($search) {
            $query->whereAny(['asset_code', 'name', 'category', 'brand', 'model','type','current_condition'], 'like', "%{$search}%");
        })->paginate(8);
        if ($request->ajax()) {
            return view('employee.assets.available_table', compact('assets'))->render();
        }
        return view('employee.assets.request_asset_index', compact('assets'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        return view('employee.assets.request_asset', compact('asset'));
    }
    public function update(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);
        $currentStatus = $asset->status->value;
        if ($currentStatus === AssetStatuses::REQUESTED->value) {
            return redirect()->route('asset-requests.index')
                ->with('error','This asset has already been requested by someone.');
        }
        if ($currentStatus !== AssetStatuses::AVAILABLE->value) {
            return redirect()->route('asset-requests.index')
                ->with('error', 'This asset is not available for request at the moment.');
        }
        $employee = auth()->user()->employee;

        $asset->update([
            'status'         => AssetStatuses::REQUESTED->value,
            'requested_by'   => auth()->user()->employee->employee_id,
            'requested_at'   => now(),
            'request_reason' => $request->input('reason'),
        ]);
        $admins = User::whereIn('role_id', [1, 2])->get();
        foreach ($admins as $admin) {
            $admin->notify(new AssetRequestNotification($asset));
        }
        return redirect()->route('asset-requests.index')
            ->with('success', 'Asset requested successfully! Waiting for admin approval.');
    }
    public function destroy(string $id)
    {
        //
    }
}
