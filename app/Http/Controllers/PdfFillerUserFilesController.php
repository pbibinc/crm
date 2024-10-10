<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Metadata;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Services\AirslateService;

class PdfFillerUserFilesController extends Controller
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
                    $directoryPath = storage_path("app/public/pdf/user-files/{$user_id}/");
                    if (!File::isDirectory($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    // Move the file to the user-specific folder
                    $file->move($directoryPath, $filename);

                    // File metadata
                    $filepath = "storage/pdf/user-files/{$user_id}/{$filename}"; // Store relative to public

                    // Save metadata in the database
                    $metadata = new Metadata();
                    $metadata->basename = $basename;
                    $metadata->filename = $filename;
                    $metadata->filepath = $filepath;
                    $metadata->type = $file->getClientMimeType();
                    $metadata->size = $size; // Use the size we captured before moving
                    $metadata->save();

                    $userProfile = UserProfile::where('user_id', $user_id)->first();
                    $userProfile->pdfUserFiles()->attach($metadata->id);

                    DB::commit();

                    $functionResponse = $this->airslateService->uploadDocumentToStorage($directoryPath . $filename, $filename);

                    if ($functionResponse['status'] === 'success') {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'File uploaded successfully to both local and Airslate',
                            'file' => [
                                'document_id' => $functionResponse['id'],
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

    // public function delete(Request $request) {
    //     try {
    //         if ($request->isMethod('delete')) {

    //             $validatedData = $request->validate([
    //                 'documentId' => 'required|string',
    //             ]);

    //             DB::beginTransaction();

    //             // Delete the file and record on database first
    //             $metadata = Metadata::find($documentId);

    //             if (!$metadata) {
    //                 throw new Exception('Document not found in the database.');
    //             }

    //             // Remove associations with the user profile, if any
    //             $userProfile = UserProfile::where('user_id', Auth::id())->first();
    //             if ($userProfile) {
    //                 $userProfile->pdfUserFiles()->detach($metadata->id);
    //             }

    //             // Get the file path before deleting the DB record
    //             $filePath = storage_path("app/public/" . $metadata->filepath);

    //             // Delete the metadata record
    //             $metadata->delete();

    //             // Step 2: Delete the file from the local directory
    //             if (File::exists($filePath)) {
    //                 File::delete($filePath);
    //             } else {
    //                 throw new Exception('File not found in the local storage.');
    //             }

    //             $functionResponse = $this->airslateService->deleteDocument($metadata->);

    //             if ($functionResponse['status'] === 'success') {
    //                 DB::commit();

    //                 return response()->json([
    //                     'status' => 'success',
    //                     'message' => 'File uploaded successfully to both local and Airslate',
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'File uploaded locally, but failed to upload to Airslate',
    //                 ], 500);
    //             }
    //         } else {
    //             throw new Exception('Method not allowed');
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    //     }
    // }
}
