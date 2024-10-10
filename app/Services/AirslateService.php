<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class AirslateService
{
    protected $accessToken;

    public function __construct() {
        $this->accessToken = app('airslate_token');
    }

    public function getDocumentLists() {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'page' => '1',
                'perPage' => '10'
            ])->get('https://pdf.airslate.io/v1/documents');

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch document list to Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function uploadDocumentToStorage($filePath, $documentName)
    {
        try {
            // Storage ID (PDFFiller Storage ID)
            $storageId = "10cb9844-7522-11ef-aa66-5e2d73e72919";

            // Make the HTTP request to upload the document to Airslate
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Accept' => 'application/json',
            ])->attach(
                'document', file_get_contents($filePath), $documentName
            )->post('https://pdf.airslate.io/v1/documents', [
                'documentName' => $documentName,
                'storageId' => $storageId
            ]);

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to upload document to Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function addTagsToDocument($documentId, $tags){
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->post("https://pdf.airslate.io/v1/documents/{$documentId}/tags", [
                'data' => $tags
            ]);

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add tags to document'];
            }
        } catch (Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }

    public function createDocumentLink($documentId)
    {
        try {
            $url = "https://pdf.airslate.io/v1/documents/{$documentId}/link";
            $editorUiConfig = [
                'doneButton' => [
                    'visible' => true,
                    'label' => 'Done'
                ],
                'logo' => [
                    'visible' => false,
                    'url' => asset('backend/assets/images/logopbibinc.png')
                ],
                'tools' => [
                    [
                        'signature' => true,
                        'options' => [
                            'type' => true,
                            'draw' => true,
                            'upload' => true
                        ]
                    ],
                    ['text' => true],
                    [
                        'initials' => true,
                        'options' => [
                            'type' => true,
                            'draw' => true,
                            'upload' => true
                        ]
                    ],
                    ['date' => true],
                    ['x' => true],
                    ['y' => true],
                    ['v' => true],
                    ['o' => true],
                    ['erase' => true],
                    ['highlight' => true],
                    ['blackout' => true],
                    ['textbox' => true],
                    ['arrow' => true],
                    ['line' => true],
                    ['pen' => true],
                    ['rearrange' => true],
                    ['sticky' => true],
                    ['replaceText' => true],
                    ['image' => true]
                ],
                'options' => [
                    ['wizard' => true],
                    ['help' => true],
                    ['search' => true],
                    ['pagesPanel' => true]
                ],
                'advancedOptions' => [
                    ['addFillableFields' => true],
                    ['addWatermark' => true]
                ]
            ];
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->post($url, [
                'documentId' => $documentId,
                'expirationInSeconds' => 3600,
                'editorAppearanceConfig' => $editorUiConfig
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create document link from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function downloadDocument($documentId, $withFillableFields = 1) {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/pdf',
                'Authorization' => "Bearer {$this->accessToken}",
            ])->get("https://pdf.airslate.io/v1/documents/{$documentId}/download", [
                'withFillableFields' => $withFillableFields,
            ]);

            return $response;

        } catch (Exception $e) {
            Log::error('Exception when downloading document', [
                'documentId' => $documentId,
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function downloadDocument($documentId, $withFillableFields = true) {
    //     try {
    //         // Ensure withFillableFields is 'true' or 'false' as a string
    //         $withFillableFields = $withFillableFields ? 'true' : 'false';

    //         // Include the parameter in the URL query string
    //         $url = "https://api.airslate.com/v1/documents/{$documentId}/download?withFillableFields={$withFillableFields}";

    //         $response = Http::withHeaders([
    //             'Authorization' => "Bearer {$this->accessToken}",
    //         ])->get($url);

    //         if ($response->successful()) {
    //             $pdfContent = $response->body();
    //             return response($pdfContent, 200)
    //                 ->header('Content-Type', 'application/pdf')
    //                 ->header('Content-Disposition', "attachment; filename={$documentId}.pdf");
    //         } else {
    //             Log::error('Failed to download document', [
    //                 'documentId' => $documentId,
    //                 'status' => $response->status(),
    //                 'body' => $response->body(),
    //             ]);

    //             return response()->json(['error' => 'Failed to download the document.'], $response->status());
    //         }

    //     } catch (Exception $e) {
    //         Log::error('Exception when downloading document', [
    //             'documentId' => $documentId,
    //             'exception' => $e->getMessage(),
    //         ]);
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    public function deleteDocument($documentId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'documentId' => $documentId
            ])->delete('https://pdf.airslate.io/v1/documents/{documentId}');

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete the document from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function extractDataFromPdf($filePath, $documentName, $fields) {
        try {
            // Prepare multipart data
            $multipartData = [
                [
                    'name'     => 'document',
                    'contents' => fopen($filePath, 'r'),
                    'filename' => $documentName,
                ],
                [
                    'name'     => 'fields',
                    'contents' => json_encode($fields),
                    'headers'  => ['Content-Type' => 'application/json'],
                ]
            ];

            // Send the request to Airslate
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Accept'        => 'application/json',
            ])
            ->attach('document', file_get_contents($filePath), $documentName)
            ->post('https://pdf.airslate.io/v1/documents/tools/extract-data', [
                'multipart' => $multipartData,
            ]);

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to OCR the document from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function compressPdf($documentId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => ["application/pdf", "application/json"],
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "multipart/form-data"
            ])
            ->post('https://pdf.airslate.io/v1/documents/tools/compress-pdf', [
                'documentId' => $documentId,
                'quality' => 'medium'
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to compress the document from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // DOCGEN WORKFLOW API
    public function createOrg($dataArr) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])
            ->post("https://api.airslate.io/v1/organizations", [
                'name' => $dataArr['name'],
                'subdomain' => $dataArr['subdomain'],
                'category' => $dataArr['category'],
                'size' => $dataArr['size'],
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create organization on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function listOfOrgs() {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->accessToken}",
            ])
            ->withUrlParameters([
                'page' => 1,
                'per_page' => 50,
            ])
            ->get("https://api.airslate.io/v1/organizations");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch organization list from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function listOfTemplates($orgId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
            ])
            ->withUrlParameters([
                'organization_id' => $orgId,
                'page' => 1,
                'per_page' => 50,
                'tags' => []
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch organization list from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createNewTemplate($orgId, $dataArr) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates", [
                'name' => $dataArr['name'],
                'description' => $dataArr['description'],
                'redirect_url' => $dataArr['redirect_url'],
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create new template on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getTemplateInfoById($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch template info from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update template on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->delete("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete template on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function generateTemplateLink($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/distribute");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to generate template link on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createTemplateCopy($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/copy");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to copy template on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllTemplateVersion() {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch templates from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createNewTemplateVersion($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create new template version on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function publishTemplateVersion($orgId, $templateId, $versionId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'version_id' => $versionId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions/{version_id}/publish");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to publish template version on Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getDocumentsInTemplate($orgId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get documents in template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function uploadDocumentToTemplate($orgId, $templateId, $dataArr) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents", [
                "name" => $dataArr["fileName"],
                "type" => "PDF",
                "is_conditional" => true,
                "content" => $dataArr["content"]
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to upload document to template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getInfoAboutDocInTemplate($orgId, $templateId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'document_id' => $documentId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents/{document_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get info about doc in template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function prefillDocumentInTemplate($orgId, $templateId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'document_id' => $documentId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents/{document_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to prefill document in template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteDocumentInTemplate($orgId, $templateId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'document_id' => $documentId
            ])->delete("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents/{document_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete document in template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getDocumentsWithinTemplateVersion($orgId, $templateId, $versionId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'version_id' => $versionId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions/{version_id}/documents");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get documents within template version from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getInfoAboutDocumentWithinTemplateVersion($orgId, $templateId, $versionId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'version_id' => $versionId,
                'document_id' => $documentId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions/{version_id}/documents/{document_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get info about document within template version from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllStepsForTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/steps");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get all teps for template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createNewStep($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])
            ->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])
            ->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/steps");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create new step from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateStep($orgId, $templateId, $stepId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'step_id' => $stepId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/steps/{step_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update step from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteStep($orgId, $templateId, $stepId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'step_id' => $stepId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/steps/{step_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete steps from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getStepsForTemplateVersion($orgId, $templateId, $versionId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'version_id' => $versionId
            ])->get('https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions/{version_id}/steps');
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get steps for template version from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getFieldsAssignedToSteps($orgId, $templateId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'document_id' => $documentId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents/{document_id}/assignments");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get fields assigned to steps from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function assignFieldsToSteps($orgId, $templateId, $documentId, $data) {
        try {
            $response = Http::withHeaders([
              'Accept-Encoding' => "application/json",
              'Authorization' => "Bearer {$this->accessToken}",
              'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'document_id' => $documentId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents/{document_id}/assignments");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to assign fields to steps from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getFieldsAssignedToStepsForTemplateVersion($orgId, $templateId, $versionId, $documentId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'version_id' => $versionId,
                'document_id' => $documentId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/versions/{version_id}/documents/{document_id}/assignments");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get fields assigned to steps for template version from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getTemplateTags($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->get('https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/tags');
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get template tags from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function addTagToTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/tags");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add tag to template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function removeTag($orgId, $templateId, $tagId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'tag_id' => $tagId
            ])->delete("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/tags/{tag_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to remove tags from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getStepJumpsWithinTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/step-jumps");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get step jumps within template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function addJumpToStep($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
               'Accept-Encoding' => "application/json",
               'Authorization' => "Bearer {$this->accessToken}",
               'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/step-jumps");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add jump to step from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateJumpToStep($orgId, $templateId, $jumpId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'jump_id' => $jumpId
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/step-jumps/{jump_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update jump to step from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function removeJumpToStep($orgId, $templateId, $jumpId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'jump_id' => $jumpId
            ])->delete("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/step-jumps/{jump_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to remove jump to step from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getListsOfAvailableBots($orgId) {
        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/bots");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get lists of available bots from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getTemplateBots($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->get("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/bots");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to get template bots from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function attachBotToTemplate($orgId, $templateId) {
        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId
            ])->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/bots");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to attach bot to template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateBot() {
        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])->patch("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/bots/{template_bot_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update bot from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    public function removeBot($orgId, $templateId, $templateBotId) {
        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}"
            ])->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
                'template_bot_id' => $templateBotId
            ])->delete("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/bots/{template_bot_id}");
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to remove bot from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function fetchTemplates($orgId) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
            ])
            ->withUrlParameters([
                'organization_id' => $orgId
            ])
            ->get('https://api.airslate.io/v1/organizations/{organization_id}/templates');
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to fetch templates from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function uploadDocToTemplate($orgId, $templateId, $data) {
        try {
            $response = Http::withHeaders([
                'Accept-Encoding' => "application/json",
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => "application/json"
            ])
            ->withUrlParameters([
                'organization_id' => $orgId,
                'template_id' => $templateId,
            ])
            ->post("https://api.airslate.io/v1/organizations/{organization_id}/templates/{template_id}/documents", [
                "name" => $data["fileName"],
                "type" => "DOC_GENERATION",
                "is_conditional" => true,
                "content" => $data["content"]
            ]);
            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                return ['status' => 'error', 'message' => 'Failed to upload docx to template from Airslate'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
