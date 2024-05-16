<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrokerAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('leads.broker_leads.index');
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

    public function getPendingProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, 21);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="companyPendingName" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyLink;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->rawColumns(['companyName'])
        ->make(true);
    }

    public function getComplianceProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, [22, 3]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="companyName" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyLink;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceStatus', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status) {
                case 22:
                    $statusLabel = 'Pending';
                    $class = 'bg-warning';
                    break;
                case 3:
                    $statusLabel = 'Complied';
                    $class = 'bg-success';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->rawColumns(['companyName', 'complianceStatus'])
        ->make(true);
    }

    public function getCompliedProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, 3);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="companyName" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(3)->fullAmericanName();
            return $complianceOfficerName ? $complianceOfficerName : 'UNKNOWN';
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="'.$data->id.'" ><i class="ri-eye-line"></i></button>';
            return $viewButton;
        })
        ->rawColumns(['companyName', 'action'])
        ->make(true);
    }

    public function getForFollowUpProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, 4);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="makePaymentLink" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(2)->fullAmericanName();
            return $complianceOfficerName ? $complianceOfficerName : 'UNKNOWN';
        })
        ->addColumn('status', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status) {
                case 9:
                    $statusLabel = 'Pending';
                    $class = 'bg-warning';
                    break;
                case 10:
                    $statusLabel = 'Paid';
                    $class = 'bg-success';
                    break;
                case 13:
                    $statusLabel = 'Declined';
                    $class = 'bg-danger';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('callBack', function($data){
            $callBack = $data->QuotationProductCallback->date_time;
            return $callBack ? $callBack : 'N/A';
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            return $viewButton;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function makePaymentList(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, [9, 10]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="makePaymentLink" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(2)->fullAmericanName();
            return $complianceOfficerName ? $complianceOfficerName : 'UNKNOWN';
        })
        ->addColumn('status', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status) {
                case 9:
                    $statusLabel = 'Pending';
                    $class = 'bg-warning';
                    break;
                case 10:
                    $statusLabel = 'Paid';
                    $class = 'bg-success';
                    break;
                case 13:
                    $statusLabel = 'Declined';
                    $class = 'bg-danger';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            if($data->status == 9){
                return $viewButton;
            }elseif($data->status == 10){
                return $viewButton . ' ' . $processButton;
            }
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function getRequestToBind(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, [6, 11, 12, 14, 15]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="makePaymentLink" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyName;
        })
        ->addColumn('quotedBy', function($data){
            $quoter = UserProfile::find($data->user_profile_id);
            return $quoter ? $quoter->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('appointedBy', function($data){
            $appointedBy = UserProfile::find($data->QuoteInformation->user_profile_id);
            return $appointedBy ? $appointedBy->fullAmericanName() : 'UNKNOWN';
        })
        ->addColumn('complianceOfficer', function($data){
            $complianceOfficerName = UserProfile::find(3)->fullAmericanName();
            return $complianceOfficerName ? $complianceOfficerName : 'UNKNOWN';
        })
        ->addColumn('status', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status) {
                case 6:
                    $statusLabel = 'Pending';
                    $class = 'bg-warning';
                    break;
                case 11:
                    $statusLabel = 'Bound';
                    $class = 'bg-success';
                    break;
                case 12:
                    $statusLabel = 'Binding';
                    $class = 'bg-warning';
                    break;
                case 14:
                    $statusLabel = 'Declined';
                    $class = 'bg-danger';
                    break;
                case 15:
                    $statusLabel = 'Resend';
                    $class = 'bg-warning';
                    break;
                default:
                    $class = 'bg-secondary';
                    $statusLabel = $data->status;
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            $resendBindButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light resendBindButton" id="'.$data->id.'"><i class="  ri-repeat-2-line"></i></button>';
            Switch($data->status){
                case 6:
                    return $viewButton;
                    break;
                case 11:
                    return $viewButton;
                    break;
                case 12:
                    return $viewButton;
                    break;
                case 14:
                    return $viewButton . ' ' . $viewNotedButton . ' ' . $resendBindButton;
                    break;
                case 15:
                    return $viewButton;
                    break;
                default:
                    return $viewButton;
                    break;
            }
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }
}