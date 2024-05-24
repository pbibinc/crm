<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancellationReport;
use App\Models\FinancingAgreement;
use App\Models\FinancingCompany;
use App\Models\PolicyDetail;
use App\Models\QuoteComparison;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IntentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-service.cancellation.intent.index');
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

    public function getIntentList(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getIntentList();

            return DataTables($data)
            ->addIndexColumn()
            ->addColumn('quote_number', function($data){
                $quoteNo = $data->policy_number;
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads_id;
                return  '<a href="/appointed-list/'.$leadId.'">'.$quoteNo.'</a>';
            })
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('financing_company', function($data){
                $financingAgreement = FinancingAgreement::where('selected_quote_id', $data->selected_quote_id)->first();
                if ($financingAgreement) {
                    $financingCompany = FinancingCompany::find($financingAgreement->financing_company_id);
                    if ($financingCompany) {
                        return $financingCompany->name ? $financingCompany->name : 'N/A';
                    }
                }
                return 'N/A';
            })
            ->addColumn('intent_start_date', function($data){
                $CancellationReport = CancellationReport::where('policy_details_id', $data->id)->first();
                return $CancellationReport->reinstated_date;
            })
            ->addColumn('intent_end_date', function($data){
                $CancellationReport = CancellationReport::where('policy_details_id', $data->id)->first();
                return $CancellationReport->reinstated_eligibility_date;
            })
            ->rawColumns(['quote_number'])
            ->make(true);
        }
    }
}
