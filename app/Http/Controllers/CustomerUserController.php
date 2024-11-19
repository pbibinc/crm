<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
class CustomerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer-service.customer-user-setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            DB::beginTransaction();
            $user = User::find($request->customerUserDropdown);
            $user->userLead()->attach($request->leadId);
            DB::commit();
            return response()->json(['success' => 'User has been successfully added to the lead'], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $lead = Lead::find($id);
        return view('customer-service.customer-user-setting.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $lead = Lead::find($id) ?? null;
        if($lead){
            $user = $lead->userLead()->first();
        }

        return response()->json(['lead' => $lead, 'user' => $user ?? null], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUserAccountSetting(Request $request)
    {
        try{
            if($request->ajax()){
                $data = User::where('role_id', 12)->with('role')
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
                    $changePassword = '<button class="change-password btn btn-warning btn-sm" id="'.$data->id.'" name="change-password"  type="button"><i class="ri-lock-password-line"></i></button>';
                    return $editButton . ' '. $changePassword . ' ' . $deleteButton;
                })
            ->make(true);
            }
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function accountSettingView(Request $request)
    {

    }
}