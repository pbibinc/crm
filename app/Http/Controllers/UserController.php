<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
       $users = User::all();
       $roles = Role::all();
       return view('admin.user.index', compact('users', 'roles'));
    }

   public function assignRole(Request $request, User $user)
   {
    
    $userRole = User::where('id', $request->userId)->first();
    $userRole['role_id'] = $request->role_id;
    $userRole->save();
    return to_route('admin.users.index',);
   }
}
