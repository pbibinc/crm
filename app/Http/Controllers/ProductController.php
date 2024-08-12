<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\QuotationProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    //

    public function saveMedia(Request $request)
    {
       try{
        DB::beginTransaction();
        $files = $request->file('files');
        $mediaIds = [];
        foreach($files as $file){
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/binding/request-to-bind');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/binding/request-to-bind/' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

            $mediaIds[] = $metadata->id;

        }
        $product = QuotationProduct::find($request->id);
        $product->medias()->sync($mediaIds);
        DB::commit();
        return response()->json(['success' => 'File uploaded successfully']);
       }catch(\Exception $e){
        return response()->json(['error' => $e->getMessage()]);
        DB::rollback();
       }
    }

    public function getRTBMedia(Request $request)
    {
        $product = QuotationProduct::find($request->id);
        $medias = $product->medias;
        return response()->json(['medias' => $medias]);
    }

    // public function getProductInformation(Request $request)
    // {

    // }


}