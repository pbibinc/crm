<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancellationEndorsement;
use App\Models\CancelledPolicyForRecall;
use App\Models\PolicyDetail;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelledPolicyController extends Controller
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
        $userProfileList = $userProfile->get();
        return view('customer-service.cancellation.cancelled-list.index', ['userProfileList' => $userProfileList]);

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

    public function cancelledPolicyList()
    {

    }

    public function getPolicyApprovedForCancellation(Request $request)
    {
        $policy = PolicyDetail::find($request->id);
        $cancellationEndorsement = $policy->cancellationEndorsement;
        $lead = $policy->QuotationProduct->QuoteInformation->QuoteLead->leads;
        $generalInformation = $lead->GeneralInformation;
        $effectiveDate = Carbon::parse($policy->effective_date);
        $expirationDate = Carbon::parse($policy->expiration_date);
        $paymentTerm = $effectiveDate->format('M-d-y') . ' to ' . $expirationDate->format('M-d-y');
        $media = $cancellationEndorsement->Medias;
        return response()->json(['status' => 'success', 'policy' => $policy, 'cancellationEndorsement' => $cancellationEndorsement, 'lead' => $lead, 'generalInformation' => $generalInformation, 'paymentTerm' => $paymentTerm, 'media' => $media], 200);
    }

    public function saveCancelledPolicy(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $policy = PolicyDetail::find($data['policyId']);
            $policy->status = 'Cancelled';
            $policy->save();

            $cancellationEndorsement = CancellationEndorsement::find($data['cancellationEndorsementId']);
            $cancellationEndorsement->agent_remarks = $data['cancellationPolicyRemarks'];
            $cancellationEndorsement->cancellation_date = $data['cancelaPolicyCancellationDate'];
            $cancellationEndorsement->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Policy has been successfully cancelled.']);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function getCancelledPolicy(Request $request)
    {
        if($request->ajax())
        {
            $policyDetail = new PolicyDetail();
            $data = $policyDetail->getCancelledPolicyList();
            return DataTables($data)
            ->addIndexColumn()
            ->addColumn('product', function($data){
                return $data->QuotationProduct->product;
            })
            ->addColumn('company_name', function($data){
                $company_name = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $company_name;
            })
            ->addColumn('cancellation_type', function($data){
                $cancellationEndorsement = $data->cancellationEndorsement;
                return $cancellationEndorsement ? $cancellationEndorsement->type_of_cancellation : ' ';
            })
            ->addColumn('cancelled_date', function($data){
                return Carbon::parse($data->cancellationEndorsement->cancellation_date)->format('M-d-Y');
            })
            ->addColumn('cancelled_by', function($data){
                $userProfile = $data->cancellationEndorsement->UserProfile;
                return $userProfile ? $userProfile->fullAmericanName() : '';
            })
            ->addColumn('action', function($data){
                $leadId = $data->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
                $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
                $forRewriteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light forRewriteButton" id="'.$data->id.'" data-cancel-id="'.$data->id.'"><i class="mdi mdi-account-arrow-left-outline"></i></button>';
                $previewButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light previewButton" id="'.$data->id.'"><i class="mdi mdi-book-information-variant"></i></button>';
                $setButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light firstTouchButtonSetCall" id="'.$data->id.'"><i class="mdi mdi-clock-start"></i></button>';
                return $viewButton . ' ' . $previewButton . ' ' . $forRewriteButton . ' ' . $setButton;
            })
            ->make(true);
        }
    }

    public function firstTouchCancelledPolicy(Request $request)
    {
        $cancelledPolicyForRecall = new CancelledPolicyForRecall();
        $data = $cancelledPolicyForRecall->PolicyForRecallFirstTouched();
        return DataTables($data)
        ->addIndexColumn()
        ->addColumn('product', function($data){
            return $data->PolicyDetail->QuotationProduct->product;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('policy_number', function($data){
            $policyDetail = $data->PolicyDetail;
            return $policyDetail ? $policyDetail->policy_number : ' ';
        })
        ->addColumn('last_touch_by', function($data){
            $userProfile = $data->UserProfile;
            return $userProfile ? $userProfile->fullAmericanName() : '';
        })
        ->addColumn('cancelled_date', function($data){
            $cancellationEndorsement = $data->PolicyDetail->cancellationEndorsement;
            return $cancellationEndorsement ? Carbon::parse($cancellationEndorsement->cancellation_date)->format('M-d-Y') : ' ';
        })
        ->addColumn('action', function($data){
            $leadId = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;

            $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->policy_details_id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
            $forRewriteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light forRewriteButton" data-cancel-id="'.$data->id.'" id="'.$data->policy_details_id.'"><i class="mdi mdi-account-arrow-left-outline"></i></button>';

            $previewButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light previewButton" id="'.$data->policy_details_id.'"><i class="mdi mdi-book-information-variant"></i></button>';
            $setButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light secondTouchButtonSetCall"  id="'.$data->policy_details_id.'"><i class="mdi mdi-clock-start"></i></button>';
            $removeForRecallButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light removeForRecallButton" id="'.$data->id.'"><i class="mdi mdi-clock-start"></i></button>';
            return $viewButton . ' ' . $previewButton . ' ' . $forRewriteButton . ' ' . $removeForRecallButton .  ' ' . $setButton;
        })
        ->make(true);
    }

    public function secondTouchCancelledPolicy(Request $request)
    {
        $cancelledPolicyForRecall = new CancelledPolicyForRecall();
        $data = $cancelledPolicyForRecall->PolicyForRecallSecondTouched();
        return DataTables($data)
        ->addIndexColumn()
        ->addColumn('product', function($data){
            return $data->PolicyDetail->QuotationProduct->product;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('policy_number', function($data){
            $policyDetail = $data->PolicyDetail;
            return $policyDetail ? $policyDetail->policy_number : ' ';
        })
        ->addColumn('last_touch_by', function($data){
            $userProfile = $data->UserProfile;
            return $userProfile ? $userProfile->fullAmericanName() : '';
        })
        ->addColumn('cancelled_date', function($data){
            $cancellationEndorsement = $data->PolicyDetail->cancellationEndorsement;
            return $cancellationEndorsement ? Carbon::parse($cancellationEndorsement->cancellation_date)->format('M-d-Y') : ' ';
        })
        ->addColumn('action', function($data){
            $leadId = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->policy_details_id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
            $forRewriteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light forRewriteButton" id="'.$data->policy_details_id.'" data-cancel-id="'.$data->id.'><i class="mdi mdi-account-arrow-left-outline"></i></button>';
            $previewButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light previewButton" id="'.$data->policy_details_id.'"><i class="mdi mdi-book-information-variant"></i></button>';
            $setButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light thirdTouchButtonSetCall" id="'.$data->policy_details_id.'"><i class="mdi mdi-clock-start"></i></button>';
            $removeForRecallButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light removeForRecallButton" id="'.$data->id.'"><i class="mdi mdi-clock-start"></i></button>';
            return $viewButton . ' ' . $previewButton . ' ' . $forRewriteButton . ' ' . $removeForRecallButton .  ' ' . $setButton;
        })
        ->make(true);
    }

    public function getTouchedPolicies(Request $request)
    {
        $cancelledPolicyForRecall = new CancelledPolicyForRecall();
        $data = $cancelledPolicyForRecall->TouchedPolicy();
        return DataTables($data)
        ->addIndexColumn()
        ->addColumn('product', function($data){
            return $data->PolicyDetail->QuotationProduct->product;
        })
        ->addColumn('company_name', function($data){
            $company_name = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
            return $company_name;
        })
        ->addColumn('policy_number', function($data){
            $policyDetail = $data->PolicyDetail;
            return $policyDetail ? $policyDetail->policy_number : ' ';
        })
        ->addColumn('last_touch_by', function($data){
            $userProfile = $data->UserProfile;
            return $userProfile ? $userProfile->fullAmericanName() : '';
        })
        ->addColumn('cancelled_date', function($data){
            $cancellationEndorsement = $data->PolicyDetail->cancellationEndorsement;
            return $cancellationEndorsement ? Carbon::parse($cancellationEndorsement->cancellation_date)->format('M-d-Y') : ' ';
        })
        ->addColumn('action', function($data){
            $leadId = $data->PolicyDetail->QuotationProduct->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<a href="/appointed-list/'.$leadId.'" data-toggle="tooltip" data-id="'.$data->policy_details_id.'" data-original-title="View" class="view btn btn-primary btn-sm viewCancellation"><i class="ri-eye-line"></i></a>';
            $forRewriteButton = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light forRewriteButton" id="'.$data->policy_details_id.'" data-cancel-id="'.$data->id.'><i class="mdi mdi-account-arrow-left-outline"></i></button>';
            $previewButton = '<button type="button" class="btn btn-info btn-sm waves-effect waves-light previewButton" id="'.$data->policy_details_id.'"><i class="mdi mdi-book-information-variant"></i></button>';
            $setButton = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light touchedButtonSetCall" id="'.$data->policy_details_id.'"><i class="mdi mdi-clock-start"></i></button>';
            $removeForRecallButton = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light removeForRecallButton" id="'.$data->id.'"><i class="mdi mdi-clock-start"></i></button>';
            return $viewButton . ' ' . $previewButton . ' ' . $forRewriteButton . ' ' . $removeForRecallButton .  ' ' . $setButton;
        })
        ->make(true);
    }
}
