<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendQoute;
use App\Models\BrokerQuotation;
use App\Models\GeneralInformation;
use App\Models\GeneralLiabilities;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\PaymentInformation;
use App\Models\PricingBreakdown;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Demo\Product;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class QuotationController extends Controller
{
    //
    public function appointedLeadsView(Request $request)
    {
        $quotatationProduct = new QuotationProduct();
        $products = $quotatationProduct->getAssignedProductByUserProfileId(Auth::user()->userProfile->id);
        $groupedProducts = collect($products)->groupBy('company')->toArray();
        $quotedProductCount = $quotatationProduct->getQuotedProductByUserProfile(Auth::user()->userProfile->id)->count();
        $quotationdProductCount = $quotatationProduct->getQuotingProductByUserProfile(Auth::user()->userProfile->id)->count();
        $quotationProduct = new QuotationProduct();
        return view('leads.appointed_leads.index', compact('products', 'groupedProducts', 'quotedProductCount', 'quotationdProductCount', 'quotationProduct'));
    }

    public function leadProfile(Request $request)
    {
        $productId = QuotationProduct::find($request->input('productId'))->id;
        // $generalInformation = $lead->generalInformation;
        return response()->json(['productId' => $productId]);

    }

    public function leadProfileView($productId)
    {
        $product = QuotationProduct::find($productId);
        $lead = Lead::find($product->QuoteInformation->QuoteLead->leads->id);
        $generalInformation = GeneralInformation::find($lead->generalInformation->id);
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
        // $quationMarket = QuoationMarket::all()->sortBy('name');
        $quationMarket = new QuoationMarket();
        // dd($quationMarket->generalLiabilityMarket);
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
        return view('leads.appointed_leads.leads-profile', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product'));
    }

    public function brokerProfileView($leadId, $generalInformationId, $productId)
    {
        $lead = Lead::find($leadId);
        $generalInformation = GeneralInformation::find($generalInformationId);
        $product = QuotationProduct::find($productId);
        $userProfile = new UserProfile();
        $complianceOfficer = $userProfile->complianceOfficer();
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
        return view('leads.appointed_leads.broker-lead-profile-view', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities', 'quationMarket', 'product', 'complianceOfficer'));
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



            //declaring variable for quocte comparison
            $quotationProductId = $request->input('productId');
            $marketId = $request->input('marketDropdown');

            $fullPayment = $request->input('fullPayment');
            $downPayment = $request->input('downPayment');
            $monthlyPayment = $request->input('monthlyPayment');
            $brokerFee = $request->input('brokerFee');
            $reccomended = $request->input('recommended');
            $quoteNo = $request->input('quoteNo');
            $effectiveDate = $request->input('effectiveDate');

            // $media = $request->input('media');
            $convertedFullPayment = floatval($fullPayment);
            $convertedDownPayment = floatval($downPayment);

            //validations
            $exists = QuoteComparison::where('quotation_product_id', $quotationProductId)
            ->where('quotation_market_id', $marketId)
            ->exists();
            if($convertedFullPayment < $convertedDownPayment){
                return response()->json(['error' => 'Down payment must be less than full payment'], 422);
            }

            $validator = Validator::make($request->all(), [
                'fullPayment' => 'required',
                'downPayment' => 'required',
                'monthlyPayment' => 'required',
                'brokerFee' => 'required',
                'marketDropdown' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            if($exists == false){
                try{
                DB::beginTransaction();
                $files = $request->file('photos');
                $mediaIds = [];
                foreach($files as $file){
                    $basename = $file->getClientOriginalName();
                    $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');
                    $type = $file->getClientMimeType();
                    $size = $file->getSize();
                    if(!File::isDirectory($directoryPath)){
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }
                    $file->move($directoryPath, $basename);
                    $filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $basename;

                    $metadata = new Metadata();
                    $metadata->basename = $basename;
                    $metadata->filename = $basename;
                    $metadata->filepath = $filepath;
                    $metadata->type = $type;
                    $metadata->size = $size;
                    $metadata->save();
                    $mediaIds[] = $metadata->id;
                }

                //saving pricing breakdown
                $pricingBreakdown = new PricingBreakdown();
                $pricingBreakdown->premium = $request->input('premium');
                $pricingBreakdown->endorsements = $request->input('endorsements');
                $pricingBreakdown->policy_fee = $request->input('policyFee');
                $pricingBreakdown->inspection_fee = $request->input('inspectionFee');
                $pricingBreakdown->stamping_fee = $request->input('stampingFee');
                $pricingBreakdown->surplus_lines_tax = $request->input('surplusLinesTax');
                $pricingBreakdown->placement_fee = $request->input('placementFee');
                $pricingBreakdown->broker_fee = $request->input('brokerFee');
                $pricingBreakdown->miscellaneous_fee = $request->input('miscellaneousFee');
                $pricingBreakdown->save();

                $quoteComparison = new QuoteComparison();
                $quoteComparison->quotation_product_id = $quotationProductId;
                $quoteComparison->quotation_market_id = $marketId;
                $quoteComparison->pricing_breakdown_id = $pricingBreakdown->id;
                $quoteComparison->quote_no = $quoteNo;
                $quoteComparison->full_payment = $fullPayment;
                $quoteComparison->down_payment = $downPayment;
                $quoteComparison->monthly_payment = $monthlyPayment;
                $quoteComparison->broker_fee = $brokerFee;
                $quoteComparison->recommended = floatval($reccomended);
                $quoteComparison->effective_date = $effectiveDate;
                $quoteComparison->save();
                $quoteComparison->media()->sync($mediaIds);

                DB::commit();
                return response()->json(['success' => 'Quote comparison saved successfully']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in saving quote comparison', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
            }else{
                return response()->json(['error' => 'This market is already added'], 422);
            }
        }
    }

    public function getComparisonData(Request $request)
    {
        if($request->ajax())
        {
            $quoteInformationId = $request->input('id');
            $quoteComparison = QuoteComparison::where('quotation_product_id', $quoteInformationId)
                     ->orderBy('recommended', 'desc')
                    ->orderByRaw('CAST(full_payment AS DECIMAL(10,2)) DESC')  // Order by full_payment descending
                    ->get();
            $market = QuoationMarket::all();
            return response()->json(['quoteComparison' => $quoteComparison, 'market' => $market]);
        }
    }

    public function updateQuotationComparison(Request $request)
    {

        if($request->ajax())
        {
            try{
                DB::beginTransaction();

                 //declaring variable for quocte comparison
                 $id = $request->input('product_hidden_id');
                 $marketId = $request->input('marketDropdown');
                 $quotationNo = $request->input('quoteNo');
                 $fullPayment = $request->input('fullPayment');
                 $downPayment = $request->input('downPayment');
                 $monthlyPayment = $request->input('monthlyPayment');
                 $brokerFee = $request->input('brokerFee');
                 $reccomended = $request->input('recommended');
                 $productId = $request->input('productId');
                 $currentMarketId = $request->input('currentMarketId');
                 $effectiveDate = $request->input('effectiveDate');
                 $sender = $request->input('sender');

                //declaring variable for pricing breakdown
                $premmium = $request->input('premium');
                $endorsements = $request->input('endorsements');
                $policyFee = $request->input('policyFee');
                $inspectionFee = $request->input('inspectionFee');
                $stampingFee = $request->input('stampingFee');
                $surplusLinesTax = $request->input('surplusLinesTax');
                $placementFee = $request->input('placementFee');
                // $brokerFee = $request->input('brokerFee');
                $miscellaneousFee = $request->input('miscellaneousFee');

                $quoteComparison = QuoteComparison::find($id);
                $pricingBreakDown = PricingBreakdown::find($quoteComparison->pricing_breakdown_id);
                $exists = QuoteComparison::where('quotation_market_id', $marketId)->where('quotation_product_id', $productId)->where('id', '!=', $id)->exists();

                if(!$exists || $currentMarketId == $marketId){
                    if($sender == 'broker'){
                        $quoteComparison->full_payment = $request->hiddenFullpayment;
                        $quoteComparison->down_payment = $request->hiddenDownpayment;
                        $quoteComparison->broker_fee = $request->brokerFee;
                        $quoteComparison->save();

                        $pricingBreakDown->broker_fee = $brokerFee;
                        $pricingBreakDown->save();
                    }else{
                     if($fullPayment && $downPayment && $monthlyPayment && $brokerFee){
                        $quoteComparison->quotation_product_id = $productId;
                        $quoteComparison->quotation_market_id = $marketId;
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->recommended = $reccomended;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }else{
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }
                     $quoteComparison->save();


                     $pricingBreakDown->premium = $premmium;
                     $pricingBreakDown->endorsements = $endorsements;
                     $pricingBreakDown->policy_fee = $policyFee;
                     $pricingBreakDown->inspection_fee = $inspectionFee;
                     $pricingBreakDown->stamping_fee = $stampingFee;
                     $pricingBreakDown->broker_fee = $brokerFee;
                     $pricingBreakDown->surplus_lines_tax = $surplusLinesTax;
                     $pricingBreakDown->placement_fee = $placementFee;
                     $pricingBreakDown->miscellaneous_fee = $miscellaneousFee;
                     $pricingBreakDown->save();

                    }
                DB::commit();
                return response()->json(['success' => 'Quote comparison updated successfully']);
                }else{
                    return response()->json(['error' => 'This market is already added'], 422);
                }

            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in updating quote comparison', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    public function deleteQuotationComparison(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $quoteComparison = QuoteComparison::find($id);
            $quoteComparison->media()->detach();
            $quoteComparison->delete();
        }
    }

    public function editQuotationComparison(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $data = QuoteComparison::find($id);
            $media= $data->media;
            $pricingBreakdown = $data->PricingBreakdown;
            $market = QuoationMarket::find($data->quotation_market_id);
            return response()->json(['data' => $data, 'media' => $media, 'pricingBreakdown' => $pricingBreakdown, 'market' => $market]);
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
            return response()->json(['success' => 'Quotation product sent successfully']);
        }
    }

    //this use for geting quoted product
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
                'quoted_by' => $product->userProfile ? $product->userProfile->fullAmericanName() : 'N/A',
                'leadId' => $product->QuoteInformation->QuoteLead->leads->id,
            ];
        }
        $groupedProducts = collect($products)->groupBy('company_name')->toArray();


        return view('leads.broker_leads.assign-quoted-leads', compact('userProfile', 'groupedProducts', 'quoationProduct'));
    }


    //assigning of product into broker assistant
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
                   $quotationProduct->save();
                }
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in assign broker assistant', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    //getting pending product for broker assistant view
    public function getPendingProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $pendingProduct = $quotationProduct->getAssignQoutedLead($userProfileId);
        $pendingProductCount = 0;
        if ($pendingProduct) {
            $count = $pendingProduct->where('status', 3)->count();
            $pendingProductCount = $count > 0 ? $count : 0;
        }
        $followupProductCount = 0;

        if ($pendingProduct) {
            $count = $pendingProduct->where('status', 4)->count();
            $followupProductCount = $count > 0 ? $count : 0;
        }
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
                    return 'Pending';
                } elseif ($pendingProduct->status == 4) {
                    return 'Follow up';
                } elseif ($pendingProduct->status == 9){
                    return 'Make a Payment';
                }elseif ($pendingProduct->status == 10){
                    return 'Paid';
                }else{
                    return 'Unknown';
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
                $brokerQuotation->delete();
                // $borkerQuotationSaving = $brokerQuotation->save();
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
        $confirmedProduct = $quotationProduct->getProductToBind($userProfileId);
        if($request->ajax())
        {
            return DataTables::of($confirmedProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($confirmedProduct){
                $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('policy_no', function($confirmedProduct){
                $quoteComparison = QuoteComparison::where('quotation_product_id', $confirmedProduct->id)->first();
                return $quoteComparison->quote_no;
            })
            ->addColumn('viewButton', function($confirmedProduct){
                $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="' . $confirmedProduct->id . '"><i class="ri-eye-line"></i></button>';
                return $viewButton;
            })
            ->addColumn('statusColor', function($confirmedProduct){
              return $confirmedProduct->status;
            })
            ->rawColumns(['viewButton'])
            ->make(true);
        }
        return view('leads.broker_leads.confirmed-product-list');
    }

    public function getBrokerProduct(Request $request)
    {
        $quotationProduct = new QuotationProduct();
        $userProfileId = Auth::user()->userProfile->id;
        $pendingProduct = $quotationProduct->getQuotedProductFromQuoteProductByUserProfileId($userProfileId);

        if($request->ajax())
        {
            return DataTables::of($pendingProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($pendingProduct){
                $companyName = $pendingProduct->QuoteInformation->QuoteLead->leads->company_name;
                $companyLink = '<a href="lead-profile-view/'.$pendingProduct->id.'" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="68" data-name="'.$companyName.'">'.$companyName.'</a>';
                return $companyLink;
            })
            ->addColumn('viewButton', function($pendingProduct){
                $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="' . $pendingProduct->id . '"><i class="ri-eye-line"></i></button>';
                return $viewButton;
            })
            ->addColumn('brokerAssistant', function($pendingProduct){
                $brokerAssistant = BrokerQuotation::where('quote_product_id', $pendingProduct->id)->first();
                return $brokerAssistant->user_profile_id ? UserProfile::find($brokerAssistant->user_profile_id)->fullAmericanName() : 'N/A';
            })
            ->rawColumns(['viewButton', 'statusColor', 'company_name'])
            ->make(true);
        }
    }

    public function getGeneralLiabilitiesTable(Request $request)
    {
        if($request->ajax())
        {
         $quoteComparisson = QuoteComparison::where('quotation_product_id', $request->input('id'))->get();

         return DataTables::of($quoteComparisson)
         ->addIndexColumn()
         ->addColumn('status', function($quoteComparison){
            return $quoteComparison->recommended;
         })
         ->addColumn('market_name', function($quoteComparison){
             $market = QuoationMarket::find($quoteComparison->quotation_market_id);
            if($quoteComparison->recommended == 1){
                return '<i class="ri-star-fill"></i>' . ' ' . $market->name;
            }else if($quoteComparison->recommended == 2 || $quoteComparison->recommended == 3){
                return '<i class="a ri-vip-diamond-fill"></i>' . ' ' . $market->name;
            }else{
                return $market->name;
            }
         })
         ->addColumn('action', function($quoteComparison){
            $deletButton = '<button class="delete btn btn-outline-danger btn-sm deleteButton" id="' . $quoteComparison->id . '"><i class="ri-delete-bin-line"></i></button>';
            $editButton = '<button class="edit btn btn-outline-info btn-sm editButton" id="' . $quoteComparison->id . '"><i class="ri-edit-box-line"></i></button>';
            $uploadFileButton = '<button class="btn btn-outline-success btn-sm uploadFileButton" id="' . $quoteComparison->id . '"><i class="ri-upload-2-line"></i></button>';
            return $editButton . ' ' . $uploadFileButton . ' ' . $deletButton;
         })
         ->addColumn('broker_action', function($quoteComparison){
            $market = QuoationMarket::find($quoteComparison->quotation_market_id);
            $leads = QuoteLead::find(QuoteInformation::find($quoteComparison->QuotationProduct->quote_information_id)
            ->quoting_lead_id)->leads;
            $paymentInformation = PaymentInformation::where('quote_comparison_id', $quoteComparison->id)->first();
            $generalInformation = $leads->GeneralInformation;
            $quoteProduct = $quoteComparison->QuotationProduct;

            $uploadFileButton = '<button class="btn btn-outline-success btn-sm uploadFileButton" id="' . $quoteComparison->id . '"><i class="ri-upload-2-line"></i></button>';

            $editButton = '<button class="edit btn btn-outline-info btn-sm editButton" id="' . $quoteComparison->id . '"><i class="ri-edit-box-line"></i></button>';

            if($paymentInformation){
                $makePaymentButton = '<button class="btn btn-outline-secondary btn-sm makePaymentButton" id="' . $quoteComparison->id .'" data-quoteNo="'.$quoteComparison->quote_no.'" data-market="'.$market->name.'" data-company-name="'.$leads->company_name.'" data-insured-firstname="'.$generalInformation->firstname.'"
                data-insured-lastname="'.$generalInformation->lastname.'" data-email="'.$generalInformation->email_address.'" data-broker-fee="'.$quoteComparison->broker_fee.'" data-total-premium="'.$quoteComparison->full_payment.'" data-lead-id="'.$leads->id.'" data-general-information-id="'.$generalInformation->id.'" data-effective-date = "'.$quoteComparison->effective_date.'" data-status="'.$quoteProduct->status.'" data-productId="'.$quoteProduct->id.'" data-payment-information="'.htmlspecialchars(json_encode($paymentInformation), ENT_QUOTES, 'UTF-8').'"><i class="ri-money-dollar-circle-line"></i></button>';
            }else{
                $makePaymentButton = '<button class="btn btn-outline-secondary btn-sm makePaymentButton" id="' . $quoteComparison->id .'" data-quoteNo="'.$quoteComparison->quote_no.'" data-market="'.$market->name.'" data-company-name="'.$leads->company_name.'" data-insured-firstname="'.$generalInformation->firstname.'"
                data-insured-lastname="'.$generalInformation->lastname.'" data-email="'.$generalInformation->email_address.'" data-broker-fee="'.$quoteComparison->broker_fee.'" data-total-premium="'.$quoteComparison->full_payment.'" data-lead-id="'.$leads->id.'" data-general-information-id="'.$generalInformation->id.'" data-effective-date = "'.$quoteComparison->effective_date.'" data-product><i class="ri-money-dollar-circle-line"></i></button>';
            }
            return $editButton . ' ' . $makePaymentButton . ' ' . $uploadFileButton;
         })

         ->rawColumns(['market_name', 'action', 'broker_action'])
         ->make(true);
        }
    }

}
