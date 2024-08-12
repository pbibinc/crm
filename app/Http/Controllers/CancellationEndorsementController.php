<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancellationEndorsement;
use App\Models\Metadata;
use App\Models\PolicyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CancellationEndorsementController extends Controller
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
            $userProfileId = auth()->user()->userProfile->id;
            $data = $request->all();
            $file = $request->file('file');
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/cancellationEndorsement');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/cancellationEndorsement' . '/'. $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

            $cancellationEndorsement = new CancellationEndorsement();
            $cancellationEndorsement->policy_details_id = $data['poliydetailId'];
            $cancellationEndorsement->type_of_cancellation = $data['typeOfCancellation'];
            $cancellationEndorsement->media_id = $metadata->id;
            $cancellationEndorsement->cancelled_by_id = $userProfileId;
            $cancellationEndorsement->agent_remarks = $data['cancellationDescription'];
            $cancellationEndorsement->cancellation_date = $data['cancellationDate'];
            $cancellationEndorsement->save();

            $policyDetail = PolicyDetail::find($data['poliydetailId']);
            $policyDetail->status = 'Request For Cancellation Pending';
            $policyDetail->save();

            DB::commit();
            return response()->json(['success' => 'Cancellation Endorsement has been successfully created'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
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
        try{
            DB::beginTransaction();

            $data = $request->all();
            $cancellationEndorsement = CancellationEndorsement::find($id);
            if($request->hasFile('file')){

             $file = $request->file('file');
             $basename = $file->getClientOriginalName();
             $directoryPath = public_path('backend/assets/attacedFiles/cancellationEndorsement');
             $type = $file->getClientMimeType();
             $size = $file->getSize();
             if(!File::isDirectory($directoryPath)){
                 File::makeDirectory($directoryPath, 0777, true, true);
             }
             $file->move($directoryPath, $basename);
             $filepath = 'backend/assets/attacedFiles/cancellationEndorsement' . '/'. $basename;

             $metadata = new Metadata();
             $metadata->basename = $basename;
             $metadata->filename = $basename;
             $metadata->filepath = $filepath;
             $metadata->type = $type;
             $metadata->size = $size;
             $metadata->save();

             $cancellationEndorsement->media_id = $metadata->id;
            }
            $cancellationEndorsement->type_of_cancellation = $data['typeOfCancellation'];
            $cancellationEndorsement->agent_remarks = $data['cancellationDescription'];
            $cancellationEndorsement->cancellation_date = $data['cancellationDate'];
            $cancellationEndorsement->save();

            DB::commit();
            return response()->json(['success' => 'Cancellation Endorsement has been successfully updated'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e);
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
}
