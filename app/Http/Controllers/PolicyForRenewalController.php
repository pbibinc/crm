<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
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
        $userId = auth()->user()->id;
        $userProfileData = UserProfile::where('user_id', $userId)->first();
        $policiesData = $userProfileData->renewalPolicy();
        if($request->ajax()){
            return DataTables($policiesData)
            ->addIndexColumn()
            ->addColumn('company_name', function($policiesData){
                return $policiesData->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            })
            ->addColumn('product', function($policiesData){
                return $policiesData->QuotationProduct->product;
            })
            ->addColumn('previous_policy_price', function($policiesData){
                $quote = QuoteComparison::where('quotation_product_id', $policiesData->quotation_product_id)->where('recommended', 3)->first();
                return $quote->full_payment;
            })
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
}