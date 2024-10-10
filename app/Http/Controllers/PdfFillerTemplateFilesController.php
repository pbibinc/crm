<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\PdfFillerTemplateFiles;
use App\Services\AirslateService;

class PdfFillerTemplateFilesController extends Controller
{
    protected $airslateService;

    // Inject the Airslate service in the constructor
    public function __construct(AirslateService $airslateService)
    {
        $this->airslateService = $airslateService;
    }
    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                if ($request->hasFile('file')) {

                    DB::beginTransaction();
                    $user_id = Auth::id();

                    // Validate the file
                    $validatedData = $request->validate([
                        'file' => 'required|mimes:pdf|max:30000',
                    ]);

                    $file = $validatedData['file'];

                    // Get the file size before moving it
                    $size = $file->getSize();

                    // Generate a unique filename to avoid overwriting
                    $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $filename = $basename . '_' . time() . '.' . $extension;

                    // Set the storage path
                    $directoryPath = storage_path("app/public/pdf/template-files/");
                    if (!File::isDirectory($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    // Move the file to the user-specific folder
                    $file->move($directoryPath, $filename);

                    // File metadata
                    $filepath = "storage/pdf/template-files/{$filename}";

                    // Save metadata in the database
                    $metadata = new Metadata();
                    $metadata->basename = $basename;
                    $metadata->filename = $filename;
                    $metadata->filepath = $filepath;
                    $metadata->type = $file->getClientMimeType();
                    $metadata->size = $size;
                    $metadata->save();

                    $template_file = new PdfFillerTemplateFiles();
                    $template_file->media_id = $metadata->id;
                    $template_file->template_name = $filename;
                    $template_file->uploaded_by = $user_id;
                    $template_file->save();

                    DB::commit();

                    $functionResponse = $this->airslateService->uploadDocumentToStorage($directoryPath . $filename, $filename);

                    if ($functionResponse['status'] === 'success') {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'File uploaded successfully to both local and Airslate',
                            'file' => [
                                'filename' => $filename,
                                'filepath' => $filepath,
                                'upload_date' => now()->format('Y-m-d'),
                            ]
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'File uploaded locally, but failed to upload to Airslate',
                        ], 500);
                    }
                } else {
                    throw new Exception('No file uploaded');
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            DB::rollBack(); // Roll back the transaction on error
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request) {
        try {
            if ($request->isMethod('delete')) {

                DB::beginTransaction();


            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
