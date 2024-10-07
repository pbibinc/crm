<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerHandle;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignAgentToBrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $userProfiles = UserProfile::whereNot('is_compliance_officer', 1)->orderBy('firstname')->get();
        $userProfiles = UserProfile::orderBy('firstname')->get();
        return view('leads.assign-agent-to-broker.index', compact('userProfiles'));
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
        try{
            DB::beginTransaction();

            $validatedData = $request->validate([
                'hidden_id' => 'required',
                'agent' => 'required|array',
                'agent.*' => 'exists:user_profiles,id',
            ]);
            $oldBrokerHandle = BrokerHandle::where('broker_userprofile_id', $validatedData['hidden_id'])->delete();
            foreach($validatedData['agent'] as $agent){
                $brokernHandle = new BrokerHandle();
                $brokernHandle->broker_userprofile_id = $validatedData['hidden_id'];
                $brokernHandle->agent_userprofile_id = $agent;
                $brokernHandle->save();
            }
            DB::commit();
            return response()->json(['success' => 'Agents have been assigned to the broker']);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'errors' => $e->getMessage(),
                'message' => 'Validation failed'
            ], 422);
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
}
