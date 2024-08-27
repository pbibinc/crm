<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CancellationReport;
use App\Models\FinancingAgreement;
use App\Models\FinancingCompany;
use App\Models\UserProfile;
use Carbon\Carbon;

class CancellationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-service.cancellation.index');
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

    public function getRequestForApprovalData(Request $request)
    {
        $data = PolicyDetail::find($request->id);
        $cancellationReport = CancellationReport::where('policy_details_id', $request->id)->orderBy('created_at', 'desc')->first();
        $lead = $data->QuotationProduct->QuoteInformation->QuoteLead->leads;
        $product = $data->QuotationProduct;
        $generalInformation = $lead->GeneralInformation;
        $effectiveDate = Carbon::parse($data->effective_date);
        $expirationDate = Carbon::parse($data->expiration_date);
        $cancellationEndorsement = $data->CancellationEndorsement ? $data->CancellationEndorsement : null;
        $description = $cancellationEndorsement ? $cancellationEndorsement->agent_remarks : null;
        if($cancellationEndorsement){
            $cancellationEndorsementMedia = $cancellationEndorsement->Medias;

        }else{
            $cancellationEndorsementMedia = null;
        }


          // Format the dates as needed
        $paymentTerm = $effectiveDate->format('M-d-y') . ' to ' . $expirationDate->format('M-d-y');
        return response()->json(['status' => 'success', 'data' => $data, 'lead' => $lead, 'product' => $product, 'generalInformation' => $generalInformation, 'paymentTerm' => $paymentTerm,'cancellationReport' => $cancellationReport, 'cancellationEndorsement' => $cancellationEndorsement, 'cancellationEndorsementMedia' => $cancellationEndorsementMedia, 'description' => $description]);
    }

    public function getRequestByCustomerCancellationList(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getRequestedByCustomerCancellationPolicyList();
            return DataTables($data)
            ->addIndexColumn()
            ->addColumn('quote_number', function($data){
                $quoteNo = $data->policy_number;
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads_id;
                return $quoteNo;
            })
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads_id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                $requestForApprovalButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light requestForApproval" id="'.$data->id.'"><i class="mdi mdi-book-information-variant"></i></button>';
                return $viewButton . ' ' . $requestForApprovalButton. ' ' . $cancelButton;
            })
            ->rawColumns(['quote_number', 'action'])
            ->make(true);
        }
    }

    public function getRequestForCancellationList(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getRequestForCancellation();
            return DataTables($data)
            ->addIndexColumn()
            ->addColumn('quote_number', function($data){
                $quoteNo = $data->policy_number;
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads_id;
                return $quoteNo;
            })
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('request_status', function($data){
                $policyStatus = $data->status;
                $statusLabel = $policyStatus;;
                $class = 'bg-secondary';
                switch ($policyStatus) {
                    case 'Request For Cancellation Approved':
                        $class = 'bg-success';
                        break;

                    case 'Request For Cancellation Declined':
                        $class = 'bg-danger';
                        break;

                    case 'Request For Cancellation Pending':
                    case 'Request For Cancellation Resend':
                        $class = 'bg-warning';
                        break;

                    case 'old policy':
                        $class = 'bg-secondary';
                        break;
                }

                return "<span class='badge {$class}'>$statusLabel</span>";
            })
            ->addColumn('cancellation_type', function($data){
                $cancellationEndorsement = $data->CancellationEndorsement;
                return $cancellationEndorsement ? $cancellationEndorsement->type_of_cancellation : '';
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads_id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $cancelButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelButton" id="'.$data->id.'"><i class="mdi mdi-book-cancel-outline"></i></button>';
                $viewInformationButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light viewInformation" id="'.$data->id.'"><i class="mdi mdi-book-information-variant"></i></button>';
                $requestForApprovalButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light requestForApprovalEdit" id="'.$data->id.'"><i class="mdi mdi-book-information-variant"></i></button>';
                $cancelPolicyButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light cancelPolicyButton" id="'.$data->id.'"><i class="mdi mdi-cancel"></i></button>';
                if($data->status == 'Request For Cancellation Approved'){
                    return $viewButton . ' ' . $requestForApprovalButton. ' ' . $cancelButton . ' ' . $cancelPolicyButton;
                }else{
                    return $viewButton . ' ' . $requestForApprovalButton. ' ' . $cancelButton;
                }

            })
            ->rawColumns(['quote_number', 'request_status', 'action'])
            ->make(true);
        }
    }

}
