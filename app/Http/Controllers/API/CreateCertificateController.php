<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\sendTemplatedEmail;
use App\Models\Certificate;
use App\Models\Insurer;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\Templates;
use App\Services\AirslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Switch_;

class CreateCertificateController extends BaseController
{
    //
    protected $airslateService;



    public function __construct(AirslateService $airslateService){
        $this->airslateService = $airslateService;

    }


    public function generateCertPdf(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $leadData = json_decode($data['selectedData'], true);
            $insuredInformation = $leadData['company_name'] . "\n" . $leadData['general_information']['address'];
            $data['leadData'] = $leadData;

            $generalLiabilityPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'General Liability';
            });

            $toolsEquipmentPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Tools Equipment';
            });

            $commercialAutoPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Commercial Auto';
            });

            $excessLiabilityPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Excess Liability';
            });

            $businessOwnersPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Business Owners';
            });

            $buildersRiskPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Builders Risk';
            });

            $workersCompPolicy = array_filter($data['leadData']['activePolicies'], function($policy){
                return isset($policy['QuotationProduct']) && $policy['QuotationProduct']['product'] === 'Workers Compensation';
            });

            $generalLiabilityPolicy = array_values($generalLiabilityPolicy);

            $generalLiabilityPolicyData = array_map(function ($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                    'each_occurence' => $policy['GeneralLiabilty']['each_occurence'],
                    'damage_to_rented' => $policy['GeneralLiabilty']['damage_to_rented'],
                    'med_exp' => $policy['GeneralLiabilty']['medical_expenses'],
                    'perspmal_adv_injury' => $policy['GeneralLiabilty']['per_adv_injury'],
                    'gen_aggregate' => $policy['GeneralLiabilty']['gen_aggregate'],
                    'product_comp' => $policy['GeneralLiabilty']['product_comp'],
                ];
            }, $generalLiabilityPolicy);

            $toolsEquipmentPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $toolsEquipmentPolicy);

            $commercialAutoPolicy = array_values($commercialAutoPolicy);
            $commercialAutoPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $commercialAutoPolicy);

            $excessLiabilityPolicy = array_values($excessLiabilityPolicy);
            $excessLiabilityPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $excessLiabilityPolicy);

            $businessOwnersPolicy = array_values($businessOwnersPolicy);
            $businessOwnersPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $businessOwnersPolicy);

            $businessOwnersPolicy = array_values($businessOwnersPolicy);
            $buildersRiskPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $businessOwnersPolicy);

            $workersCompPolicy = array_values($workersCompPolicy);
            $workersCompPolicyData = array_map(function($policy){
                $naic = Insurer::where('name', $policy['carrier'])->first();
                return [
                    'policy_number' => $policy['policy_number'],
                    'carrier' => $policy['carrier'],
                    'market' => $policy['market'],
                    'effective_date' => $policy['effective_date'],
                    'expiration_date' => $policy['expiration_date'],
                    'naic' => $naic ? $naic->naic_number : ' ',
                ];
            }, $workersCompPolicy);

            $data['generalLiabilityPolicyData'] = $generalLiabilityPolicyData;
            $data['commercialAutoPolicyData'] = $commercialAutoPolicyData;

            $documentListsRes = $this->airslateService->getDocumentLists();
            foreach($documentListsRes['data']['data'] as $pfdData){
                if($pfdData['filename'] == 'acord_25 (1)'){
                    $id = $pfdData['id'];
                }
            }
            if(!$id == null){
                $fillableFields = $this->airslateService->getDocumentFields($id);
                $data['fillableFields'] = $fillableFields;
                foreach ($fillableFields['data']['data'] as $fillableField) {
                    switch ($fillableField['name']) {
                        case 'insured_information':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $insuredInformation, // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break; // Prevent fall-through
                        case 'cert_holder':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $data['companyName'], // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break; // Prevent fall-through
                        case 'description':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $data['descriptionOperation'], // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break; // Prevent fall-through
                        case 'insurer_a':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' =>$generalLiabilityPolicyData ?  $generalLiabilityPolicyData['0']['carrier'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'naic_a':
                        $dataValueInformation = [
                            'data' => [
                                [
                                    'id' => $fillableField['id'],  // Field ID
                                    'value' => $generalLiabilityPolicyData ?  $generalLiabilityPolicyData['0']['naic'] : ' ', // Value to prefill
                                ]
                            ]
                        ];
                        $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                        break;
                        case 'insurer_b':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' =>   $commercialAutoPolicyData ? $commercialAutoPolicyData['0']['carrier'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'naic_b':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $commercialAutoPolicyData ?  $commercialAutoPolicyData['0']['naic'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'insurer_c':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $excessLiabilityPolicyData ?  $excessLiabilityPolicyData['0']['carrier'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'policy_number_a':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['policy_number'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'gen_liab_effective_date':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['effective_date'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'gen_liab_expiration_date':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['expiration_date'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'each_occurence':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['each_occurence'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'damage_to_rented':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['damage_to_rented'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'med_exp':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['med_exp'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'perspmal_adv_injury':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['perspmal_adv_injury'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'gen_aggregate':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['gen_aggregate'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'product_comp':
                                $dataValueInformation = [
                                    'data' => [
                                        [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $generalLiabilityPolicyData ? $generalLiabilityPolicyData['0']['product_comp'] : ' ', // Value to prefill
                                        ]
                                    ]
                                ];
                                $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                                break;
                        case 'policy_number_b':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                            'id' => $fillableField['id'],  // Field ID
                                            'value' => $commercialAutoPolicyData ? $commercialAutoPolicyData['0']['policy_number'] : ' ',
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'commercial_auto_effective_date':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $commercialAutoPolicyData ? $commercialAutoPolicyData['0']['effective_date'] : ' ',
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'commercial_auto_expiration_date':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $commercialAutoPolicyData ? $commercialAutoPolicyData['0']['expiration_date'] : ' ',
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;
                        case 'policy_number_c':
                            $dataValueInformation = [
                                'data' => [
                                    [
                                        'id' => $fillableField['id'],  // Field ID
                                        'value' => $excessLiabilityPolicyData ? $excessLiabilityPolicyData['1']['policy_number'] : ' ', // Value to prefill
                                    ]
                                ]
                            ];
                            $responsePrefill = $this->airslateService->prefillFields($id, $dataValueInformation);
                            break;

                    }
                }

               $createDocLink = $this->airslateService->createDocumentLink($id);
               $downloadResponse = $this->airslateService->downloadDocument($id, 1);


               $basename = 'document_'  . time() . '.pdf';
               $directoryPath = public_path('backend/assets/attachedFiles/certificate');

               if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
               }

               $filePath = $directoryPath . '/' . $basename;
               File::put($filePath, $downloadResponse->body());

               $type = 'application/pdf'; // Assuming it's always a PDF
               $size = File::size($filePath);

               $metadata = new Metadata();
               $metadata->basename = $basename;
               $metadata->filename = $basename;
               $metadata->filepath = 'backend/assets/attachedFiles/certificate/' . $basename;
               $metadata->type = $type;
               $metadata->size = $size;
               $metadata->save();

               $certificate = new Certificate();
               $certificate->lead_id = $leadData['id'];
               $certificate->media_id = $metadata->id;

               if($data['projectDescription'] == 'Default'){
                $template = Templates::find(15);
                $subject = 'Cert Request';
                $sendingMail = Mail::to('maechael108@gmail.com')->send(new sendTemplatedEmail($subject, $template->html,  $metadata->filepath));
                $certificate->status = 'approved';
               }else{
                $certificate->status = 'pending';
               }
               $certificate->requested_date = now();
               $certificate->phone_number = $data['contactNumber'];
               $certificate->email = $data['emailAddress'];
               $certificate->cert_holder = $data['companyName'];
               $certificate->save();

            }
            DB::commit();
            return response()->json(['message' => 'Data stored successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
