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
<<<<<<< HEAD
        $permission = Permission::create($request->validate([
            'name' => ['required', 'min:3'],
        ]));
=======
       $permission = Permission::create($request->validate([
        'name' => ['required', 'min:3'],
       ]));
>>>>>>> 22e3eb75f02dd7592a7113ec7b9d66eb06579993
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
<<<<<<< HEAD

        $permission->update($request->all());

=======
    
        $permission->update($request->all());
    
>>>>>>> 22e3eb75f02dd7592a7113ec7b9d66eb06579993
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
