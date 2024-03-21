<?php

namespace App\Http\Controllers;

use App\Events\SendRenewalReminderEvent;
use App\Http\Controllers\Controller;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class PoliciesController extends Controller
{
    public function index(Request $request)
    {

        $data = PolicyDetail::orderBy('effective_date', 'desc');
        if($request->ajax())
        {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                $companyNameLink = "<a href='/appointed-list/".$data->QuotationProduct->QuoteInformation->QuoteLead->leads->id."'>".$company_name."</a>";
                return $companyNameLink;
            })
            ->addColumn('product', function($data){
                $product = $data->QuotationProduct->product;
                return $product;
            })
            ->addColumn('total_cost', function($data){
                $totalCost = $data->QuotationProduct->QouteComparison->where('recommended', 3)->first();
                if($totalCost){
                    return $totalCost->full_payment;
                }else{
                    return '';
                }
                // return $totalCost->full_payment;
            })
            ->rawColumns(['company_name'])
            ->make(true);
        }
        return view('customer-service.policy.index');
    }

    public function newPolicyList(Request $request)
    {
        $policy = new PolicyDetail();
        $data = $policy->NewPoicyList();
        if($request->ajax())
        {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->make(true);
        }
    }

    public function getPolicyList(Request $request)
    {
        if($request->ajax())
        {
            $quotationProduct = new PolicyDetail();
            $data = $quotationProduct->getPolicyDetailByLeadsId($request->input('id'));
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $policyNumber = PolicyDetail::where('quotation_product_id', $data->id)->first()->policy_number;
                return $policyNumber ? $policyNumber : '';
            })
            ->addColumn('carrier', function($data){
                $carrier = PolicyDetail::where('quotation_product_id', $data->id)->first()->carrier;
                return $carrier ? $carrier : '';
            })
            ->addColumn('market', function($data){
                $insurer = PolicyDetail::where('quotation_product_id', $data->id)->first()->market;
                return $insurer ? $insurer : '';
            })
            ->addColumn('effective_date', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->effective_date;
            })

            ->addColumn('status', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->status;
            })
            ->addColumn('expiration_date', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->expiration_date;
            })
            ->addColumn('action', function($data){
                $policyDetail = PolicyDetail::where('quotation_product_id', $data->id)->first();
                $quoteComparisonId = QuoteComparison::where('quotation_product_id', $policyDetail->QuotationProduct->id)->first()->id;

                $viewButton = '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$policyDetail->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                $renewQuoteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light renewQuoteButton" id="'.$data->id.'" data-quoteId="'.$quoteComparisonId.'"><i class="mdi mdi-account-reactivate"></i></button>';
                return $viewButton . ' ' . $renewQuoteButton . ' ' . $cancelButton;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getPolicyDetails(Request $request)
    {
        $data = $request->all();
        $policyDetail = PolicyDetail::where('quotation_product_id', $data['id']);

        return response()->json(['policy_detail' => $policyDetail]);
    }

    public function changeStatus(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $userProfileId = UserProfile::where('user_id', $userId)->first();
            $policyDetail = PolicyDetail::find($id);
            $policyDetail->status = $request['status'];
            $policyDetail->save();

            $quotationProduct = QuotationProduct::find($policyDetail->quotation_product_id);
            $leadId = $quotationProduct->QuoteInformation->QuoteLead->leads->id;
            if($request['status'] == "Renewal Quote"){
                event(new SendRenewalReminderEvent($leadId, $policyDetail->policy_number, $quotationProduct->product, $userProfileId->id));
            }
            DB::commit();
            return response()->json(['sucess' => 'Success']);
        }catch(\Exception $e){
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
