<?php

namespace App\Http\Controllers;

use App\Events\AssignPolicyForRenewalEvent;
use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $policyDetail = new PolicyDetail();
        $userProfile = new UserProfile();
        $apptaker = $userProfile->apptaker();
        $renewals = $userProfile->renewal();
        $userProfiles = $userProfile->userProfiles();
        $data = $policyDetail->getPolicyForRenewal();
        $groupedPolicy = collect($data)->groupBy('company');
        if($request->ajax()){
            $userProfileId = $request->marketSpecialistId ? $request->marketSpecialistId : $request->accountProfileId;
            $userProfileData = UserProfile::find($userProfileId) ?? new UserProfile();
            $policiesData = $userProfileData->renewalPolicy();
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('checkBox', function($policiesData){
                return '<input type="checkbox" class="policy_checkbox" name="product[]" value="'.$policiesData->policy_details_id.'">';
            })
            ->addColumn('company_name', function($policiesData){
                return $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->rawColumns(['checkBox'])
            ->make(true);
        }
        return view('customer-service.renewal.assig-policy-for-renewal.index', compact('renewals', 'userProfiles', 'data', 'groupedPolicy'));
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

    public function assignPolicyForRenewal(Request $request)
    {
        $data = $request->all();
        $userProfile = $data['renewalAgentId'] ? $data['renewalAgentId'] : $data['agentUserProfileId'];
        $policies = $data['product'];
        $count = count($policies);
        $user = User::find(UserProfile::find($userProfile)->user_id);

        foreach($policies as $policy){
            $policyDetail = PolicyDetail::find($policy);
            $policyDetail->userProfile()->sync($userProfile);
            $leadId = $policyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
            event(new AssignPolicyForRenewalEvent($policyDetail->policy_number, $userProfile, $leadId, $user->id));
        }
        $user->sendRenewalPolicyNotification($user, $policies, $count);
        return response()->json(['message' => 'Policy has been assigned for renewal'], 200);
    }

    public function reassignPolicyForRenewal(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $policies = $data['policyId'];
            $oldId = $data['oldProductOwnerUserProfileId'];
            $newId = $data['userProfileId'];
            foreach($policies as $policy){
                $oldUserProfile = UserProfile::find($oldId);
                $newUserProfile = UserProfile::find($newId);
                $oldUserProfile->renewalPolicy()->detach($policy);
                $newUserProfile->renewalPolicy()->attach($policy);
            }
            DB::commit();
            return response()->json(['message' => 'Policy has been reassigned for renewal'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Reassigning", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function voidPolicyForRenewal(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $policies = $data['policyId'];
            foreach($policies as $policy){
                $userProfile = UserProfile::find($data['userProfileId']);
                $userProfile->renewalPolicy()->detach($policy);
            }
            DB::commit();
            return response()->json(['message' => 'Policy has been voided for renewal'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Voiding", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
