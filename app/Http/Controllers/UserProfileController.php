<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\UserProfile;
use App\Policies\UserProfilePolicy;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserProfileController extends Controller
{
    public function  index(Request $request)
    {
        $this->authorize('view', UserProfile::find(1));
        $positions = Position::all();
        $departments = Department::all();
        $accounts = User::all();
        $selectedAccountId = session('selectedAccountId');
        $usedAccounts = UserProfile::pluck('user_id')->toArray();

        $arrSearchArrAccounts = array_search($selectedAccountId, $usedAccounts);
        if ($arrSearchArrAccounts !== false){
            unset($usedAccounts[$arrSearchArrAccounts]);
        }

//        dd($arrSearchArrAccounts);
        session()->forget('selectedAccountId');


        // $userProfile = User
        if($request->ajax()){
            $userProfiles = UserProfile::with('position', 'department', 'user')
            ->select('id', 'firstname', 'lastname', 'american_surname', 'is_active', 'id_num',
            'position_id', 'department_id', 'user_id', 'created_at', 'updated_at');

            // $userProfiles->map(function($item){
            //     $item->created_at_formatted =
            //     $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
            //     return $item;
            // });

            return DataTables::of($userProfiles)
            ->addColumn('full_name', function ($userProfile){
                return $userProfile->firstname . ' ' . $userProfile->lastname;
            })
            ->addColumn('american_name', function ($userProfile){
                return $userProfile->firstname . ' ' . $userProfile->american_surname;
            })
            ->addColumn('position_name', function ($userProfile) {
                return $userProfile->position->name;
            })
            ->addColumn('department_name', function ($userProfile) {
                return $userProfile->department->name;
            })
            ->addColumn('user_name', function ($userProfile) {
                return $userProfile->user->name;
            })
            ->addColumn('created_at_formatted', function ($userProfile) {
                return Carbon::parse($userProfile->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('updated_at_formatted', function ($userProfile) {
                return Carbon::parse($userProfile->updated_at)->format('Y-m-d H:i:s');
            })

            ->addColumn('action', content: function($userProfile){
                $accounts = UserProfile::find($userProfile->id);
                $policy = resolve(UserProfilePolicy::class);
                $editButton = '';
                $deleteButton = '';
                if($policy->update(auth()->user(), $accounts)){
                    $editButton = '<button class="edit btn btn-primary btn-sm" id="'.$userProfile->id.'" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                }
                if($policy->delete(auth()->user(), $accounts)){
                    $deleteButton = '<button class="delete btn btn-danger btn-sm" id="'.$userProfile->id.'" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                }

                return $editButton . ' ' . $deleteButton;
            })
            ->make(true);
            // ->searchable(['full_name', 'american_name', 'id_num', 'position_name', 'is_active', 'department_name', 'user_name']);

        }
        return view('admin.user-profile.index', compact('positions', 'departments', 'accounts', 'usedAccounts'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Z][a-z]*/',
            'last_name' => 'required|regex:/^[A-Z][a-z]*/',
            'american_surname' => 'required|regex:/^[A-Z][a-z]*/',
            'id_num' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $userProfile = new UserProfile;
        $userProfile->firstname = ucfirst($request->input('first_name'));
        $userProfile->lastname = ucfirst($request->input('last_name'));
        $userProfile->american_surname = ucfirst($request->input('american_surname'));
        $userProfile->id_num = $request->input('id_num');
        $userProfile->position_id = $request->input('position_id');
        $userProfile->is_active = $request->input('is_active');
        $userProfile->department_id = $request->input('department_id');
        $userProfile->user_id = $request->input('account_id');
        $userProfile->save();

        return response()->json(['success' => 'User profile created successfully.']);
    }
    public function edit($id)
    {

        // $usedAccounts = UserProfile::pluck('user_id')->toArray();
        // $userProfile = UserProfile::find($id);
        if(request()->ajax())
        {
            $accounts = User::all();
            $accountsSelected = User::find($id);
            $usedAccounts = UserProfile::pluck('user_id')->toArray();
            $data = UserProfile::findorFail($id);
            return response()->json([
                'result' => $data,
                'usedAccounts'=> $usedAccounts,
                'accountsSelected' => $accountsSelected,
                'accounts' =>  $accounts
            ]);
            return redirect()->route('index')->with('selectedAccountId', $accountsSelected);
        }
    }

    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'first_name' => 'required|regex:/^[A-Z][a-z]*/',
        //     'last_name' => 'required|regex:/^[A-Z][a-z]*/',
        //     'american_surname' => 'required|regex:/^[A-Z][a-z]*/',
        //     'id_num' => 'required',
        // ]);
        // $error = Validator::make($request->all(), $validator);
        // if($error->fails())
        // {
        //     return response()->json(['errors' => $error->errors()->all()]);
        // }
        $form_data = array(
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'american_surname' => $request->american_surname,
            'id_num' => $request->id_num,
            'position_id' => $request->position_id,
            'is_active' => $request->is_active,
            'department_id' => $request->department_id,
            'user_id' => $request->account_id
        );
        UserProfile::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);


    }

    public function changeStatus()
    {

    }

    public function destroy(UserProfile $userProfile)
    {

        $userProfile->delete();
    }
}
