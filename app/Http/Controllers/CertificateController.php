<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\sendTemplatedEmail;
use App\Models\Certificate;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\Templates;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Switch_;
use Yajra\DataTables\Facades\DataTables;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-service.certificate.index');
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


    public function getRequestForCert(Request $request)
    {
        $certificate = Certificate::all()->sortBy('requested_date');
        return DataTables($certificate)
        ->addColumn('company_name', function($certificate){
            $lead = Lead::find($certificate->lead_id);
            return $lead ? $lead->company_name : ' ';
        })
        ->addColumn('formatted_requested_data', function($certificate){
            return Carbon::parse($certificate->requested_date)->format('M-d-Y');
        })
        ->addColumn('cert_status', function($certificate){
            $certStatus = $certificate->status;
            $statusLabel = ' ';
            Switch ($certStatus){
                case 'pending':
                    $statusLabel = 'pending';
                    $class = 'bg-warning';
                    break;
                case 'approved':
                    $statusLabel = 'approved';
                    $class = 'bg-success';
                    break;
                case 'declined':
                    $statusLabel = 'declined';
                    $class = 'bg-warning';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('action', function($certificate){
            if($certificate->status == 'pending'){
                $approvedButton = '<button class="btn btn-outline-success btn-sm waves-effect waves-light approvedButton" id='.$certificate->id.' ><i class=" ri-task-line"></i></button>';

                $declinedButoon = '<button class="btn btn-outline-danger btn-sm waves-effect waves-light declinedButton" id='.$certificate->id.' ><i class="ri-forbid-line"></i></button>';

                return $approvedButton . ' ' . $declinedButoon;
            }

        })
        ->rawColumns(['cert_status', 'action'])
        ->make(true);
    }

    public function approvedCert(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $certificate = Certificate::find($data['id']);
            $certificate->status = 'approved';

            $certificate->save();

            $metadata = Metadata::find($certificate->media_id);

            $template = Templates::find(15);
            $subject = 'Cert Request';
            $sendingMail = Mail::to('maechael108@gmail.com')->send(new sendTemplatedEmail($subject, $template->html,  $metadata->filepath));

            DB::commit();
            return response()->json(['success' => 'Certificate has been approved'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
