<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\GeneralLiabilities;
use App\Models\Lead;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{
    //

    public function appointedLeadsView(Request $request)
    {

        if($request->ajax()){
            $leads = Lead::getAssignQuoteLeadsByUserProfileId(Auth::user()->userProfile->id);

            return DataTables::of($leads)
            ->addColumn('current_user', function($lead){
                $userProfile = $lead->userProfile->first();
                $currentUserName = $userProfile ? $userProfile->fullName(): 'N/A';
                return $currentUserName;
            })
            ->addColumn('action', function($lead){
                 $viewButton = '<button class="edit btn btn-info btn-sm" id="' . $lead->id . '"><i class="ri-eye-line"></i></button>';
                 return $viewButton;
            })
            ->make(true);
        }
        return view('leads.appointed_leads.index');
    }

    public function leadProfile(Request $request)
    {
        $lead = Lead::getLeads($request->leadId);
        $generalInformation = $lead->generalInformation;

        $timeLimit = 60 * 60;

        Cache::put('appointedLead', $lead, $timeLimit);
        Cache::put('generalInformation', $generalInformation, $timeLimit);


        return redirect()->route('lead-profile-view');
        // return view('leads.appointed_leads.index', compact('lead')

    }
    public function leadProfileView()
    {
        $lead = Cache::get('appointedLead');
        $generalInformation = Cache::get('generalInformation');
        // $generalLiabilities = GeneralLiabilities::
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
        $quationMarket = QuoationMarket::all();

        if(!$lead || !$generalInformation){
            return redirect()->route('leads.appointed-leads')->withErrors('No DATA found');
            // dd($lead, $generalInformation );
        }
        $usAddress = UnitedState::getUsAddress($generalInformation->zipcode);
        foreach($timezones as $timezone => $states){
            if(in_array($lead->state_abbr, $states)){
                $timezoneForState =  $timezoneStrings[$timezone];
            }
        }
        $localTime = Carbon::now($timezoneForState);
        $generalLiabilities = $generalInformation->generalLiabilities;
        // dd($generalInformation->id);

        return view('leads.appointed_leads.leads-profile', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket'));
    }

    public function saveQuotationProduct(Request $request)
    {
        if($request->ajax())
        {
            $quoteInformationId = $request->input('quoteInformationId');
            $product = $request->input('type');
            $quoteProduct = new QuotationProduct();
            $quoteProduct->quote_information_id = $quoteInformationId;
            $quoteProduct->product = $product;
            $quoteProduct->status = 2;
            $quoteProduct->save();
        }
    }

    public function saveQuoteComparison(Request $request)
    {
        if($request->ajax())
        {
            $quotationInformationId = $request->input('id');
            $marketId = $request->input('market');
            $fullPayment = $request->input('fullPayment');
            $downPayment = $request->input('downPayment');
            $monthlyPayment = $request->input('monthlyPayment');
            $brokerFee = $request->input('brokerFee');
            $reccomended = $request->input('reccomended');

            $quoteComparison = new QuoteComparison();
            $quoteComparison->quotation_product_id = $quotationInformationId;
            $quoteComparison->quotation_market_id = $marketId;
            $quoteComparison->full_payment = $fullPayment;
            $quoteComparison->down_payment = $downPayment;
            $quoteComparison->monthly_payment = $monthlyPayment;
            $quoteComparison->broker_fee = $brokerFee;
            $quoteComparison->recommended = $reccomended == 'true' ? 1  : 0;
            $quoteComparison->save();
        }
    }

    public function getComparisonData(Request $request)
    {
        if($request->ajax())
        {
            $quoteInformationId = $request->input('id');
            $quoteComparison = QuoteComparison::where('quotation_product_id', $quoteInformationId)->get();
            $market = QuoationMarket::all();
            return response()->json(['quoteComparison' => $quoteComparison, 'market' => $market]);
        }
    }

    public function updateQuotationComparison(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $marketId = $request->input('market');
            $fullPayment = $request->input('fullPayment');
            $downPayment = $request->input('downPayment');
            $monthlyPayment = $request->input('monthlyPayment');
            $brokerFee = $request->input('brokerFee');
            $reccomended = $request->input('reccomended');
            $productId = $request->input('productId');

            $quoteComparison = QuoteComparison::find($id);
            $quoteComparison->quotation_product_id = $productId;
            $quoteComparison->quotation_market_id = $marketId;
            $quoteComparison->full_payment = $fullPayment;
            $quoteComparison->down_payment = $downPayment;
            $quoteComparison->monthly_payment = $monthlyPayment;
            $quoteComparison->broker_fee = $brokerFee;
            $quoteComparison->recommended = $reccomended == 'true' ? 1  : 0;
            $quoteComparison->save();
        }
    }

    public function deleteQuotationComparison(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $quoteComparison = QuoteComparison::find($id);
            $quoteComparison->delete();
        }
    }

    public function sendQuotationProduct(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $quoteProduct = QuotationProduct::find($id);
            $quoteProduct->status = 1;
            $quoteProduct->sent_out_date = Carbon::now();
            $quoteProduct->save();
        }
    }

    public function getQuotedProduct(Request $request)
    {
        $userProfile = new UserProfile();

        if($request->ajax())
        {
            $quotationProduct = new QuotationProduct();
            $quotedProduct = $quotationProduct->quotedProduct();
            // Log::info('test the full american name', [$quotedProduct->QuoteInformation->QuoteLead->userProfile->fullAmericanName()]);
            return DataTables::of($quotedProduct)
            ->addColumn('formatted_sent_out_date', function($quotedProduct){
                $sentOutDate = $quotedProduct->sent_out_date ? Carbon::parse($quotedProduct->sent_out_date)->format('Y-m-d H:i:s') : 'N/A';
                return $sentOutDate;
            })
            ->addColumn('lead', function($quotedProduct){
                $lead = $quotedProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('market_specialist', function($quotedProduct){
                $marketSpecialist = $quotedProduct->QuoteInformation->QuoteLead->userProfile->fullAmericanName();
                return $marketSpecialist;
            })
            ->addColumn('checkBox', function($quotedProduct){
                $checkBox = '<input type="checkbox"  class="checkBox" name="quoteProduct" id="quoteProduct" value="'.$quotedProduct->id.'">';
                return $checkBox;
            })
            ->rawColumns(['checkBox'])
            ->make(true);
        }
        return view('leads.broker_leads.assign-quoted-leads', compact('userProfile'));
    }

    public function assignBrokerAssistant(Request $request)
    {
        if($request->ajax())
        {
            try{
                DB::beginTransaction();
                $productIds = $request->input('id');
                if($request->input('marketSpecialistUserProfileId')){
                 $userProfileId = $request->input('marketSpecialistUserProfileId');
                }else{
                 $userProfileId = $request->input('agentUserProfileId');
                }
                foreach($productIds as $productId)
                {
                   $brokerQuotation = new BrokerQuotation();
                   $brokerQuotation->quotation_product_id = $productId;
                   $brokerQuotation->user_profile_id = $userProfileId;
                   $brokerQuotation->assign_date = Carbon::now();
                   $brokerQuotation->save();

                   $quotationProduct = QuotationProduct::find($productId);
                   $quotationProduct->status = 3;
                   $quotationProduct->save();
                }
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in assign broker assistant', [$e->getMessage()]);
            }

        }
    }
}
