<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RewriteBindingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function getRewriteBindingPolicy(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $userProfileId = auth()->user()->userProfile->id;
        $data = $policyDetail->getForRewritePolicyByProductStatusAndUserProfileId([28, 27, 26, 25, 24], $userProfileId);
        return DataTables($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('cancelled_date', function($data){
                return Carbon::parse($data->cancellationEndorsement->cancellation_date)->format('M-d-Y');
            })
            ->addColumn('cancelled_by', function($data){
                $userProfile = $data->cancellationEndorsement->UserProfile;
                return $userProfile ? $userProfile->fullAmericanName() : '';
            })
            ->addColumn('cancellation_type', function($data){
                $cancellationEndorsement = $data->cancellationEndorsement;
                return $cancellationEndorsement  ? $cancellationEndorsement->type_of_cancellation : '';
            })
            ->addColumn('policy_status', function($data){
                $policyStatus = $data->status;
                $product = $data->QuotationProduct;
                $statusLabel = $product->status;
                $class = 'bg-secondary';
                switch ($policyStatus) {
                    case $product->status == 25:
                        $class = 'bg-warning';
                        $statusLabel = 'Binding';
                        break;
                    case $product->status == 24:
                        $class = 'bg-warning';
                        $statusLabel = 'RTB';
                        break;
                    case $product->status == 28:
                        $class = 'bg-warning';
                        $statusLabel = 'Resend RTB';
                        break;
                    case $product->status == 27:
                        $class = 'bg-danger';
                        $statusLabel = 'Declined';
                        break;
                    case $product->status == 26:
                        $class = 'bg-success';
                        $statusLabel = 'Bound';
                        break;
                }
                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $product = $data->QuotationProduct;
                $viewButton = '<a href="/cancellation/get-for-rewrite-product-lead-view/'.$data->id.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $sendForQuotationButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light sendForQuotationButton" id="'.$data->id.'"><i class=" ri-clipboard-line"></i></button>';
                $resendButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light resendRTB" id="'.$data->quotation_product_id.'" data-policy-id="'.$data->id.'"><i class="  ri-repeat-2-line"></i></button>';
                if($product->status == 27){
                    return $viewButton . ' ' . $viewNotedButton . ' ' . $resendButton;
                }else{
                    return $viewButton . ' ' . $viewNotedButton;
                }

            })
            ->rawColumns(['action', 'policy_status'])
            ->make(true);
    }
}