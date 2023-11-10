<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
    try{
        DB::beginTransaction();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
            'username' => 'required|unique:users,username',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->username = $request->username;
        $user->save();

        DB::commit();
    }catch(ValidationException $e){
        Log::info("Error for Assigning", [$e->getMessage()]);
        return response()->json([
            'errors' => $e->validator->errors(),
            'message' => 'Validation failed'
        ], 422);
    }
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
   public function update(Request $request)
   {
       $form_date = array(
           'name' => $request->name,
           'username' => $request->username,
           'email' => $request->email,
           'role_id' => $request->role_id
       );
     User::whereId($request->hidden_id)->update($form_date);
   }

   public function  destroy(User $user)
   {
       $user->delete();
   }
}