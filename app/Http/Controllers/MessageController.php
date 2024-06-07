<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\QuotationProduct;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $lead = QuotationProduct::find($request['productId'])->QuoteInformation->QuoteLead->leads;
            if(is_array($request['dateTime'])){
                foreach($request['dateTime'] as $dateTime){
                    $message = new Messages();
                    $message->quotation_product_id = $request['productId'];
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
                $message->quotation_product_id = $request['productId'];
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
        $messages = new Messages();
        $data = $messages->getMessageByLeadId($request['id']);
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('product', function($data){
            $quotationProduct = QuotationProduct::find($data->quotation_product_id);
            return $quotationProduct->product;
        })
        ->make(true);
    }
}