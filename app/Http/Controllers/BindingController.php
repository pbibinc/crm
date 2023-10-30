<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
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
            ->addColumn('action', function($confirmedProduct){
                $viewButton = '<a href="" class="btn btn-sm btn-primary viewBindingButton"><i class="ri-eye-line"></i></a>';
                $bindButton = '<a href="" class="btn btn-sm btn-success bindButton"><i class="ri-share-box-line"></i></a>';
                return $bindButton  . ' ' .  $viewButton;
            })
            ->make(true);
        }
        return view('customer-service.binding.index');
    }
}
