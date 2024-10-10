<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\BrokerQuotation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrokerForFollowUpController extends Controller
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
        return view('broker-assistant-for-follow-up.index', compact('complianceOfficer'));
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

    public function getWarmProduct(Request $request)
    {
        $today = Carbon::now();
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $date30DaysAgo = $today->copy()->subDays(30)->toDateString();
        $date60DaysAgo = $today->copy()->subDays(60)->toDateString();
        $data = $quotationProduct->getAssigQuotedLeadByDate($userProfileId, 4, $date60DaysAgo, $date30DaysAgo);
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

    public function getOldProduct(Request $request)
    {
        $today = Carbon::now();
        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;
        $over90DaysAgo = $today->copy()->subDays(90)->toDateString();
        $data = $quotationProduct->getAssigQuotedLeadByDate($userProfileId, 4, null, $over90DaysAgo);
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
            $callBack = $data->QuotationProductCallback->date_time ?? null;
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

}
