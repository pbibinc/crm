<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoundInformation;
use App\Models\FinancingStatus;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PolicyDetail;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
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
                    $quoteComparison = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                    $policyNumber = '<a href="" id="'.$data->id.'" name="showPolicyForm" class="showPolicyForm" data-product='.$data->product.'>'.$quoteComparison->quote_no.'</a>';
                    return $policyNumber;
                })
                ->addColumn('total_cost', function($data){
                    $totalCost = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first()->full_payment;
                    return $totalCost;
                })
                ->addColumn('effective_date', function($data){
                    $quote_information = QuoteComparison::where('quotation_product_id', $data->id)->where('recommended', 3)->first();
                    return $quote_information->effective_date;
                })
                ->rawColumns(['action', 'policy_number'])
                ->make(true);
        }
        return view('customer-service.policy.index');
    }

    public function getBoundInformation(Request $request)
    {
        $product = QuotationProduct::find($request->id);
        $lead = $product->QuoteInformation->QuoteLead->leads;
        $quoteComparison = QuoteComparison::where('quotation_product_id', $request->id)->where('recommended', 3)->first();
        $marketName = QuoationMarket::find($quoteComparison->quotation_market_id);
        $paymentInformation = $quoteComparison->PaymentInformation;
        return response()->json(['product' => $product, 'lead' => $lead, 'quoteComparison' => $quoteComparison, 'marketName' => $marketName, 'paymentInformation' => $paymentInformation]);
    }

    public function saveBoundInformation(Request $request)
    {
        try{
            DB::beginTransaction();
            $userProfileId = Auth::user()->userProfile->id;
            $quoteComparison = QuoteComparison::where('quotation_product_id', $request->id)->where('recommended', 3)->first();
            $paymentInformation = $quoteComparison->PaymentInformation;

            if($paymentInformation->payment_term == 'Split low down' || $paymentInformation->payment_term == 'Low down')
            {
                $financingStatus = new FinancingStatus();
                $financingStatus->quotation_product_id = $request->id;
                $financingStatus->status = "Request For Financing";
                $financingStatus->save();
            }
            $boundInformation = new BoundInformation();
            $boundInformation->quoatation_product_id  = $request->id;
            $boundInformation->user_profile_id = $userProfileId;
            $boundInformation->bound_date = now()->format('Y-m-d');
            $boundInformation->save();

            DB::commit();
            return response()->json(['message' => 'Bound Information has been saved.'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}
