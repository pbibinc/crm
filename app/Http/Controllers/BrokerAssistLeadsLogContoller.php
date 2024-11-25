<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrokerQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrokerAssistLeadsLogContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('broker-assist-lead-logs.index');
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

    public function getBrokerAssistLeadsLog(Request $request)
    {

        $quotationProduct = new BrokerQuotation();
        $userProfileId = Auth::user()->userProfile->id;

        $data = $quotationProduct->getBrokerProductByUserProfileId($userProfileId, [31, 32, 33, 5]);
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
                case 31:
                    $statusLabel = 'Not Interested';

                    break;
                case 32:
                    $statusLabel = 'Voice Mail';

                    break;
                case 33:
                    $statusLabel = 'Potential';
                 ;
                    break;
                case 5:
                    $statusLabel = 'Declined/Close Business';

                    break;
                default:
                    $statusLabel = 'Unknown';

                    break;
            }
            return  $statusLabel;
        })

        ->addColumn('action', function($data){
            $leadId = $data->QuoteInformation->QuoteLead->leads->id;
            $viewButton = '<button class="edit btn btn-outline-info btn-sm viewButton" id="'.$data->id.'"><i class="ri-eye-line"></i></button>';
            $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
            $processButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light processButton" id="'.$data->id.'"><i class=" ri-task-line"></i></button>';
            $changeStatusButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light changeStatusButton" id="'.$data->id.'">Change Status</button>';

            $dropdown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-line"></i>
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item changeStatusButton" id="' . $data->id . '"><i class="ri-swap-line"></i>Change Status</button></li>
            </ul>

         </div>';
            return $viewButton . ' ' . $viewNoteButton . ' ' . $dropdown;
        })
        ->rawColumns(['action', 'status', 'companyName'])
        ->make(true);
    }
}