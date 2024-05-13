<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignQuotedRenewalPolicyController extends Controller
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
        $data = $policyDetail->getPolicyQuotedRenewal();
        $groupedPolicy = collect($data)->groupBy('company');
        if($request->ajax()){
            $userProfileId = $request->marketSpecialistId ? $request->marketSpecialistId : $request->accountProfileId;
            $userProfileData = UserProfile::find($userProfileId) ?? new UserProfile();
            $policiesData = $userProfileData->renewalQuotedPolicy();
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

        return view('customer-service.renewal.assign-quoted-for-renewal.index',compact('renewals', 'userProfiles', 'data', 'groupedPolicy'));
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
        $data = $request->all();
        $userProfile = $data['renewalAgentId'] ? $data['renewalAgentId'] : $data['agentUserProfileId'];
        $policies = $data['product'];
        $count = count($policies);
        $user = User::find(UserProfile::find($userProfile)->user_id);

        foreach($policies as $policy){
            $policyDetail = PolicyDetail::find($policy);
            $policyDetail->status = 'Renewal Quoted Assigned';
            $policyDetail->save();
            $policyDetail->quotedRenewalUserprofile()->attach($userProfile);
            $leadId = $policyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
        }
        return response()->json(['message' => 'Policy has been assigned for renewal'], 200);
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

    public function renewalPolicy(Request $request)
    {
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $data = $userProfileData->renewalQuotedPolicy();
    }

    public function voidQuotedPolicy(Request $request)
    {
        $data = $request->all();
        foreach($data['policyId'] as $policyId){
            $policyDetail = PolicyDetail::find($policyId);
            $policyDetail->status = 'Renewal Quoted';
            $policyDetail->save();
            $policyDetail->quotedRenewalUserprofile()->detach($data['userProfileId']);
        }
        return response()->json(['message' => 'Policy has been voided'], 200);
    }

    public function reassignQuotedRenewalPolicy(Request $request)
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
                $oldUserProfile->renewalQuotedPolicy()->detach($policy);
                $newUserProfile->renewalQuotedPolicy()->attach($policy);
            }
            DB::commit();
            return response()->json(['message' => 'Policy has been reassigned for renewal'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Reassigning", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
