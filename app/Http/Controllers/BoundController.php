<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoundInformation;
use App\Models\FinancingStatus;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PaymentInformation;
use App\Models\PolicyDetail;
use App\Models\PricingBreakdown;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedPricingBreakDown;
use App\Models\SelectedQuote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BoundController extends Controller
{
    //
    public function index(Request $request)
    {
        $product = new QuotationProduct();
        $data = $product->getBoundList();
        if($request->ajax())
        {
            return DataTables::of($data)
                ->addColumn('company_name', function($data){
                    $company_name = $data->QuoteInformation->QuoteLead->leads->company_name;
                    return $company_name;
                })
                ->addColumn('policy_number', function($data){
                    if($data->status == 20){
                        $policyDetail =PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Renewal Request To Bind')->first();
                        $selectedQuote = SelectedQuote::find($data->selected_quote_id);
                        $policyNumber = '<a href="" id="'.$policyDetail->id.'" type="renewal" name="showPolicyForm" class="showPolicyForm" data-product='.$data->product.'>'.$selectedQuote->quote_no.'</a>';
                    }else if($data->status == 26){
                        $policyDetail =PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Dead policy')->first();
                        $selectedQuote = SelectedQuote::find($data->selected_quote_id);
                        $policyNumber = '<a href="" id="'.$policyDetail->id.'" type="renewal" name="showPolicyForm" class="showPolicyForm" data-product='.$data->product.'>'.$selectedQuote->quote_no.'</a>';
                    }else{
                        $selectedQuote = SelectedQuote::where('quotation_product_id', $data->id)->first();
                        $policyNumber = '<a href="" id="'.$data->id.'" name="showPolicyForm" type="new" class="showPolicyForm" data-product='.$data->product.'>'.$selectedQuote->quote_no.'</a>';
                    }
                    return $policyNumber;
                })
                ->addColumn('policy_total_cost', function($data){
                    if($data->status == 20){
                        $policyDetail =PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Renewal Request To Bind')->first();
                        $selectedQuote = SelectedQuote::find($data->selected_quote_id);
                    }else{
                        $selectedQuote = SelectedQuote::where('quotation_product_id', $data->id)->first();
                    }
                    return $selectedQuote ? $selectedQuote->TotalCost() : 0;
                })
                ->addColumn('effective_date', function($data){
                    if($data->status == 20){
                        $policyDetail =PolicyDetail::where('quotation_product_id', $data->id)->where('status', 'Renewal Request To Bind')->first();
                        $selectedQuote = SelectedQuote::find($data->selected_quote_id);
                    }else{
                        $selectedQuote = SelectedQuote::where('quotation_product_id', $data->id)->first();
                    }
                    return $selectedQuote ? $selectedQuote->effective_date : '';
                })
                ->rawColumns(['action', 'policy_number'])
                ->make(true);
        }
        return view('customer-service.policy.index');
    }

    public function getBoundInformation(Request $request)
    {
        $policyDetail = null;
        if($request->type == 'renewal'){
            $policyDetail = PolicyDetail::find($request->id);
            // $selectedQuote = SelectedQuote::find($policyDetail->selected_quote_id);
            // $product = QuotationProduct::find($policyDetail->quotation_product_id);
            $product = QuotationProduct::find($policyDetail->quotation_product_id);
            $selectedQuote = SelectedQuote::find($product->selected_quote_id);

        }else{
            $product = QuotationProduct::find($request->id);
            $selectedQuote = SelectedQuote::where('quotation_product_id', $request->id)->first();
        }
        $lead = $product->QuoteInformation->QuoteLead->leads;
        $marketName = QuoationMarket::find($selectedQuote->quotation_market_id);
        $paymentInformation = $selectedQuote->PaymentInformation;
        return response()->json(['product' => $product, 'lead' => $lead,  'marketName' => $marketName, 'paymentInformation' => $paymentInformation, 'selectedQuote' => $selectedQuote, 'policyDetail' => $policyDetail ? $policyDetail : null]);
    }

    public function saveBoundInformation(Request $request)
    {
        try{
            DB::beginTransaction();
            $userProfileId = Auth::user()->userProfile->id;
            if($request['productStatus'] == 19){
                $product = QuotationProduct::find($request->id);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);
                $boundStatus = 'Direct Renewals';
                $quotationProductId = $product->id;
            }else if($request['productStatus'] == 25){
                $product = QuotationProduct::find($request->id);
                $selectedQuote = SelectedQuote::find($product->selected_quote_id);
                $boundStatus = 'Rewrite/Recovery';
                $quotationProductId = $request->id;

                $policyDetail = PolicyDetail::where('quotation_product_id', $request->id)->where('status', 'Rewrite Request To Bind')->latest()->first();
                $policyDetail->status = 'Dead Policy';
                $policyDetail->save();
            }else{
                $product = QuotationProduct::find($request->id);
                $selectedQuote = SelectedQuote::where('quotation_product_id', $request->id)->first();
                $boundStatus = 'Direct New';
                $quotationProductId = $request->id;
            }
            $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuote->id)->first();

            //for pfa if the client choose spilit low down and low down
            if($paymentInformation->payment_term == 'Split low down' || $paymentInformation->payment_term == 'Low down')
            {
                $financingStatus = new FinancingStatus();
                $financingStatus->quotation_product_id = $request->id;
                $financingStatus->selected_quote_id = $selectedQuote->id;
                $financingStatus->status = "Request For Financing";
                $financingStatus->save();
            }
            $mediaIds = [];
            $medias = $product->medias()->get();
            foreach($medias as $media){
                $mediaIds[] = $media->id;
            }

            $lead = $product->QuoteInformation->QuoteLead->leads;
            foreach($mediaIds as $mediaId){
                $lead->getLeadMedias()->attach($mediaId);
                $product->medias()->detach($mediaId);
            }

            $boundInformation = new BoundInformation();
            $boundInformation->quoatation_product_id  = $quotationProductId;
            $boundInformation->user_profile_id = $userProfileId;
            $boundInformation->status = $boundStatus;
            $boundInformation->bound_date = now()->format('Y-m-d');
            $boundInformation->save();

            DB::commit();
            return response()->json(['message' => 'Bound Information has been saved.'], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
