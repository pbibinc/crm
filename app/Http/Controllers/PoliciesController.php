<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            ->addColumn('expiration_date', function($data){
                $policy = PolicyDetail::where('quotation_product_id', $data->id)->first();
                return $policy->expiration_date;
            })
            ->make(true);
        }
    }

}