<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;

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

   public function store(Request $request)
   {
      $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|string|email|max:255|unique:'.User::class,
         'password' => ['required', 'confirmed', Rules\password::defaults()],
     ]);

     $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'role_id' => $request->role_id,
         'password' => Hash::make($request->password),
     ]);

   }
}
