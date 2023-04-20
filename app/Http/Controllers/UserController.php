<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rules;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = User::with('role')
                ->select('id', 'name', 'username', 'role_id', 'email', 'created_at', 'updated_at');

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('role_name', function ($data){
                    return $data->role->name;
                })
                ->addColumn('created_at_formatted', function ($data){
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('updated_at_formatted', function ($data){
                    return Carbon::parse($data->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($data){
                    $editButton = '';
                    $deleteButton = '';
                    $deleteButton = '<button class="delete btn btn-danger btn-sm" id="'.$data->id.'" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                    $editButton =    $editButton = '<button class="edit btn btn-primary btn-sm" id="'.$data->id.'" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                    return $editButton . ' ' . $deleteButton;
                })
            ->make(true);
        }

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
     $validator = Validator::make($request->all(),[
         'name' => 'required|string|max:255',
         'email' => 'required|string|email|max:255|unique:'.User::class,
         'password' => ['required', 'confirmed', Rules\password::defaults()],
         'password_confirmation' => 'required|same:password'
     ]);

      if($validator->fails()){
          if($validator->errors()->has('password_confirmation')){
              $errors = new MessageBag;
              $errors->add('password_confirmation', 'The password confirmation does not match.');
              return redirect()->back()->withErrors($errors)->withInput();
          }else {
              return redirect()->back()->withErrors($validator)->withInput();
          }
      }

         $user = new User;
         $user->name = $request->name;
         $user->email = $request->email;
         $user->role_id = $request->role_id;
         $user->password = Hash::make($request->password);
         $user->username = $request->username;
         $user->save();


   }

   public  function edit($id)
   {
       if(request()->ajax())
       {
           $user = User::find($id);
           $role = Role::all();
           return response()->json([
               'result' => $user,
               'role' => $role
           ]);
       }
   }
   public function update()
   {

   }

   public function  destroy(User $user)
   {
       $user->delete();
   }
}
