<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BindingController extends Controller
{
    //

    public function index(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $confirmedProduct = $quotationProduct->getApprovedProduct($userProfileId);
        if($request->ajax())
        {
        return DataTables::of($confirmedProduct)
            ->addIndexColumn()
            ->addColumn('company_name', function($confirmedProduct){
                $lead = $confirmedProduct->QuoteInformation->QuoteLead->leads->company_name;
                return $lead;
            })
            ->addColumn('requestedBy', function($confirmedProduct) use ($quotationProduct){
                $brokerQuotation = $quotationProduct->where('quote_product_id', $confirmedProduct->id)->first();
                $userProfile = UserProfile::find($brokerQuotation->user_profile_id)->fullAmericanName();
                return $userProfile;
            })
            ->addColumn('action', function($confirmedProduct){
                $viewButton = '<button type="button" id="'.$confirmedProduct->id.'" data-product="'.$confirmedProduct->product.'" class="btn btn-sm btn-primary viewBindingButton"><i class="ri-eye-line"></i></button>';
                $bindButton = '<button type="button" id="'.$confirmedProduct->id.'"  data-product="'.$confirmedProduct->product.'" data-companyName = "'.$confirmedProduct->QuoteInformation->QuoteLead->leads->company_name.'" class="bindButton btn btn-sm btn-success" name="bindButton"><i class="ri-share-box-line"></i></button>';
                return $bindButton  . ' ' .  $viewButton;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('customer-service.binding.index');
    }
}