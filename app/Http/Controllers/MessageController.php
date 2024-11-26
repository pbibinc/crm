<?php

namespace App\Http\Controllers;

use App\Events\HistoryLogsEvent;
use App\Http\Controllers\Controller;
use App\Mail\sendTemplatedEmail;
use App\Models\Lead;
use App\Models\Messages;
use App\Models\QuotationProduct;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
class MessageController extends Controller
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
        try{
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $userProfileId = UserProfile::where('user_id', $userId)->first()->id;
            $lead = Lead::find($request['leadId']);

            if(is_array($request['dateTime'])){
                foreach($request['dateTime'] as $dateTime){
                    $message = new Messages();
                    $message->lead_id = $lead->id;
                    $message->quotation_product_id = $request['productId'] ?? null;
                    $message->receiver_email = 'maechael108@gmail.com';
                    $message->name = $lead->GeneralInformation->customerFullName();
                    $message->type = $request['type'];
                    $message->template_id  = $request['templateId'];
                    $message->sending_date =$dateTime;
                    $message->sender_id = $userProfileId;
                    $message->status = 'pending';
                    $message->save();
                }
            }else{
                $message = new Messages();
                $message->lead_id = $lead->id;
                $message->quotation_product_id = $request['productId'] ?? null;
                $message->receiver_email = 'maechael108@gmail.com';
                $message->name = $lead->GeneralInformation->customerFullName();
                $message->type = $request['type'];
                $message->template_id  = $request['templateId'];
                $message->sending_date = $request['dateTime'];
                $message->sender_id = $userProfileId;
                $message->status = 'pending';
                $message->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Message Sent']);
        }catch(Exception $e){
            DB::rollBack();
            Log::info("message store error: ".$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        try{
            $message = Messages::find($id);
            return response()->json(['success' => true, 'message' => $message]);
        }catch(Exception $e){
            Log::info("message edit error: ".$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

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
        try{
            DB::beginTransaction();
            $message = Messages::find($id);
            $userProfileId = Auth::user()->userProfile->id;
            if($request['emailStatusDropdown'] == 'sent'){
                $templateSubjectName = $message->template->name;
                $message->status = 'sent';
                Mail::to($message->receiver_email)->send(new sendTemplatedEmail($templateSubjectName, $message->template->html));
                $message->sending_date = now();
                $message->sender_id = $userProfileId;
                event(new HistoryLogsEvent($message->lead_id, $userProfileId, 'Schedule Email', $templateSubjectName . ' ' . 'Email Sent'));

            }else{
                $message->sending_date = $request['dateTime'];
                $message->status = $request['emailStatusDropdown'];
            }
            $message->template_id = $request['templateId'];
            $message->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            Log::info("message update error: ".$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

    public function getMessages(Request $request)
    {
        $messages = Messages::where('quotation_product_id', $request['productId'])->get();
        return DataTables::of($messages)
        ->addIndexColumn()
        ->addColumn('product', function($messages){
            $quotationProduct = QuotationProduct::find($messages->quotation_product_id);
            return $quotationProduct->product;
        })
        ->make(true);
    }

    public function getClientEmails(Request $request)
    {
        $lead = Lead::find($request['id']);
        $messages = new Messages();
        $data = $lead->emailMessages();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('product', function($data){
            $quotationProduct = QuotationProduct::find($data->quotation_product_id);
            return $quotationProduct ? $quotationProduct->product : 'N/A';
        })
        ->addColumn('email_status', function($data){
            $status = $data->status;
            $statusLabel = '';
            $class = '';
            Switch ($status) {
                case 'pending':
                    $statusLabel ='pending';
                    $class = 'bg-warning';
                    break;
                case 'sent':
                    $statusLabel = 'sent';
                    $class = 'bg-success';
                    break;
                case 'declined':
                    $statusLabel = 'cancelled';
                    $class = 'bg-danger';
                    break;
                default:
                    $statusLabel = 'Unknown';
                    $class = 'bg-secondary';
                    break;
            }
            return "<span class='badge {$class}'>{$statusLabel}</span>";
        })
        ->addColumn('formatted_sent_out_date', function($data){
            return \Carbon\Carbon::parse($data->sending_date)->format('M-d-Y');
        })
        ->addColumn('action', function($data){
            $editButton = '<button type="button" id="'.$data->id.'" class="btn btn-info btn-sm waves-effect waves-light editScheduledEmail" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';
            return $editButton;
        })
        ->rawColumns(['email_status', 'action'])
        ->make(true);
    }
}
