<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\QuotationProduct;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Switch_;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class QuotedController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getQuotedProduct(Request $request)
    {
        $quotationProduct = new QuotationProduct();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getQuotedProduct($userProfileId, [21, 22, 3, 9, 10]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="companyName" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName ? $companyName : 'UNKNOWN';
        })
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where('quote_product_id', $data->id)->first();
            $user = UserProfile::find($broker->user_profile_id);
            return $user ? $user->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(5);
            return $complianceOfficerName ? $complianceOfficerName->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="'.$data->id.'" ><i class="ri-eye-line"></i></button>';
            return $viewButton;
        })
        ->addColumn('statusColumn', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status){
                case 3:
                    $statusLabel = 'Complied';
                    $class = 'bg-success';
                    break;
                case 9:
                    $statusLabel = 'Pequest Payment';
                    $class = 'bg-warning';
                    break;
                case 10:
                    $statusLabel = 'Payment Approved';
                    $class = 'bg-success';
                    break;
                case 21:
                    $statusLabel = 'For Compliance';
                    $class = 'bg-warning';
                    break;
                case 22:
                    $statusLabel = 'Pending';
                    $class = 'bg-warning';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->rawColumns(['action', 'statusColumn', 'companyName'])
        ->make(true);
    }

    public function getBindingProduct(Request $request)
    {
        $quotationProduct = new QuotationProduct();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getQuotedProduct($userProfileId, [6, 12, 14, 15, 10]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="companyName" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName ? $companyName : 'UNKNOWN';
        })
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where('quote_product_id', $data->id)->first();
            $user = UserProfile::find($broker->user_profile_id);
            return $user ? $user->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(5);
            return $complianceOfficerName ? $complianceOfficerName->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="'.$data->id.'" ><i class="ri-eye-line"></i></button>';
            return $viewButton;
        })
        ->addColumn('statusColumn', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status){
                case 12:
                    $statusLabel = 'Binding';
                    $class = 'bg-warning';
                    break;
                case 14:
                    $statusLabel = 'Binding Declined';
                    $class = 'bg-danger';
                    break;
                case 15:
                    $statusLabel = 'Resent RTB';
                    $class = 'bg-warning';
                    break;
                case 6:
                    $statusLabel = 'Reques To Bind';
                    $class = 'bg-warning';
                    break;
                case 10:
                    $statusLabel = 'Boujnd';
                    $class = 'bg-success';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->rawColumns(['action', 'statusColumn'])
        ->make(true);

    }
}