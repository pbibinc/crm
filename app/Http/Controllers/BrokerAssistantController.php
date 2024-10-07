<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\SelectedQuote;
use App\Models\BrokerQuotation;
use App\Models\QuoteComparison;
use App\Models\BoundInformation;
use App\Models\QuotationProduct;
use App\Models\PaymentInformation;
use App\Http\Controllers\Controller;
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
        $userProfile = new UserProfile();
        $complianceOfficer = $userProfile->complianceOfficer();
        return view('leads.broker_leads.index', compact('complianceOfficer'));
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
        $data = $quotationProduct->getAssignQoutedLead($userProfileId, [22, 3, 21]);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="viewButton" id="'.$data->id.'">'.$companyName.'</a>';
            return $data->status == 3 ? $companyLink : $companyName;
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
                case 21:
                    $statusLabel = 'Quoted Product';
                    $class = 'bg-warning';
                    break;
                case 3:
                    $statusLabel = 'Approved';
                    $class = 'bg-success';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($data){
            $viewButton = '<button class="btn btn-outline-info btn-sm viewButton" id="'.$data->id.'" ><i class="ri-eye-line"></i></button>';
            return $viewButton;
        })
        ->rawColumns(['companyName', 'complianceStatus', 'action'])
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
        $today = Carbon::now();
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $date30DaysAgo = $today->copy()->subDays(30);
        $data = $quotationProduct->getAssigQuotedLeadByDate($userProfileId, 4, $date30DaysAgo->toDateString());
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="viewButton" id="'.$data->id.'">'.$companyName.'</a>';
            return $companyLink;
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
            return $callBack ? Carbon::parse($callBack)->format('M d, Y g:i A') : 'N/A';
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            return $viewButton . ' ' . $viewNoteButton ;
        })
        ->rawColumns(['action', 'status', 'companyName'])
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
            $companyLink = '<a href="" class="viewButton" id="'.$data->id.'">'.$companyName.'</a>';
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
        // ->addColumn('complianceOfficer', function($data){
        //     $complianceOfficerName = UserProfile::find(2)->fullAmericanName();
        //     return $complianceOfficerName ? $complianceOfficerName : 'UNKNOWN';
        // })
        ->addColumn('status', function($data){
            $selectedQuote = SelectedQuote::find($data->selected_quote_id);
            $paymentInformation = PaymentInformation::where('selected_quote_id', $selectedQuote->id)->latest()->first();
            $paymentInformationStatus = $paymentInformation ? $paymentInformation->status : 'Unknown';
            // return $data->id;
            $statusLabel = '';
            $class = '';
            Switch ($paymentInformationStatus) {
                case 'pending':
                    $statusLabel ='Pending';
                    $class = 'bg-warning';
                    break;
                case 'charged':
                    $statusLabel = 'Paid';
                    $class = 'bg-success';
                    break;
                case 'declined':
                    $statusLabel = 'Declined';
                    $class = 'bg-danger';
                    break;
                case 'resend':
                    $statusLabel = 'Resend';
                    $class = 'bg-warning';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($data){
            $paymentInformation = PaymentInformation::where('selected_quote_id', $data->selected_quote_id)->latest()->first();
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $paymentInformationId = $paymentInformation ? $paymentInformation->id : 0;
            $paymentInformationStatus = $paymentInformation ? $paymentInformation->status : 'Unknown';
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $resendButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light resendButton" id="'.$paymentInformationId.'"><i class="  ri-repeat-2-line"></i></button>';
            $editButton = '<button class="btn btn-outline-primary btn-sm editButton" id="'.$paymentInformationId.'"><i class="ri-pencil-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            if($paymentInformationStatus == 'pending'){
                return $viewButton . ' ' . $viewNoteButton;
            }elseif($paymentInformationStatus == 'charged'){
                return $viewButton . ' ' . $processButton . ' ' . $viewNoteButton;
            }elseif(($paymentInformationStatus == 'declined') || ($paymentInformationStatus == 'resend')){

                return $viewButton. ' ' . $resendButton . ' ' . $viewNoteButton;
            }else{
                return $viewButton . ' ' . $viewNoteButton;
            }
        })
        ->rawColumns(['action', 'status', 'companyName'])
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
            $companyLink = '<a href="" class="viewButton" id="'.$data->id.'">'.$companyName.'</a>';
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
                    return $viewButton . ' ' . $viewNotedButton;
                    break;
                case 15:
                    return $viewButton;
                    break;
                default:
                    return $viewButton;
                    break;
            }
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }

    public function getRecentBoundProduct(Request $request)
    {
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $data = $quotationProduct->recentBoundInformation($userProfileId);

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('companyName', function($data){
            $companyName = $data->QuoteInformation->QuoteLead->leads->company_name;
            $companyLink = '<a href="" class="viewButton" id="'.$data->id.'">'.$companyName.'</a>';
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
        ->addColumn('boundDate', function($data){
            $bound = BoundInformation::where('quoatation_product_id', $data->id)->first('bound_date');
            return $bound ? $bound->bound_date : 'N/A';
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
                    return $viewButton . ' ' . $viewNotedButton;
                    break;
                case 15:
                    return $viewButton;
                    break;
                default:
                    return $viewButton;
                    break;
            }
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }
}