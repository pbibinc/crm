<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\RecoverCancelledPolicy;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RewritePolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userProfile = new UserProfile();
        $complianceOfficer = $userProfile->complianceOfficer();
        return view('customer-service.cancellation.rewrite-policy.index', compact('complianceOfficer'));
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


    public function changeStatusPolicy(Request $request)
    {
        $policyDetail = PolicyDetail::find($request->id);
        $policyDetail->status = $request->status;
        $policyDetail->save();
        return response()->json(['success' => 'Status has been changed successfully']);
    }

    //subjeect for rewrite table
    public function getSubjectForRewriteList(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getSubjectForRewriteList();
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
            ->addColumn('cancelled_date', function($data){
                $cancellationEndorsement = $data->CancellationEndorsement;
                return $cancellationEndorsement ? $cancellationEndorsement->cancellation_date->format('M-d-Y') : '';
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';

                return $viewButton;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getForRewritePolicy(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $userProfileId = auth()->user()->userProfile->id;
        $data = $policyDetail->getForRewritePolicyByStatusAndUserProfileId('For Rewrite', $userProfileId);
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
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                $sendForQuotationButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light sendForQuotationButton" id="'.$data->id.'"><i class=" ri-clipboard-line"></i></button>';
                return $viewButton . ' ' . $viewNotedButton . ' ' . $sendForQuotationButton;
            })
            ->make(true);

    }

    public function handledPolicy(Request $request)
    {
        $recoverCancelledPolicy = new RecoverCancelledPolicy();
        $userProfileId = auth()->user()->userProfile->id;
        $data = $recoverCancelledPolicy->getRecoverCancelledPolicyByUserProfileId($userProfileId);
        return DataTables($data)
        ->addIndexColumn()
        ->addColumn('policy_number', function($data){
            $policyDetail =  $data->policyDetail;
            return $policyDetail ? $policyDetail->policy_number : '';
        })
        ->addColumn('product', function($data){
            return $data->policyDetail->QuotationProduct->product;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->policyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('formatted_bound_date', function($data){
            if (is_string($data->bound_date)) {
                // Convert the string to a Carbon instance
                $date = Carbon::parse($data->bound_date);
            } else {
                // If it's already a Carbon instance or DateTime object, use it directly
                $date = $data->bound_date;
            }
            return $date->format('M-d-Y');
        })
        ->addColumn('action', function($data){
            $leadId = $data->policyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
            return $viewButton;
        })
        ->make(true);
    }

}
