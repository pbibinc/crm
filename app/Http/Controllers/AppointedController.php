<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\RecreationalController;
use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteLead;
use App\Models\RecreationalFacilities;
use App\Models\SelectedQuote;
use App\Models\Templates;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AppointedController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $leads = Lead::getAppointedLeadsByUserProfileId($user->id);
        if($request->ajax())
        {
            return DataTables::of($leads)
            ->addColumn('formatted_created_at', function($lead) {
                return \Carbon\Carbon::parse($lead->general_created_at)->format('m/d/Y');
            })
            ->addColumn('action', function($leads){
                $profileViewRoute = route('appointed-list-profile-view', ['leadsId' => $leads->id]);
                return '<a href="'.$profileViewRoute.'" class="viiew btn btn-success btn-sm" id="'.$leads->id.'" name"view"><i class="ri-eye-line"></i></a>';
            })
            ->rawColumns(['company_name_action', 'action'])
            ->make(true);
        }
        return view('leads.appointed_leads.appointed.index');
    }

    public function leadsProfileView(Request $request, $leadsId)
    {
        try {
            $leads = Lead::find($leadsId);
            $policyDetail = new PolicyDetail();
            $activePolicies = $policyDetail->getActivePolicyDetailByLeadId($leads->id);

            $usAddress = UnitedState::getUsAddress($leads->GeneralInformation->zipcode);
            $classCodeLeads = ClassCodeLead::all();
            $sortedClassCodeLeads = ClassCodeLead::sortByName($classCodeLeads);
            $recreationalFacilities = RecreationalFacilities::all();

            $states = [
                'CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV',
                'AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI', 'AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY',
                'CA', 'OR', 'WA', 'AK', 'HI'
            ];

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

            $timezoneForState = null;
            foreach ($timezones as $timezone => $statesArray) {
                if (in_array($leads->state_abbr, $statesArray)) {
                    $timezoneForState =  $timezoneStrings[$timezone];
                }
            }

            $localTime = Carbon::now($timezoneForState);
            $products = QuotationProduct::getQuotedProductByQuotedInformationId($leads->quoteLead->QuoteInformation->id);
            $quationMarket = new QuoationMarket();
            $templates = Templates::all();
            $markets = QuoationMarket::all()->sortBy('name');
            $carriers = Insurer::all()->sortBy('name');
            $userProfile = new UserProfile();
            $complianceOfficer = $userProfile->complianceOfficer();
            $productIds = $leads->getQuotationProducts()->pluck('id')->toArray();
            $selectedQuotes = SelectedQuote::whereIn('quotation_product_id', $productIds)->get() ?? [];
            $userProfiles = UserProfile::get()->sortBy('first_name');

            return view('leads.appointed_leads.apptaker-leads-view.index', compact('leads', 'localTime', 'usAddress', 'products', 'sortedClassCodeLeads', 'classCodeLeads', 'recreationalFacilities', 'states', 'quationMarket', 'carriers', 'markets', 'templates', 'complianceOfficer', 'selectedQuotes', 'activePolicies', 'userProfiles'));
        } catch (\Exception $e) {
            Log::error('Error in leadsProfileView method', [
                'message' => $e->getMessage(),
                'lead_id' => $leadsId,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while processing the leads profile.');
        }
    }

}
