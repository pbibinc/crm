<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PolicyForRenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $forRenewal = $policyDetail->getPolicyForRenewal();
        $policiesData = $forRenewal->where('status', 'issued');
        if($request->ajax()){
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('policy_no', function($policiesData){
                $policyNumber = $policiesData->policy_number;
                $policyNumberLink = '<a href="" class="proccessRenewal" id="'.$policiesData->id.'">'.$policyNumber.'</a>';
                return $policyNumberLink;
            })
            ->addColumn('company_name', function($policiesData){
                $lead = $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads;
                $productId = $policiesData->quotation_product_id;
                $companyName = '<a href="/customer-service/renewal/get-renewal-lead-view/'.$productId.'">'.$lead->company_name.'</a>';
                return $companyName;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = SelectedQuote::where('quotation_product_id', $policiesData->selected_quote_id)->first();
                return $quote ? $quote->full_payment : 'N/A';
            })
            ->rawColumns(['company_name', 'policy_no'])
            ->make(true);
        }
        return view('customer-service.renewal.for-renewal.index');
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

    public function proccessRenewal($id)
    {

    }
}