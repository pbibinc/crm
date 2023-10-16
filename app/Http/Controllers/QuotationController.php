<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendQoute;
use App\Models\BrokerQuotation;
use App\Models\GeneralInformation;
use App\Models\GeneralLiabilities;
use App\Models\Lead;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Demo\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        return response()->json(['lead' => $lead->id, 'generalInformation' => $generalInformation->id]);

    }
    public function leadProfileView($leadId, $generalInformationId)
    {
        $lead = Lead::find($leadId);
        $generalInformation = GeneralInformation::find($generalInformationId);
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

    public function brokerProfileView($leadId, $generalInformationId, $productId)
    {
        $lead = Lead::find($leadId);
        $generalInformation = GeneralInformation::find($generalInformationId);
        $product = QuotationProduct::find($productId);
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
        return view('leads.appointed_leads.broker-lead-profile-view', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product'));
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
            if($fullPayment && $downPayment && $monthlyPayment && $reccomended){
            $quoteComparison->quotation_product_id = $productId;
            $quoteComparison->quotation_market_id = $marketId;
            $quoteComparison->full_payment = $fullPayment;
            $quoteComparison->down_payment = $downPayment;
            $quoteComparison->monthly_payment = $monthlyPayment;
            $quoteComparison->broker_fee = $brokerFee;
            $quoteComparison->recommended = $reccomended == 'true' ? 1  : 0;
            }else{
                $quoteComparison->broker_fee = $brokerFee;
            }
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
        $quoationProduct = new QuotationProduct();
        $quoatedProduct = $quoationProduct->quotedProduct();
        $products = [];
        foreach($quoatedProduct as $product){
            $products[] = [
                'company_name'=> $product->QuoteInformation->QuoteLead->leads->company_name,
                'product' => $product,
                'quoted_by' => $product->QuoteInformation->QuoteLead->userProfile->fullAmericanName(),
                'leadId' => $product->QuoteInformation->QuoteLead->leads->id,
            ];
        }
        $groupedProducts = collect($products)->groupBy('company_name')->toArray();

        // dd($groupedProducts);

        // if($request->ajax())
        // {
        //     $quotationProduct = new QuotationProduct();
        //     $quotedProduct = $quotationProduct->quotedProduct();
        //     // Log::info('test the full american name', [$quotedProduct->QuoteInformation->QuoteLead->userProfile->fullAmericanName()]);
        //     return DataTables::of($quotedProduct)
        //     ->addColumn('formatted_sent_out_date', function($quotedProduct){
        //         $sentOutDate = $quotedProduct->sent_out_date ? Carbon::parse($quotedProduct->sent_out_date)->format('Y-m-d H:i:s') : 'N/A';
        //         return $sentOutDate;
        //     })
        //     ->addColumn('lead', function($quotedProduct){
        //         $lead = $quotedProduct->QuoteInformation->QuoteLead->leads->company_name;
        //         return $lead;
        //     })
        //     ->addColumn('market_specialist', function($quotedProduct){
        //         $marketSpecialist = $quotedProduct->QuoteInformation->QuoteLead->userProfile->fullAmericanName();
        //         return $marketSpecialist;
        //     })
        //     ->addColumn('checkBox', function($quotedProduct){
        //         $checkBox = '<input type="checkbox"  class="checkBox" name="quoteProduct" id="quoteProduct" value="'.$quotedProduct->id.'">';
        //         return $checkBox;
        //     })
        //     ->rawColumns(['checkBox'])
        //     ->make(true);
        // }
        return view('leads.broker_leads.assign-quoted-leads', compact('userProfile', 'groupedProducts', 'quoationProduct'));
    }

    public function assignBrokerAssistant(Request $request)
    {
        if($request->ajax())
        {
            try{
                DB::beginTransaction();
                $productIds = $request->input('ids');

                if($request->input('brokerAssistantId')){
                 $userProfileId = $request->input('brokerAssistantId');
                }else{
                 $userProfileId = $request->input('agentUserProfileId');
                }
                foreach($productIds as $productId)
                {
                   $brokerQuotation = new BrokerQuotation();
                   $brokerQuotation->quote_product_id = $productId;
                   $brokerQuotation->user_profile_id = $userProfileId;
                   $brokerQuotation->assign_date = Carbon::now();
                   $brokerQuotation->save();

                   $quotationProduct = QuotationProduct::find($productId);
                   $quotationProduct->status = 3;
                   $borkerQuotationSaving = $quotationProduct->save();

                   $qouteComparison = QuoteComparison::where('quotation_product_id', 1)->where('recommended', 1)->first();

                   if($borkerQuotationSaving){
                    $qoutedMailData = [
                        'title' => 'Qoutation For ' . $quotationProduct->QuoteInformation->QuoteLead->leads->company_name,
                        'customer_name' => $quotationProduct->QuoteInformation->QuoteLead->leads->GeneralInformation->customerFullName(),
                        'footer' => UserProfile::find($userProfileId)->fullAmericanName(),
                        'product' => $quotationProduct->product,
                        'prices' =>$qouteComparison
                    ];
                   $sendingMail =  Mail::to('maechael108@gmail.com')->send(new SendQoute($qoutedMailData));
                   if($sendingMail){
                    return response()->json(['success' => 'Mail sent successfully']);
                   }else{
                    return response()->json(['error' => 'Error in sending mail']);
                   }
                   }
                }
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in assign broker assistant', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    public function getPendingProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $pendingProduct = $quotationProduct->getAssignQoutedLead($userProfileId);
        $pendingProductCount = $pendingProduct->where('status', 3)->count();
        $followupProductCount = $pendingProduct->where('status', 4)->count();
        if($request->ajax())
        {
            return DataTables::of($pendingProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($pendingProduct){
                $lead = $pendingProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('viewButton', function($pendingProduct){
                $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="' . $pendingProduct->id . '"><i class="ri-eye-line"></i></button>';
                return $viewButton;
            })
            ->addColumn('statusColor', function($pendingProduct){
                if ($pendingProduct->status == 3) {
                    return '<span class="badge bg-info">Pending</span>';
                } elseif ($pendingProduct->status == 4) {
                    return '<span class="badge bg-warning">Follow up</span>';
                } else {
                    return '<span class="badge bg-default">Unknown</span>'; // Add an "Unknown" case or another default
                }
            })
            ->rawColumns(['viewButton', 'statusColor'])
            ->make(true);
        }

        return view('leads.broker_leads.index', compact('pendingProductCount', 'followupProductCount'));
    }

    public function quotedProductProfile(Request $request)
    {
        $productId = $request->input('id');
        $leadId = QuotationProduct::find($productId)->QuoteInformation->QuoteLead->leads->id;
        $generalInformationId = QuotationProduct::find($productId)->QuoteInformation->QuoteLead->leads->generalInformation->id;

        return response()->json(['leadId' => $leadId, 'generalInformationId' => $generalInformationId, 'productId' => $productId]);
    }

    public function getAssignQoutedLead(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $brokerId = $request->input('brokerAssistantId');
        $agentUserProfileId = $request->input('agentUserProfileId');
        $userProfileId = $brokerId ? $brokerId : $agentUserProfileId;
        if($userProfileId){
            $pendingProduct = $quotationProduct->getAssignQoutedLead($userProfileId);
        }else{
            $pendingProduct = null;
        }

        if($request->ajax())
        {
            if($pendingProduct !== null){
                $data = $pendingProduct;
            }else{
                $data = [];
            }
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', function($data){
                $lead = $data->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('checkbox', function($data){
                return '<input type="checkbox" name="leads_checkbox[]" class="leads_checkbox" value="' . $data->id . '" />';
            })
            ->rawColumns(['checkbox'])
            ->make(true);
        }
    }

    public function voidQoutedLead(Request $request)
    {
        $productIds = $request->input('ids');
        $userProfileId = $request->input('userProfileId');
        try{
            DB::beginTransaction();
            foreach($productIds as $productId){
                $quotationProduct = QuotationProduct::find($productId);
                $quotationProduct->status = 1;
                $quotationProduct->save();
                $brokerQuotation = BrokerQuotation::where('quote_product_id', $productId)->where('user_profile_id', $userProfileId)->first();
                $brokerQuotation->user_profile_id = null;
                $borkerQuotationSaving = $brokerQuotation->save();

            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error('Error in voiding qouted lead', [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function redeployQoutedLead(Request $request)
    {
        $productIds = $request->input('ids');
        $userProfileId = $request->input('userProfileId');
        $oldUserProfileId = $request->input('oldUserProfileId');
        try{
            DB::beginTransaction();
            foreach($productIds as $productId){
                $brokerQuotation = BrokerQuotation::where('quote_product_id', $productId)->where('user_profile_id', $oldUserProfileId)->first();
                $brokerQuotation->user_profile_id = $userProfileId;
                $brokerQuotation->save();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error('Error in redeploying qouted lead', [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function changeStatus(Request $request)
    {

        if($request->ajax())
        {
            $status = $request->input('status');
            $productId = $request->input('id');
            $qoutationProduct = QuotationProduct::find($productId);
            $qoutationProduct->status = $status;
            $quotationProductSaving = $qoutationProduct->save();
            if($quotationProductSaving){
                return response()->json(['success' => 'Status changed successfully']);
            }else{
                return response()->json(['error' => 'Error in changing status']);
            }
        }else{
            return response()->json(['error' => 'Error in changing status']);
        }
    }

    public function setCallBackDate(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $callbackDate = $request->input('callbackDateTime');
            $quotationProduct = QuotationProduct::find($id);
            $quotationProduct->callback_date = $callbackDate;
            $quotationProductSaving = $quotationProduct->save();
            if($quotationProductSaving){
                return response()->json(['success' => 'Callback date set successfully', 'callbackDate' => $quotationProduct->callback_date]);
            }else{
                return response()->json(['error' => 'Error in setting callback date']);
            }
        }
    }

    public function getConfirmedProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $confirmedProduct = $quotationProduct->getApprovedProduct($userProfileId);
        if($request->ajax())
        {
            return DataTables::of($confirmedProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($confirmedProduct){
                $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->make(true);
        }
        return view('leads.broker_leads.confirmed-product-list');
    }

}
