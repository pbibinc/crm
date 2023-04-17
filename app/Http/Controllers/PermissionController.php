<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Log::info('store() called');
        $permission = Permission::create($request->validate([
            'name' => ['required', 'min:3'],
        ]));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return to_route('admin.permissions.index');
    }

    public function update(Request $request, Permission $permission)
    {
        // Log::info('store() called');
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Permission updated successfully',
        ]);
    }

    public function ajaxUpdate(Request $request, Permission $permission)
    {
        Log::info('ajaxUpdate() called');
    }
}
