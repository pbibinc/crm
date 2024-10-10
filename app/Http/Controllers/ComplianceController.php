<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\BrokerQuotation;
use App\Models\QuotationProduct;
use PhpParser\Node\Stmt\Switch_;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leads.broker-assistant.index');
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
        $brokerQuotation = new BrokerQuotation();
        $userId = auth()->user()->id;
        $userProfileId = UserProfile::where('user_id' , $userId)->first()->id;
        $data = $brokerQuotation->getAgentProductByBrokerUserprofileId($userProfileId, [22, 3]);
        // $data = QuotationProduct::where('status', 22)->orderBy('updated_at', 'desc')->get();
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
        ->addColumn('brokerStatus', function($data){
            $statusLabel = '';
            $class = '';
            Switch ($data->status) {
                case 22:
                    $statusLabel = 'Pending';
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
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where(
                'quote_product_id', $data->id
            )->first();
            $userProfile = UserProfile::find($broker->user_profile_id)->fullAmericanName();
            return $userProfile ? $userProfile : 'UNKNOWN';
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'" data-lead-id="'.$leadId.'"><i class=" ri-task-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            if($data->status == 3){
                return $viewButton . ' ' . $viewNotedButton;
            }else{
                return $viewButton . ' ' . $processButton . ' ' . $viewNotedButton;
            }
        })
        ->rawColumns(['action', 'brokerStatus', 'companyName'])
        ->make(true);
    }

    public function getCompliedBrokerProduct(Request $request)
    {
        $brokerQuotation = new BrokerQuotation();
        $userId = auth()->user()->id;
        $userProfileId = UserProfile::where('user_id' , $userId)->first()->id;
        $data = $brokerQuotation->getAgentProductByBrokerUserprofileId($userProfileId, 4);
        // $data = QuotationProduct::where('status', 3)->orderBy('updated_at', 'desc')->get();
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
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where(
                'quote_product_id', $data->id
            )->first();
            $userProfile = UserProfile::find($broker->user_profile_id)->fullAmericanName();
            return $userProfile ? $userProfile : 'UNKNOWN';
        })
        ->addColumn('callback', function($data){
            $callBack = $data->QuotationProductCallback->date_time ?? null;
            return $callBack ? Carbon::parse($callBack)->format('M d, Y g:i A') : 'N/A';
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            return $viewButton . ' ' . $viewNotedButton;
        })
        ->rawColumns(['action', 'companyName'])
        ->make(true);
    }

    public function getMakePaymentList(Request $request)
    {
        $brokerQuotation = new BrokerQuotation();
        $userId = auth()->user()->id;
        $userProfileId = UserProfile::where('user_id' , $userId)->first()->id;
        $data = $brokerQuotation->getAgentProductByBrokerUserprofileId($userProfileId, [9, 10]);
        // $data = QuotationProduct::whereIn('status', [9, 10])->orderBy('updated_at', 'desc')->get();
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
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where(
                'quote_product_id', $data->id
            )->first();
            $userProfile = UserProfile::find($broker->user_profile_id)->fullAmericanName();
            return $userProfile ? $userProfile : 'UNKNOWN';
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
                   $statusLabel = $data->status;
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            return $viewButton . ' ' . $viewNotedButton;
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }

    public function getBindingList(Request $request)
    {
        $brokerQuotation = new BrokerQuotation();
        $userId = auth()->user()->id;
        $userProfileId = UserProfile::where('user_id' , $userId)->first()->id;
        $data = $brokerQuotation->getAgentProductByBrokerUserprofileId($userProfileId, [6, 11, 12, 14, 15]);
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
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where(
                'quote_product_id', $data->id
            )->first();
            $userProfile = UserProfile::find($broker->user_profile_id)->fullAmericanName();
            return $userProfile ? $userProfile : 'UNKNOWN';
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
                    $class = 'bg-success';
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
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            return $viewButton . ' ' . $viewNotedButton;
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }

    public function getHandledList(Request $request)
    {
        $brokerQuotation = new BrokerQuotation();
        $userId = auth()->user()->id;
        $userProfileId = UserProfile::where('user_id' , $userId)->first()->id;
        $data = $brokerQuotation->getAgentProductByBrokerUserprofileId($userProfileId, 8);
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
        ->addColumn('broker', function($data){
            $broker = BrokerQuotation::where(
                'quote_product_id', $data->id
            )->first();
            $userProfile = UserProfile::find($broker->user_profile_id)->fullAmericanName();
            return $userProfile ? $userProfile : 'UNKNOWN';
        })
        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            $viewNotedButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            return $viewButton . ' ' . $viewNotedButton;
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }
}
