<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForRewriteMakePaymentController extends Controller
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

    public function getForRewriteMakePayment(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $userProfileId = auth()->user()->userProfile->id;
        $data = $policyDetail->getForRewritePolicyByStatusAndUserProfileId('For Rewrite Make A Payment', $userProfileId);
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
                $status = $data->QuotationProduct->QouteComparison()->latest()->first()->PaymentInformation->status;
                $statusLabel = $status;
                $class = 'bg-secondary';
                switch ($status) {
                    case 'resend':
                        $class = 'bg-warning';
                        break;
                    case 'pending':
                        $class = 'bg-warning';
                        break;
                    case 'declined':
                        $class = 'bg-danger';
                        break;
                    case 'charged':
                        $class = 'bg-success';
                        break;
                }
                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $paymentInformation = $data->QuotationProduct->QouteComparison()->latest()->first()->PaymentInformation;
                $viewButton = '<a href="/cancellation/get-for-rewrite-product-lead-view/'.$data->id.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $bindButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light bindButton" id="'.$leadId.'"><i class="ri-link"></i></button>';
                $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->quotation_product_id.'"><i class=" ri-task-line"></i></button>';
                $resendButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light resendButton" id="'.$paymentInformation->id.'" data-policy-id="'.$data->id.'"><i class="  ri-repeat-2-line"></i></button>';
                if($paymentInformation->status == 'charged'){
                    return $viewButton . ' ' . $viewNotedButton . ' '. $processButton;
                }elseif($paymentInformation->status == 'declined'){
                    return $viewButton . ' ' . $viewNotedButton . ' '. $resendButton;
                }else{
                    return $viewButton . ' ' . $viewNotedButton;
                }
            })
            ->rawColumns(['action', 'policy_status'])
            ->make(true);
    }
}