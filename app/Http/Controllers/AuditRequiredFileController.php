<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditInformation;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AuditRequiredFileController extends Controller
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
            $data = $request->all();

            $file = $data['file'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/audit_required_files');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath =  'backend/assets/attacedFiles/audit_required_files' . '/' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $auditInformation = AuditInformation::find($data['hidden_id']);
            $auditInformation->requiredFiles()->attach($mediaId);

            DB::commit();
            return response()->json(['message' => 'File uploaded successfully'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            DB::rollBack();
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
            $auditInformation = AuditInformation::find($id);
            $requiredFiles = $auditInformation->requiredFiles;
            return response()->json(['data' => $requiredFiles], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
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
}