<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\QuoteComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    //
    public function store(Request $request)
    {
        try{
            $hiddenId = $request->input('hidden_id');
            $file = $request->file('file');

            // $quoteComparison = QuoteComparison::find($hiddenId);
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
            $metadata->QuoteComparison()->sync($hiddenId);
            return response()->json(['success' => 'File uploaded successfully']);
        }catch(\Exception $e){
            Log::error($e);
            return response()->json(['error' => $e], 500);
        }

    }

    public function deleteQuotationFile(Request $request)
    {
        try{
            $media = Metadata::find($request->input('id'));
            $media->QuoteComparison()->detach($request->input('hidden_id'));
            $media->delete();
        }catch(\Exception $e){
            Log::error($e);
            return response()->json(['error' => $e], 500);
        }
    }
//     public function store(Request $request)
// {
//     $hiddenId = $request->input('hidden_id');
//     $file = $request->file('file');

//     if (!$file) {
//         return response()->json(['error' => 'No file uploaded'], 400);
//     }

//     $quoteComparison = QuoteComparison::find($hiddenId);
//     if (!$quoteComparison) {
//         return response()->json(['error' => 'Quote comparison not found'], 404);
//     }

//     DB::beginTransaction();
//     try {
//         $basename = Str::random(40) . '.' . $file->getClientOriginalExtension();
//         $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');
//         $type = $file->getClientMimeType();
//         $size = $file->getSize();
//         $filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $basename;

//         if (!File::isDirectory($directoryPath)) {
//             File::makeDirectory($directoryPath, 0777, true, true);
//         }

//         $file->move($directoryPath, $basename);

//         $metadata = new Metadata();
//         $metadata->basename = $basename; // Consider storing a sanitized name
//         $metadata->filename = $basename;
//         $metadata->filepath = $filepath;
//         $metadata->type = $type;
//         $metadata->size = $size;
//         $metadata->save();

//         // For one-to-many relationship
//         $quoteComparison->metadata()->save($metadata);

//         DB::commit();
//         return response()->json(['success' => 'File uploaded successfully']);
//     } catch (\Exception $e) {
//         DB::rollback();
//         return response()->json(['error' => 'File upload failed'], 500);
//     }
// }

}