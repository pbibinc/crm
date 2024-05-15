<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerHandle;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrokerHandleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userProfiles = UserProfile::orderBy('firstname')->get();
        return view('brokerHandle.index', compact('userProfiles'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userProfile = UserProfile::find($id);
        $brokerHandles = BrokerHandle::where('broker_userprofile_id', $id)->get();
        return response()->json(['userProfile' => $userProfile, 'brokerHandle' => $brokerHandles]);
        //
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

    public function getBrokerList(Request $request)
    {
        if($request->ajax())
        {
            $data = UserProfile::where('is_compliance_officer', 1)->orderBy('firstname')->get();
            return DataTables($data)
            ->addColumn('fullName', function($data){
                return $data->fullName();
            })
            ->addColumn('position', function($data){
                return $data->position->name;
            })
            ->addColumn('agents', function($data){
                $agents = BrokerHandle::where('broker_userprofile_id', $data->id)->get();
                $html = '';
                $count = 0;
                foreach($agents as $agent){
                    $userProfile = UserProfile::find($agent->agent_userprofile_id);
                    $html .= '<span class="badge bg-primary">'. $userProfile->fullName() . '</span> ';
                    $count++;

                    if($count % 3 == 0){
                        $html .= '<br>';
                    }
                }
                return $html;
            })
            ->addColumn('action', function($data){
                $updateButton = '<button class="edit btn btn-outline-primary btn-sm" id="'.$data->id.'"name="edit" type="button"><i class="ri-edit-box-line"></i></button>';
                $deleteButton = '<button class="delete btn btn-outline-danger btn-sm" id="'.$data->id.'" name="delete" type="button"><i class="ri-delete-bin-line"></i></button>';
                return $updateButton;
            })
            ->rawColumns(['action', 'agents'])
            ->make(true);
        }
    }
}