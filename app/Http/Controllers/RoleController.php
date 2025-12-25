<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        return view('admin.roles.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:50|unique:roles,role_name',]);
        Role::create([
            'role_name' => $request->role_name,]);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'role_name' => 'required|string|max:50|unique:roles,role_name',
        ]);
        $role->update([
            'role_name' => $request->role_name,
        ]);
        return redirect()->route('roles.index');
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index');
    }
}
