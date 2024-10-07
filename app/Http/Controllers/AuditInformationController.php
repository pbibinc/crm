<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditInformation;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Database\DVar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AuditInformationController extends Controller
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
        //
        try{
            DB::beginTransaction();
            $data = $request->all();
            $userProfileId = auth()->user()->userProfile->id;

            $file = $data['file'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath =  'backend/assets/attacedFiles/policy' . '/' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;



            $auditInformation = new AuditInformation();
            $auditInformation->policy_details_id = $data['hiddenPolicyId'];
            $auditInformation->audit_letter_id = $mediaId;
            $auditInformation->processed_by = $userProfileId;
            $auditInformation->status = $data['auditInformationStatus'];
            $auditInformation->save();


            DB::commit();
            return response()->json([
                'message' => 'Audit information saved successfully',
                'data' => $auditInformation
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'An error occurred while saving the audit information',
                'error' => $e->getMessage()
            ], 500);
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
            return response()->json([
                'message' => 'Audit information retrieved successfully',
                'data' => $auditInformation
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'An error occurred while retrieving the audit information',
                'error' => $e->getMessage()
            ], 500);
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
            $data = $request->all();
            $auditInformation = AuditInformation::find($id);
            $auditInformation->status = $data['auditInformationStatus'];
            $auditInformation->save();
            DB::commit();
            return response()->json([
                'message' => 'Audit information updated successfully',
                'data' => $auditInformation
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while updating the audit information',
                'error' => $e->getMessage()
            ], 500);
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
        try{
            DB::beginTransaction();
            $auditInformation = AuditInformation::find($id);
            $auditInformation->delete();
            DB::commit();
            return response()->json([
                'message' => 'Audit information deleted successfully'
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the audit information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAuditInformationTable(Request $request)
    {
        $auditInformation = new AuditInformation();
        $data = $auditInformation->getAuditInformationByLeadId($request->leadId);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('policy_number', function($data){
                $policyDetail = $data->policyDetail;
                return $policyDetail ? $policyDetail->policy_number : '';
            })
            ->addColumn('product', function($data){
                $product = $data->policyDetail->QuotationProduct;
                return $product ? $product->product : '';
            })
            ->addColumn('audit_letter_file', function($data){
                $baseUrl = url('/');
                $media = $data->media;
                if ($media) {
                    $fullPath = $baseUrl . '/' . $media->filepath;
                    return '<a href="'.$fullPath.'" target="_blank">'.$media->basename.'</a>';
                }
                return '';
            })
            ->addColumn('processed_by_fullname', function($data){
                $userProfile = $data->UserProfile;
                return $userProfile ? $userProfile->fullAmericanName() : '';
            })
            ->addColumn('action', function($data){
                $dropdown = '
                <div class="dropdown" style="display: inline-block;">
                    <button class="btn btn-sm dropdown-toggle" type="button" id="actionMenu' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; color: white; border: none; padding: 5px; font-size: 16px; line-height: 1; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                        &#x2022;&#x2022;&#x2022;
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionMenu' . $data->id . '" style="min-width: 100px;">
                        <li><a class="dropdown-item uploadAuditInformationFile text-success" href="#" id="' . $data->id . '"><i class="ri-upload-2-line"></i> Upload Required File</a></li>
                        <li><a class="dropdown-item deleteAuditInformation text-warning" href="#" id="' . $data->id . '"><i class="ri-delete-bin-line"></i> Delete</a></li>
                    </ul>
                </div>';
                $editButton = '<button class="btn btn-info btn-sm editAuditInformation" id="'.$data->id.'" style="width: 30px; height: 30px; border-radius: 50%; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="ri-pencil-line"></i></button>';
                $uoloadFileButton = '<button class="btn btn-info btn-sm uploadAuditInformationFile" id="'.$data->id.'"><i class="ri-upload-2-line"></i></button>';
                // $deleteButton = '<button class="btn btn-danger btn-sm deleteAuditInformation" id="'.$data->id.'"><i class="ri-delete-bin-line"></i></button>';
                return $editButton . ' ' . $dropdown;
            })
            ->rawColumns(['audit_letter_file', 'action'])
            ->make(true);
    }

}