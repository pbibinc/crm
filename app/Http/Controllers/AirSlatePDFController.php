<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Services\AirslateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\PdfFillerTemplateFiles;

class AirSlatePDFController extends Controller
{
    protected $airslateService;

    public function __construct(AirslateService $airslateService) {
        $this->airslateService = $airslateService;
    }

    public function pdfEditorIndex() {
        $user_id = Auth::id();
        $userProfile = UserProfile::where('user_id', $user_id)->first();
        $user_files = $userProfile->pdfUserFiles()->get();
        $user_files->sortBy('id');
        $template_files = PdfFillerTemplateFiles::get()->sortBy('id');
        return view('pdf-tools.pdf-edit.index', compact('user_files', 'template_files'));
    }

    public function pdfEditorStore(Request $request) {
        try {
            if ($request->isMethod('post')) {
                if ($request->hasFile('file')) {
                    $documentFile = $request->file('file');
                    $documentName = $documentFile->getClientOriginalName();
                    $filePath = $documentFile->getRealPath();
                    // $fileSize = $documentFile->getSize();
                    $tags = json_decode($request->input('tags'), true);

                    // Upload the document first
                    $uploadResponse = $this->airslateService->uploadDocumentToStorage($filePath, $documentName);

                    // Check if the document upload was successful and tags exist
                    if ($uploadResponse['status'] === 'success' && count($tags) > 0) {
                        // Add tags to the uploaded document
                        $processAddingTags = $this->airslateService->addTagsToDocument($uploadResponse['data']['data']['id'], $tags);
                        if ($processAddingTags['status'] === 'success') {
                            return $processAddingTags;
                        }
                    } else {
                        return $uploadResponse;
                    }
                } else {
                    throw new Exception('No file uploaded');
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function pdfEditorFetch(Request $request) {
        try {
            if ($request->isMethod('get')) {
                // Fetch document lists from Airslate API
                $documentListsRes = $this->airslateService->getDocumentLists();

                if ($documentListsRes['status'] === 'success') {
                    $documents = $documentListsRes['data']['data']; // Get the list of documents

                    $documentLinks = []; // To store document links

                    // Loop through each document
                    foreach ($documents as $document) {
                        // Create a document link using the document ID
                        $createDocLink = $this->airslateService->createDocumentLink($document['id']);

                        // Check if link creation was successful
                        if ($createDocLink['status'] === 'success') {
                            // Add the document link to the array with other document details
                            $documentLinks[] = [
                                'document' => $document,
                                'link' => $createDocLink['data'] // Store the generated link
                            ];
                        } else {
                            // Handle any error during link creation
                            $documentLinks[] = [
                                'document' => $document,
                                'link' => 'Failed to create link'
                            ];
                        }
                    }

                    // Return the document details along with the generated links
                    return response()->json([
                        'status' => 'success',
                        'documentLinks' => $documentLinks
                    ], 200);
                } else {
                    // Return error if fetching documents failed
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to fetch documents from Airslate'
                    ], 500);
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function pdfEditorDelete(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string'
                ]);

                $documentRes = $this->airslateService->deleteDocument($validatedData['documentId']);
                if ($documentRes['status'] === 'success') {
                    return $documentRes;
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to delete document'
                    ], 500);
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pdfEditorDownload(Request $request) {
        try {
            $documentId = $request->documentId;
            if (!$documentId) {
                return response()->json(['error' => 'Document ID is required'], 400);
            }

            return $this->airslateService->downloadDocument($documentId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ocrPdfIndex() {
        return view('pdf-tools.ocr-pdf.index');
    }

    public function ocrPdfStore(Request $request) {
        try {
            if ($request->isMethod('post')) {
                if ($request->hasFile('file')) {
                    $documentFile = $request->file('file');
                    $documentName = $documentFile->getClientOriginalName();
                    $filePath = $documentFile->getRealPath();

                    // Decode keywords from JSON
                    $keywords = json_decode($request->input('keywords'), true);

                    // Validate that keywords are in a valid format
                    if (!is_array($keywords) || empty($keywords)) {
                        throw new Exception('Invalid keywords format.');
                    }

                    // Call the Airslate service to process the document
                    return $this->airslateService->extractDataFromPdf($filePath, $documentName, $keywords);
                } else {
                    throw new Exception('No file uploaded');
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // DocGen API
    // Organization
    public function pdfWorkflowIndex() {
        return view('pdf-tools.pdf-workflow.index');
    }

    public function createNewOrganization() {}

    public function fetchListOfOrganization() {}

    public function getOrganizationSettings() {}

    public function updateOrganizationSettings() {}

    public function fetchListOfTemplate() {}

    public function createNewTemplate() {}

    public function getTemplateInfoById() {}

    public function updateTemplate() {}

    public function deleteTemplate() {}

    public function createLinkToTemplate() {}

    public function createTemplateCopy() {}

    public function getAllTemplateVersion() {}

    public function createNewTemplateVersion() {}

    public function publishTemplateVersion() {}

    public function getDocumentsInTemplate() {}

    public function uploadDocumentToTemplate() {}

    public function getInfoAboutDocumentInTemplate() {}

    public function prefillDocumentInTemplate() {}

    public function deleteDocumentInTemplate() {}

    public function getDocumentsWithinTemplateVersion() {}

    public function getInfoAboutDocumentWithinTemplateVersion() {}

    public function listOfOrganizations(Request $request) {
        try {
            if ($request->isMethod('get')) {
                return $this->airslateService->fetchOrgList();
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pdfUploadDocToTemplate(Request $request) {
        try {
            if ($request->isMethod('post')) {
                if ($request->hasFile('file')) {
                    $documentFile = $request->file('file');
                    $documentName = $documentFile->getClientOriginalName();
                    $filePath = $documentFile->getRealPath();
                    $fileContent = file_get_contents($filePath);
                    $base64String = base64_encode($fileContent);
                    $mimeType = $documentFile->getMimeType();
                    $base64File = "data:{$mimeType};base64,{$base64String}";
                    $orgId = "";
                    $templateId = "";
                    $dataArr = [];
                    $dataArr[] = [
                        "fileName" => $documentName,
                        "content" => $base64File,
                    ];
                    // Get the org and template id first
                    $fetchOrgRes = $this->airslateService->fetchOrgList();
                    if ($fetchOrgRes['status'] === 'success') {
                        $orgId = $fetchOrgRes['data'][0]['id'];
                        $fetchTemplatesRes = $this->airslateService->fetchTemplates($orgId);
                        if ($fetchTemplatesRes['status'] === 'success') {
                            $templateId = $fetchTemplatesRes['data'][0]['id'];
                        } else {
                            return $fetchTemplatesRes;
                        }
                    } else {
                        return $fetchOrgRes;
                    }
                    $this->airslateService->uploadDocToTemplate($orgId, $templateId, $dataArr);
                } else {
                    throw new Exception('No file uploaded');
                }
            } else {
                throw new Exception('Method not allowed');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
