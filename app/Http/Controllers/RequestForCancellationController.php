<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RequestForCancellationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-service.cancellation.request-for-cancellation.index');
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

    public function pendingCancellation(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getPendingForCancellation();
            return DataTables($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                $product =  $data->QuotationProduct->product;
                return $product ? $product : '';
            })
            ->addColumn('company_name', function($data){
                $companyName = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $companyName ? $companyName : '';
            })
            ->addColumn('requested_by', function($data){
                $userProfile = $data->CancellationEndorsement->UserProfile;
                return $userProfile ? $userProfile->fullName() : 'N/A';
            })
            ->addColumn('cancellation_type', function($data){
                $cancellationEndorsement = $data->CancellationEndorsement;
                return $cancellationEndorsement ? $cancellationEndorsement->type_of_cancellation : '';
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
            ->addColumn('requested_date', function($data){
                $cancellationEndorsement = $data->CancellationEndorsement;
                return $cancellationEndorsement ? $cancellationEndorsement->created_at->format('M-d-Y') : '';
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $requestForApprovalButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light requestForApproval" id="'.$data->id.'"><i class="mdi mdi-book-information-variant"></i></button>';
                return $viewButton . ' ' . $requestForApprovalButton;
            })
            ->rawColumns(['action', 'request_status'])
            ->make(true);
        }
    }
}