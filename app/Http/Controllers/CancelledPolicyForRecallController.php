<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancelledPolicyForRecall;
use App\Models\PolicyDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelledPolicyForRecallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $data = $request->all();
            $userProfileId = auth()->user()->userProfile->id;

            // Parse the date from the request
            $forRecallDate = Carbon::parse($data['forRecallDate'])->format('Y-m-d');

            $canncelledPolicyForRecall = new CancelledPolicyForRecall();
            $canncelledPolicyForRecall->policy_details_id = $data['forRecalPolicyId'];
            $canncelledPolicyForRecall->date_to_call = $forRecallDate;
            $canncelledPolicyForRecall->remarks = $data['forRecallRemarks'];
            $canncelledPolicyForRecall->status = 'Pending';
            $canncelledPolicyForRecall->number_of_touches = 1;
            $canncelledPolicyForRecall->last_touch_user_profile_id = $userProfileId;
            $canncelledPolicyForRecall->save();

            DB::commit();
            return response()->json(['success' => 'Policy Recall Set'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['error' => $e], 500);
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
        try{
            DB::beginTransaction();
            $data = $request->all();
            $userProfileId = auth()->user()->userProfile->id;

            // Parse the date from the request
            $forRecallDate = Carbon::parse($data['forRecallDate'])->format('Y-m-d');

            $canncelledPolicyForRecall = CancelledPolicyForRecall::find($id);
            $canncelledPolicyForRecall->policy_details_id = $data['forRecalPolicyId'];
            $canncelledPolicyForRecall->date_to_call = $forRecallDate;
            $canncelledPolicyForRecall->remarks = $data['forRecallRemarks'];
            $canncelledPolicyForRecall->status = 'Pending';
            $canncelledPolicyForRecall->number_of_touches = $canncelledPolicyForRecall->number_of_touches + 1;
            $canncelledPolicyForRecall->last_touch_user_profile_id = $userProfileId;
            $canncelledPolicyForRecall->save();

            DB::commit();
            return response()->json(['success' => 'Policy Recall Set'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => $e], 500);
        }
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

    public function getCancelledPolicyForRecallIntialData(Request $request)
    {
        $dateToCall = Carbon::now()->addDays($request->nummberOfDays)->format('Y-m-d');
        $policy = PolicyDetail::find($request->id);
        $canncelledPolicyForRecall = $policy->CancelledPolicyForRecall;
        $lead = $policy->QuotationProduct->QuoteInformation->QuoteLead->leads;
        return response()->json(['status' => 'success','dateToCall' => $dateToCall, 'policy' => $policy, 'lead' => $lead, 'canncelledPolicyForRecall' => $canncelledPolicyForRecall], 200);
    }

    public function changeStatusForCancelledPolicyRecall(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $canncelledPolicyForRecall = CancelledPolicyForRecall::find($data['id']);
            $canncelledPolicyForRecall->status = $data['status'];
            $canncelledPolicyForRecall->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Status updated successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}