<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
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

            $data->map(function($item){
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
                return $item;
            });

            return DataTables::of($data)
            ->addColumn('permmission_names', function (Role $role){
                $permissionNames = [];
                foreach ($role->permissions as $permission) {
                    $permissionNames[] = $permission->name ;
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
