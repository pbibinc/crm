<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinancingAgreement;
use Illuminate\Http\Request;
use App\Models\FinancingCompany;
use App\Models\FinancingStatus;
use App\Models\Metadata;
use App\Models\PaymentOption;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class FinanceAgreementPolicyList extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-service.financing.finance-agreement-policy-list.index');
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

    public function getDataTable(Request $request)
    {
        $data = FinancingAgreement::all();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('policy_number', function($data){
            $quoteComparison = SelectedQuote::find($data->selected_quote_id);
            return $quoteComparison->quote_no;
        })
        ->addColumn('financing_company', function($data){
            $financeCompany = FinancingCompany::find($data->financing_company_id);
            return $financeCompany->name;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->QuoteComparison->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('product', function($data){
            $product = $data->QuoteComparison->QuotationProduct->product;
            return $product;
        })
        ->addColumn('auto_pay', function($data){
            $paymentOption = PaymentOption::where('financing_agreement_id', $data->id)->first();
            $autoPay = $data->is_auto_pay == 1 ? $paymentOption->payment_option : 'No';
            return $autoPay;
        })
        ->addColumn('media', function($data){
            $media = Metadata::find($data->media_id);
            $baseUrl = "https://insuraprime_crm.test/";
            $fullPath = $baseUrl . $media->filepath;
            return '<a href="'.$fullPath.'" target="_blank">'.$media->basename.'</a>';
        })
        ->rawColumns(['media'])
        ->make(true);
    }
}