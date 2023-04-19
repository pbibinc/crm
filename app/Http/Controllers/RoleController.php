<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){
            $data = Role::with('permissions')
            ->select('id', 'name', 'created_at', 'updated_at');
            return DataTables::of($data)
            ->addColumn('permmission_names', function (Role $role){
                $permissionNames = [];
                $permissions = $role->permissions;

                foreach (array_chunk($permissions, 3) as $permission) {
                    $permissionNames[] = ['name' => $permission->name];
                }
                return $permissionNames;
            })
            ->make(true);
        }

    
   
        return view('admin.role.index');
    }

    public function store(Request $request)
    {
        $role  = Role::create($request->validate([
            'name' => ['required', 'min:3'],
        ]));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions);
        return back();
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return to_route('admin.roles.index');
    }
}
