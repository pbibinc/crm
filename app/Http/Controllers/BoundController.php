<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoundInformation;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\PolicyDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BoundController extends Controller
{
    //
    public function index(Request $request)
    {
        $policyDetail = new PolicyDetail();
        $policyDetailData = $policyDetail->get();
        if($request->ajax())
        {
           return DataTables::of($policyDetailData)
           ->addColumn('product', function($policyDetailData){
               $product = $policyDetailData->QuotationProduct->product;
               return $product ? $product : '';
           })
           ->addColumn('bind_status', function($policyDetailData){
                $status = GeneralLiabilitiesPolicyDetails::where('policy_details_id', $policyDetailData->id)->first()->status;
                return $status ? $status : '';
            })
           ->addColumn('company_name', function($policyDetailData){
               $companyName = $policyDetailData->QuotationProduct->QuoteInformation->QuoteLead->leads->company_name;
               return $companyName ? $companyName : '';
           })
           ->addColumn('effective_date', function($policyDetailData){
            $effectiveDate = GeneralLiabilitiesPolicyDetails::where('policy_details_id', $policyDetailData->id)->first()->effective_date;
            return $effectiveDate ? Carbon::createFromFormat('Y-m-d', $effectiveDate)->format('F d Y') : '';
           })
           ->addColumn('action', function($policyDetailData){
            $profileViewRoute = route('appointed-list-profile-view', [$policyDetailData->QuotationProduct->QuoteInformation->QuoteLead->leads->id]);
            $viewButton = '<a href="'.$profileViewRoute.'" class="btn btn-success btn-sm" id="viewButton" name="viewButton"><i class="ri-eye-line"></i></a>';
            return $viewButton;
           })
           ->make(true);
        }
        return view('customer-service.policy.index');
    }

    public function saveBoundInformation(Request $request)
    {
        try{
            DB::beginTransaction();
            $userProfileId = Auth::user()->userProfile->id;
            $boundInformation = new BoundInformation();
            $boundInformation->quoatation_product_id  = $request->id;
            $boundInformation->user_profile_id = $userProfileId;
            $boundInformation->bound_date = now()->format('Y-m-d');
            $boundInformation->save();
            DB::commit();
            return response()->json(['message' => 'Bound Information has been saved.'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}