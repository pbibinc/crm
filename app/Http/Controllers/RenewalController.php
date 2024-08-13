<?php

namespace App\Http\Controllers;

use App\Events\AssignPolicyForRenewalEvent;
use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\Messages;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\Templates;
use App\Models\UnitedState;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Exception;
class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        return view('customer-service.renewal.assig-policy-for-renewal.index', compact('renewals', 'userProfiles', 'data', 'groupedPolicy',));
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

    public function leadProfileView($policyDetailsId)
    {

            $policyDetail = PolicyDetail::find($policyDetailsId);
            $product = QuotationProduct::find($policyDetail->quotation_product_id);
            if (!$product) {
                Log::warning('Product not found', ['Product ID' => $product->id]);
                return redirect()->route('leads.appointed-leads')->withErrors('Product not found');
            }

            $lead = Lead::find($product->QuoteInformation->QuoteLead->leads->id);
            if (!$lead) {
                Log::warning('Lead not found', ['Product ID' => $product->id]);
                return redirect()->route('leads.appointed-leads')->withErrors('Lead not found');
            }

            $generalInformation = GeneralInformation::find($lead->generalInformation->id);
            if (!$generalInformation) {
                Log::warning('General Information not found', ['Lead ID' => $lead->id]);
                return redirect()->route('leads.appointed-leads')->withErrors('General Information not found');
            }

            $timezones = [
                'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
                'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
                'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
                'Pacific' => ['CA', 'OR', 'WA'],
                'Alaska' => ['AK'],
                'Hawaii-Aleutian' => ['HI']
            ];
            $timezoneStrings = [
                'Eastern' => 'America/New_York',
                'Central' => 'America/Chicago',
                'Mountain' => 'America/Denver',
                'Pacific' => 'America/Los_Angeles',
                'Alaska' => 'America/Anchorage',
                'Hawaii-Aleutian' => 'Pacific/Honolulu'
            ];

            $carriers = Insurer::all()->sortBy('name');
            $markets = QuoationMarket::all()->sortBy('name');
            $usAddress = UnitedState::getUsAddress($generalInformation->zipcode);
            $timezoneForState = null;
            foreach ($timezones as $timezone => $states) {
                if (in_array($lead->state_abbr, $states)) {
                    $timezoneForState = $timezoneStrings[$timezone];
                    break;
                }
            }
            $localTime = Carbon::now($timezoneForState ?: 'UTC');

            $generalLiabilities = $generalInformation->generalLiabilities;
            $quationMarket = new QuoationMarket();
            $templates = Templates::all();
            $userProfile = new UserProfile();
            $complianceOfficer = $userProfile->complianceOfficer();
            $products = $product->getQuotedProductByQuotedInformationId($product->quote_information_id);

            return view('leads.appointed_leads.renewal-lead-profile-view.index', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product', 'templates', 'complianceOfficer', 'carriers', 'markets', 'policyDetail', 'products'));
    }

    public function getRenewalReminder(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $policiesData = $policyDetail->getPolicyForRenewal()->where('status', 'Process Renewal');
        if($request->ajax()){
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                return $policyNumber;
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                return $lead->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::find($policiesData->selected_quote_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->addColumn('emailSentCount', function($policiesData){
                $sentCount = Messages::where('type', 'Renewal Reminder')->where('status', 'sent')->where('quotation_product_id', $policiesData->QuotationProduct->id)->count();
                $pendingCount = Messages::where('type', 'Renewal Reminder')->where('quotation_product_id', $policiesData->QuotationProduct->id)->count();
                return $sentCount . '/'. $pendingCount;
            })
            ->addColumn('action', function($policiesData){
                $setEmailSendingButton = '<button type="button" class="btn btn-outline-primary btn-sm waves-effect waves-light sentEmailButton" id="'.$policiesData->id.'" data-product-id="'.$policiesData->QuotationProduct->id.'"><i class="ri-mail-send-line"></i></button>';
                $viewButton = '<a href="/customer-service/renewal/get-renewal-lead-view/'.$policiesData->id.'"  id="'.$policiesData->policy_details_id.'" class="btn btn-sm btn-outline-info"><i class="ri-eye-line"></i></a>';
                $renewalQuoteButton = '<button type="button" class="btn btn-outline-success btn-sm waves-effect waves-light renewalReminder" id="'.$policiesData->id.'"><i class=" ri-task-line"></i></button>';
                return $setEmailSendingButton . ' ' . $viewButton . ' ' . $renewalQuoteButton;
            })
            ->rawColumns(['company_name', 'policy_no', 'action'])
            ->make(true);
        }
    }

}