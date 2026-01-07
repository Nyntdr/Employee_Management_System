<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets=Asset::all();
        return view('admin.assets.index',compact('assets'));
    }
    public function create()
    {
        return view('admin.assets.create');
    }
    public function store(AssetRequest $request)
    {
    $validated = $request->validated();
    Asset::create($validated);
    
    return redirect()->route('assets.index')->with('success', 'Asset created successfully!');
    }
    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id); 
        return view('admin.assets.edit',compact('asset'));
    }
    public function update(AssetRequest $request, string $id)
    {
    $asset = Asset::findOrFail($id);
    $asset->update($request->validated());
    return redirect()->route('assets.index')->with('success', 'Asset updated successfully!');
    }
    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully!');
    }
}
