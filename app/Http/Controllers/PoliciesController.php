<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PoliciesController extends Controller
{
    //
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
            ->addColumn('insurer', function($data){
                $insurer = PolicyDetail::where('quotation_product_id', $data->id)->first()->insurer;
                return $insurer ? $insurer : '';
            })
            ->addColumn('effective_date', function($data){
                $policyId = PolicyDetail::where('quotation_product_id', $data->id)->first()->id;
                $productPolicies = GeneralLiabilitiesPolicyDetails::where('policy_details_id', $policyId)->first();
                // dd($productPolicies);
                return $productPolicies ? Carbon::createFromFormat('Y-m-d', $productPolicies->effective_date)->format('F d Y') : '';
            })
            ->addColumn('expiration_date', function($data){
                $policyId = PolicyDetail::where('quotation_product_id', $data->id)->first()->id;
                $productPolicies = GeneralLiabilitiesPolicyDetails::where('policy_details_id', $policyId)->first();
                // dd($productPolicies);
                return $productPolicies ? Carbon::createFromFormat('Y-m-d', $productPolicies->expiry_date)->format('F d Y') : '';
            })
            ->make(true);
        }
    }

}