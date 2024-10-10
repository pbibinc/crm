<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PdfController extends Controller
{
    public function handleWebhook(Request $request){
        // Log the incoming request for debugging purposes
        Log::info('Webhook received', ['payload' => $request->all()]);

        // TODO: Add your webhook handling logic here

        // Example: Check if the event type is what you expect
        $eventType = $request->input('event_type'); // Adjust this based on the expected payload

        if ($eventType == 'expected_event_type') {
            // Process the event
        } else {
            // Unexpected event type
            Log::warning('Unexpected webhook event type', ['event_type' => $eventType]);
        }

        // Respond to acknowledge the receipt of the webhook
        return response()->json(['status' => 'success'], 200);
    }

    public function handleRedirect(Request $request)
    {
        // return view('pdf-tools.pdf-edit.index');
    }

    private function getBaseUrl($type)
    {
        // Check if the application is running in a local environment
        if (app()->environment('local')) {
            switch ($type) {
                case 'storage':
                    Log::info('Server info: ' . config('services.airslate.mockStorageUrl'));
                    return config('services.airslate.mockStorageUrl');
                case 'document':
                    Log::info('Server info: ' . config('services.airslate.mockDocumentUrl'));
                    return config('services.airslate.mockDocumentUrl');
                case 'template':
                    Log::info('Server info: ' . config('services.airslate.mockTemplateUrl'));
                    return config('services.airslate.mockTemplateUrl');
                case 'pdftools':
                    Log::info('Server info: ' . config('services.airslate.mockPdfToolsUrl'));
                    return config('services.airslate.mockPdfToolsUrl');
                default:
                    Log::info('Server info: ' . config('services.airslate.baseUrl'));
                    return config('services.airslate.baseUrl');
            }
        } else {
            return rtrim(config('services.airslate.'), '/');
        }
    }

    // Storage APIS

    public function connectToStorage(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    "Accept-Encoding" => "application/json",
                    "Authorization" => "Bearer {$accessToken}",
                    "Content-Type" => "application/json"
                ])->post('https://pdf.airslate.io/v1/storages', [
                    "data" => [
                        "providerId" => 2,
                        "label" => "My pdfFiller storage"
                    ]
                ]);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to connect to PDFFiller Storage.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function createStorage(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'data' => 'required|array',
                    'data.providerId' => 'required|integer',
                    'data.label' => 'required|string'
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    "Accept-Encoding" => "application/json",
                    "Authorization" => "Bearer {$accessToken}",
                    "Content-Type" => "application/json"
                ])
                ->post('https://pdf.airslate.io/v1/storages', $validatedData);
                // ->post($this->getBaseUrl('storage').'/v1/storages', $validatedData);
                return $response;
                // if ($response->successful()) {
                //     return response()->json($response->json(), 200);
                // } else {
                //     return response()->json(['error' => 'Failed to create storage.'], $response->status());
                // }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function getListOfStorages(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $validatedData = $request->validate([
                    'page' => 'nullable|integer',
                    'perPage' => 'nullable|integer'
                ]);
                // $page = $validatedData['page'] ?? 10;
                // $perPage = $validatedData['perPage'] ?? 10;
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])->get('https://pdf.airslate.io/v1/storages', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch list of storages.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function getStorageInfo(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $validatedData = $request->validate([
                    'id' => 'required|integer'
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'id' => $validatedData['id']
                ])
                ->get('https://pdf.airslate.io/v1/storages/{id}');
                // ->get($this->getBaseUrl('storage').'/v1/storages/', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch storage info.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function updateStorageInfo(Request $request) {
        try {
            if ($request->isMethod('patch')) {
                $validatedData = $request->validate([
                    'id' => 'required|integer'
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'id' => $validatedData['id']
                ])
                ->get('https://pdf.airslate.io/v1/storages/{id}', $validatedData);
                // ->get($this->getBaseUrl('storage').'/v1/storages/', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to update storage info.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a PATCH method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function deleteStorage(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'id' => 'required|integer',
                ]);
                $id = $validatedData['id'];
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'id' => $id
                ])
                ->delete('https://pdf.airslate.io/v1/storages/{id}');
                // ->delete($this->getBaseUrl('storage').'/v1/storages/{id}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to delete storage.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a DELETE method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function deleteStorageWithDocuments(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'id' => 'required|integer',
                ]);
                $id = $validatedData['id'];
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'id' => $id
                ])
                ->delete('https://pdf.airslate.io/v1/storages/{id}/withDocuments');
                // ->delete($this->getBaseUrl('storage').'/v1/storages/{id}/withDocuments');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to delete (with documents) storage.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a DELETE method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function listOfStorageProviders(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->get('https://pdf.airslate.io/v1/storage-providers');
                // ->get($this->getBaseUrl('storage').'/v1/storage-providers');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch storage providers list.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    // Document API
    public function uploadDocumentToStorage(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'file' => 'required|file|max:30720', // 'file' is the key used by Dropzone for the uploaded file
            ]);

            // Retrieve the file from the request
            $documentFile = $request->file('file'); // Adjusted to use 'file' instead of 'document'
            $documentName = $documentFile->getClientOriginalName(); // Use the original file name

            // Retrieve the access token from the service provider
            $accessToken = app('airslate_token');

            // Storage ID (PDFFiller Storage ID)
            $storageId = "10cb9844-7522-11ef-aa66-5e2d73e72919";

            // Make the HTTP request to upload the document
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ])
            ->attach(
                'document', file_get_contents($documentFile->getRealPath()), $documentName
            )
            ->post('https://pdf.airslate.io/v1/documents', [
                'documentName' => $documentName,
                'storageId' => $storageId
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                return response()->json($response->json(), 200);
            } else {
                return response()->json(['error' => 'Failed to upload document to storage.'], $response->status());
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function getDocumentLists(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'page' => '1',
                    'perPage' => '10',
                    'tags' => []
                ])
                ->get('https://pdf.airslate.io/v1/documents');
                // ->get($this->getBaseUrl('document').'/v1/documents');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch list of documents.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function createDocumentLink(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                // Validate the request data
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                    'callbackUri' => 'nullable|string',
                    'redirectUri' => 'nullable|string',
                    'expirationInSeconds' => 'nullable|integer',
                    'foreignUserId' => 'nullable|string',
                    'editorAppearanceConfig' => 'nullable|array',
                ]);

                // Log::info($validatedData['documentId']);

                // Retrieve the access token from the service provider
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];

                // Construct the URL using the documentId
                $url = "https://pdf.airslate.io/v1/documents/{$documentId}/link";
                // $url = $this->getBaseUrl('document') . "/v1/documents/{$documentId}/link";

                // Make the HTTP request to create the document link
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])->post($url, [
                    'callbackUri' => $validatedData['callbackUri'] ?? '',
                    'redirectUri' => $validatedData['redirectUri'] ?? '',
                    'expirationInSeconds' => $validatedData['expirationInSeconds'] ?? 600,
                    'foreignUserId' => $validatedData['foreignUserId'] ?? '',
                    'editorAppearanceConfig' => $validatedData['editorAppearanceConfig'] ?? [],
                ]);

                // Check if the response is successful
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to create document link.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function updateDocument(Request $request) {
        try {
            if($request->isMethod('patch')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->patch('https://pdf.airslate.io/v1/documents/{documentId}');
                // ->patch($this->getBaseUrl('document').'/v1/documents/{documentId}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to update the document.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a PATCH method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function deleteDocument(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->delete('https://pdf.airslate.io/v1/documents/{documentId}');
                // ->delete($this->getBaseUrl('document').'/v1/documents/{documentId}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to delete the document.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a DELETE method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function getDocumentInfo(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->get('https://pdf.airslate.io/v1/documents/{documentId}');
                // ->get($this->getBaseUrl('document').'/v1/documents/{documentId}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to get document info.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function getDocumentFillableFields(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/json", "text/csv"],
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->get('https://pdf.airslate.io/v1/documents/{documentId}/fields');
                // ->get($this->getBaseUrl('document').'/v1/documents/{documentId}/fields');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch document fillable fields.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function updateDocumentFields(Request $request) {
        try {
            if($request->isMethod('patch')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->patch('https://pdf.airslate.io/v1/documents/{documentId}/fields');
                // ->patch($this->getBaseUrl('document').'/v1/documents/{documentId}/fields');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to update document fillable fields.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a PATCH method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function createDocumentCopy(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->post('https://pdf.airslate.io/v1/documents/{documentId}/copy');
                // ->post($this->getBaseUrl('document').'/v1/documents/{documentId}/copy');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to create document copy.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function deleteTagsFromDocument(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'documentId' => $documentId
                ])
                ->delete('https://pdf.airslate.io/v1/documents/{documentId}/tags');
                // ->delete($this->getBaseUrl('document').'/v1/documents/{documentId}/tags');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to delete tags from document.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a DELETE method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function addTagsToDocument(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'documentId' => 'required|string',
                    'data' => 'array',
                ]);
                $accessToken = app('airslate_token');
                $documentId = $validatedData['documentId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withQueryParameters([
                    'documentId' => $documentId
                ])
                ->post('https://pdf.airslate.io/v1/documents/{documentId}/tags');
                // ->post($this->getBaseUrl('document').'/v1/documents/{documentId}/tags');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to add tags to document.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    // Template APIs
    public function getListOfTemplates(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'page' => '1',
                    'perPage' => '10'
                ])
                ->get('https://pdf.airslate.io/v1/templates');
                // ->get($this->getBaseUrl('template').'/v1/templates');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch list of templates.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function createTemplate(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'data' => 'required|array',
                    'data.documentId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->post('https://pdf.airslate.io/v1/templates', $validatedData);
                // ->post($this->getBaseUrl('template').'/v1/templates', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to create a template.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function createTemplateLink(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'templateId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $templateId = $validatedData['templateId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'templateId' => $templateId
                ])
                ->post('https://pdf.airslate.io/v1/templates/{templateId}/link');
                // ->post($this->getBaseUrl('template').'/v1/templates/{templateId}/link');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to create a template link.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function deleteTemplate(Request $request) {
        try {
            if ($request->isMethod('delete')) {
                $validatedData = $request->validate([
                    'templateId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $templateId = $validatedData['templateId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'templateId' => $templateId
                ])
                ->delete('https://pdf.airslate.io/v1/templates/{templateId}');
                // ->delete($this->getBaseUrl('template').'/v1/templates/{templateId}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to delete the template.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a DELETE method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function getTemplateInfo(Request $request) {
        try {
            if ($request->isMethod('get')) {
                $validatedData = $request->validate([
                    'templateId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $templateId = $validatedData['templateId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ])
                ->withUrlParameters([
                    'templateId' => $templateId
                ])
                ->get('https://pdf.airslate.io/v1/templates/{templateId}');
                // ->get($this->getBaseUrl('template').'/v1/templates/{templateId}');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to fetch template info.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a GET method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function createDocumentFromTemplate(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'templateId' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $templateId = $validatedData['templateId'];
                $response = Http::withHeaders([
                    'Accept-Encoding' => "application/json",
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->withUrlParameters([
                    'templateId' => $templateId
                ])
                ->post('https://pdf.airslate.io/v1/templates/{templateId}/documents');
                // ->post($this->getBaseUrl('template').'/v1/templates/{templateId}/documents');
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to create document from template.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    // PDF Tools API
    public function convertExcelToPdf(Request $request) {
        // 30MB Max file size
        try {
            if ($request->isMethod('post')) {
                $validatedFile = $request->validate([
                   'document' => [
                        'required',
                        File::types(['xlxs'])
                        ->max(30 * 1024)
                   ],
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/convert/xlsx-to-pdf', $validatedFile);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/convert/xlsx-to-pdf', $validatedFile);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert xlxs to pdf.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function splitPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => [
                        'required',
                        File::types(['pdf'])
                        ->max(30 * 1024)
                    ],
                    'ranges' => 'required|array',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/split-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/split-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert split pdf.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function mergePdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => [
                        'required',
                        File::types(['pdf'])
                        ->max(30 * 1024)
                    ],
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/merge-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/merge-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert merge pdfs.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function generateBarcode(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                   'data' => 'required|string',
                   'type' => 'required|string',
                   'logo' => 'string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["image/png", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/barcode', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/barcode', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert merge pdfs.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function addWaterMarkToPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                    'value' => 'required|string',
                    'orientation' => 'required|string',
                    'opacity' => 'required|integer',
                    'size' => 'required|integer',
                    'color' => 'required|string',
                    'applyTo' => 'string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/add-watermark', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/add-watermark', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert merge pdfs.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function compressPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                    'quality' => 'string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/compress-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/compress-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to compress the pdf file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function protectPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                    'password' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/password-protection/set', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/password-protection/set', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to put password on pdf file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function removePdfPassword(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                    'password' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/password-protection/unset', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/password-protection/unset', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to remove password on pdf file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function convertHtmlToPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'url' => 'required|string',
                    'pageSize' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/convert/html-to-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/convert/html-to-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert html file to pdf file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function generatePdfFromHtml(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'type' => 'required|string',
                    'pageSize' => 'string',
                    'data' => [
                        'html' => 'required|string',
                        'css' => 'string'
                    ],
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "application/json"
                ])
                ->post('https://pdf.airslate.io/v1/documents/tools/generate-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/generate-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to generate pdf file from html file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function convertPdfToDocx(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/convert/pdf-to-docx', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/convert/pdf-to-docx', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert pdf file to docx file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function docxToPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|string',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/convert/docx-to-pdf', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/convert/docs-to-pdf', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to convert docx file to pdf file.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
    public function extractDataFromPdf(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validatedData = $request->validate([
                    'document' => 'required|file', // File validation
                    'fields' => 'required', // Fields validation
                ]);

                // Retrieve the file and the fields
                $documentFile = $validatedData['document'];
                $fields = $request->input('fields');

                // Retrieve Airslate access token
                $accessToken = app('airslate_token');

                // Send file and fields in a multipart/form-data request
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$accessToken}",
                    'Accept' => 'application/json',
                ])
                ->attach('document', file_get_contents($documentFile->getRealPath()), $documentFile->getClientOriginalName()) // Attach the file
                ->post('https://pdf.airslate.io/v1/documents/tools/extract-data', [
                    'fields' => $fields, // The fields should be passed as a proper JSON string
                ]);

                // Handle the response
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to extract data from PDF.'], $response->status());
                }
            } else {
                throw new Exception('Invalid request, must be a POST method.');
            }
        } catch (ValidationException $validationException) {
            return response()->json(['error' => $validationException->errors()], 422);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function pdfEditor(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $editorUiConfig = [
                    'doneButton' => [
                        'visible' => true,
                        'label' => 'Done'
                    ],
                    'logo' => [
                        'visible' => true,
                        'url' => 'https://static-ak.pdffiller.com/components/global-ui/g-logo/img/svg/logo-pdffiller-new.svg'
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
                $validatedData = $request->validate([
                    'data' => 'required|array',
                    // 'data.callbackUri' => '',
                    // 'data.redirectUri' => '',
                    // 'data.foreignUserId' => '',
                    // 'data.expirationInSeconds' => '',
                    // 'data.editorAppearanceConfig' => '',
                    // 'data.editorAppearanceConfig.doneButton' => '',
                    // 'data.editorAppearanceConfig.doneButton.visible' => '',
                    // 'data.editorAppearanceConfig.doneButton.label' => '',
                    // 'data.editorAppearanceConfig.logo.visible' => '',
                    // 'data.editorAppearanceConfig.logo.url' => '',
                    // 'data.editorAppearanceConfig.tools' => '',
                ]);
                $accessToken = app('airslate_token');
                $response = Http::withHeaders([
                    'Accept-Encoding' => ["application/pdf", "application/json"],
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => "multipart/form-data"
                ])
                ->post('https://pdf.airslate.io/v1/documents/{{documentId}}/link', $validatedData);
                // ->post($this->getBaseUrl('pdftools').'/v1/documents/tools/pdf-editor', $validatedData);
                if ($response->successful()) {
                    return response()->json($response->json(), 200);
                } else {
                    return response()->json(['error' => 'Failed to extract data from pdf.'], $response->status());
                }
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
