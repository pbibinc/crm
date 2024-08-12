<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BindingDocs;
use App\Models\Metadata;
use App\Models\QuotationProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
class BindingDocsController extends Controller
{
    //
    public function Index(Request $request)
    {
        if($request->ajax()){
            $bindingDocs = new BindingDocs();
            $medias =  $bindingDocs->getBindingLeadsId($request->id);

            return DataTables::of($medias)
            ->addIndexColumn()
            ->addColumn('date_attached', function($medias){
                $medias = $medias->created_at->format('M-d-Y H:i:s');
                return $medias;
            })
            ->addColumn('action', function($medias){
                $deleteButton = '<button type="button" id="'.$medias->id.'" data-productId="'.$medias->pivot->quotation_product_id.'" class="delete btn btn-outline-danger btn-sm" name="delete"><i class="ri-delete-bin-line"></i></button>';
                $uploadFileButton = '<button type="button" id="'.$medias->pivot->quotation_product_id.'"  class="btn btn-outline-success btn-sm bindDocsButtonUpload"><i class="ri-upload-2-line"></i></button>';
                return $uploadFileButton . ' ' . $deleteButton;
            })
            ->make(true);
        }
    }

    public function uploadFile(Request $request)
    {
        try{
            DB::beginTransaction();
            $bindingFiles = $request->file('bindingFile') ?: $request->file('file');

              // Ensure $bindingFiles is an array
            if (!is_array($bindingFiles)) {
              $bindingFiles = [$bindingFiles];
            }

            $quoteProductId = $request->hiddenId;
            $mediaIds = [];
            foreach($bindingFiles as $file){
                $basename = $file->getClientOriginalName();
                $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');
                $type = $file->getClientMimeType();
                $size = $file->getSize();
                if(!File::isDirectory($directoryPath)){
                    File::makeDirectory($directoryPath, 0777, true, true);
                }
                $file->move($directoryPath, $basename);
                $filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $basename;

                $metadata = new Metadata();
                $metadata->basename = $basename;
                $metadata->filename = $basename;
                $metadata->filepath = $filepath;
                $metadata->type = $type;
                $metadata->size = $size;
                $metadata->save();
                $mediaIds[] = $metadata->id;
            }
            $quotationProduct = QuotationProduct::find($quoteProductId);
            $quotationProduct->medias()->attach($mediaIds);
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function deleteBindingDocs(Request $request)
    {
        $media = Metadata::find($request->id);
        if($media){
            $media->ProductMedia()->detach($request->productId);
            $media->delete();
            return response()->json(['success' => 'File deleted successfully']);
        }else{
            return response()->json(['error' => 'Media not found.'], 404);
        }

    }

    public function getMedia(Request $request)
    {
        $quotationProduct = QuotationProduct::find($request->id);
        $mediaIds = $quotationProduct->medias()->pluck('metadata_id')->toArray();
        $medias = Metadata::whereIn('id', $mediaIds)->get();
        return response()->json($medias);
    }

}
