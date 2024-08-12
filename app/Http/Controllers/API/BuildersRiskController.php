<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BuildersRisk;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use App\Models\LeadHistory;
use App\Models\NewContruction;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\Rennovation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuildersRiskController extends BaseController
{
    //

    public function storedBuildersRisk(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            $buildersRisk = new BuildersRisk();
            $buildersRisk->general_information_id = $generalInformationId;
            $buildersRisk->property_address = $data['propertyAddress'];
            $buildersRisk->value_of_structure = $data['valueOfExistingStructure'];
            $buildersRisk->value_of_work = $data['valueOfWorkBeingPerformed'];
            if($data['porjectStarted'] == "yes"){
                $buildersRisk->has_project_started = true;
            }elseif($data['porjectStarted'] == "no"){
                $buildersRisk->has_project_started = false;
                $buildersRisk->project_started_date = Carbon::parse($data['dateProjectStarted'])->toDateString();
            }
            $statusConstruction = $buildersRisk->construction_status = $data['newConstructionRenovation'];
            if($statusConstruction == "New Construction"){
                $buildersRisk->construction_status = 1;
            }elseif($statusConstruction == "Renovation"){
                $buildersRisk->construction_status = 2;
            }
            $buildersRisk->construction_type = $data['constructionType'];
            $buildersRisk->protection_class = $data['protectionClass'];
            $buildersRisk->square_footage = $data['squareFootage'];
            $buildersRisk->number_floors = $data['numberOfFloors'];
            $buildersRisk->number_dwelling = $data['numberOfUnitsDwelling'];
            $buildersRisk->jobsite_security = $data['jobSiteSecurity'];
            $buildersRisk->firehydrant_distance = $data['distanceToNearestFireHydrant'];
            $buildersRisk->firestation_distance = $data['distanceToNearestFireStation'];
            $buildersRisk->save();

              //code for saving the quote information
              $quoteProduct = new QuotationProduct();
              $leadId = $data['leadId'];
              $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
              if($quoteInformation){
                  $quoteProduct->quote_information_id = $quoteInformation->id;
              }
              $quoteProduct->product = 'Builders Risk';
              $quoteProduct->status = 7;
              $quoteProduct->save();

            if($statusConstruction == "New Construction")
            {
                $newContruction = new NewContruction();
                $newContruction->builders_risk_id = $buildersRisk->id;
                $newContruction->description_operation = $data['operationDescription'];
                $newContruction->save();
            }elseif($statusConstruction == "Renovation"){
                $renovation = new Rennovation();
                $renovation->builders_risk_id = $buildersRisk->id;
                $renovation->description = $data['propertyDescription'];
                $renovation->last_update_roofing = $data['roofingUpdateYear'];
                $renovation->last_update_heating = $data['heatingUpdateYear'];
                $renovation->last_update_plumbing = $data['plumbingUpdateYear'];
                $renovation->last_update_electrical = $data['electricalUpdateYear'];
                $renovation->stucture_occupied = $data['structureOccupiedDuringRemodelRenovation'];
                $renovation->structure_built = $data['whenWasTheStructureBuilt'];
                $renovation->description_operation = $data['descriptionOfOperationsForTheProject'];
                $renovation->save();
            }

            $expirationAuto = new ExpirationProduct();
            $expirationAuto->lead_id = $data['leadId'];
            $expirationAuto->product = 6;
            $expirationAuto->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expirationAuto->prior_carrier = $data['priorCarrier'];
            $expirationAuto->save();

            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = new HaveLoss();
                $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 6;
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::info("Error for Builders Risk", [$e->getMessage()]);
            return $this->sendError('Error in saving Builders Risk', $e->getMessage());
        }

    }

    public function updateBuildersRisk(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($id);
            $buildersRisk = BuildersRisk::getBuildersRiskData($generalInformationId);
            $oldBuildersRisk = BuildersRisk::getBuildersRiskData($generalInformationId);
            $oldNewConstruction = [];
            $oldRenovation = [];
            $buildersRiskId = $buildersRisk->id;
            $buildersRisk->property_address = $data['propertyAddress'];
            $buildersRisk->value_of_structure = $data['valueOfExistingStructure'];
            $buildersRisk->value_of_work = $data['valueOfWorkBeingPerformed'];
            $userProfileId = $data['userProfileId'];
            if($data['porjectStarted'] == "yes"){
                $buildersRisk->has_project_started = true;
                $buildersRisk->project_started_date = null;
            }elseif($data['porjectStarted'] == "no"){
                $buildersRisk->has_project_started = false;
                $buildersRisk->project_started_date = Carbon::parse($data['dateProjectStarted'])->toDateString();

            }

            $statusConstruction = $buildersRisk->construction_status = $data['newConstructionRenovation'];
            if($statusConstruction == "New Construction"){
                $buildersRisk->construction_status = 1;
            }elseif($statusConstruction == "Renovation"){
                $buildersRisk->construction_status = 2;
            }
            $buildersRisk->construction_type = $data['constructionType'];
            $buildersRisk->protection_class = $data['protectionClass'];
            $buildersRisk->square_footage = $data['squareFootage'];
            $buildersRisk->number_floors = $data['numberOfFloors'];
            $buildersRisk->number_dwelling = $data['numberOfUnitsDwelling'];
            $buildersRisk->jobsite_security = $data['jobSiteSecurity'];
            $buildersRisk->firehydrant_distance = $data['distanceToNearestFireHydrant'];
            $buildersRisk->firestation_distance = $data['distanceToNearestFireStation'];
            $buildersRisk->save();


            if($statusConstruction == "New Construction")
            {
                $newContruction = NewContruction::getNewConstructionData($buildersRiskId);
                $oldNewConstruction = NewContruction::getNewConstructionData($buildersRiskId);
                $renovationationDelete = Rennovation::getRennovationData($buildersRiskId);
                if($newContruction){
                    $newContruction->description_operation = $data['operationDescription'];
                    $newContruction->save();

                }else{
                    $newContruction = new NewContruction();
                    $newContruction->builders_risk_id = $buildersRiskId;
                    $newContruction->description_operation = $data['operationDescription'];
                    $newContruction->save();

                }
                if($renovationationDelete){
                    $renovationationDelete->delete();
                }


            }elseif($statusConstruction == "Renovation"){
                $renovation = Rennovation::getRennovationData($buildersRiskId);
                $oldRenovation = Rennovation::getRennovationData($buildersRiskId);
                $newContructionDelete = NewContruction::getNewConstructionData($buildersRiskId);
                if($renovation){
                    $renovation->description = $data['propertyDescription'];
                    $renovation->last_update_roofing = $data['roofingUpdateYear'];
                    $renovation->last_update_heating = $data['heatingUpdateYear'];
                    $renovation->last_update_plumbing = $data['plumbingUpdateYear'];
                    $renovation->last_update_electrical = $data['electricalUpdateYear'];
                    $renovation->stucture_occupied = $data['structureOccupiedDuringRemodelRenovation'];
                    $renovation->structure_built = $data['whenWasTheStructureBuilt'];
                    $renovation->description_operation = $data['descriptionOfOperationsForTheProject'];
                    $renovation->save();
                }else{
                    $renovation = new Rennovation();
                    $renovation->builders_risk_id = $buildersRiskId;
                    $renovation->description = $data['propertyDescription'];
                    $renovation->last_update_roofing = $data['roofingUpdateYear'];
                    $renovation->last_update_heating = $data['heatingUpdateYear'];
                    $renovation->last_update_plumbing = $data['plumbingUpdateYear'];
                    $renovation->last_update_electrical = $data['electricalUpdateYear'];
                    $renovation->stucture_occupied = $data['structureOccupiedDuringRemodelRenovation'];
                    $renovation->structure_built = $data['whenWasTheStructureBuilt'];
                    $renovation->description_operation = $data['descriptionOfOperationsForTheProject'];
                    $renovation->save();
                    if($newContructionDelete){
                        $newContructionDelete->delete();
                    }
                }
                if($newContructionDelete){
                    $newContructionDelete->delete();
                }

            }

            $expirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 6);
            $oldExpirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 6);
            $expirationBuildersRisk->prior_carrier = $data['priorCarrier'];
            $expirationBuildersRisk->save();

            $oldHaveLoss = [];
            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 6);
                $oldHaveLoss = HaveLoss::getHaveLossbyLeadIdProduct($id, 6);
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }

            $changes = [
                //builders risk data
                'propertyAddress' => $oldBuildersRisk->property_address ? $oldBuildersRisk->property_address : '',
                'valueOfExistingStructure' => $oldBuildersRisk->value_of_structure ? $oldBuildersRisk->value_of_structure : '',
                'valueOfWorkBeingPerformed' => $oldBuildersRisk->value_of_work ? $oldBuildersRisk->value_of_work : '',
                'porjectStarted' => [
                   'value' => $oldBuildersRisk->has_project_started == 1 ? 'Yes' : 'No',
                   'label' => $oldBuildersRisk->has_project_started == 1 ? 'Yes' : 'No',
                ],
               'dateProjectStarted' => $oldBuildersRisk->project_started_date,
               'newConstructionRenovation' => [
                  'value' => $oldBuildersRisk->construction_status == 1 ? 'New Construction' : 'Renovation',
                  'label' => $oldBuildersRisk->construction_status == 1 ? 'New Construction' : 'Renovation',
                ],

                 //new construction data
                'operationDescription' => $oldNewConstruction ? $oldNewConstruction->description_operation : '',

                //renovation data
                'propertyDescription' => $oldRenovation->description ? $oldRenovation->description : '',
                'roofingUpdateYear' => $oldRenovation->last_update_roofing ? $oldRenovation->last_update_roofing : '',
                'heatingUpdateYear' => $oldRenovation->last_update_heating ? $oldRenovation->last_update_heating : '',
                'plumbingUpdateYear' => $oldRenovation->last_update_plumbing  ? $oldRenovation->last_update_plumbing : '',
                'electricalUpdateYear' => $oldRenovation->last_update_electrical ? $oldRenovation->last_update_electrical : '',
                'structureOccupiedDuringRemodelRenovation' => $oldRenovation->stucture_occupied ? $oldRenovation->stucture_occupied : '',
                'whenWasTheStructureBuilt' => $oldRenovation->structure_built ? $oldRenovation->structure_built : '',
                'descriptionOfOperationsForTheProject' => $oldRenovation->description_operation ? $oldRenovation->description_operation : '',


               //builders risk data
               'constructionType' =>[
                 'value' => $oldBuildersRisk->construction_type ? $oldBuildersRisk->construction_type : '',
                 'label' => $oldBuildersRisk->construction_type ? $oldBuildersRisk->construction_type : '',
               ],
              'protectionClass' => [
                 'value' => $oldBuildersRisk->protection_class ? $oldBuildersRisk->protection_class : '',
                 'label' => $oldBuildersRisk->protection_class ? $oldBuildersRisk->protection_class : '',
               ],
              'squareFootage' => $oldBuildersRisk->square_footage ? $oldBuildersRisk->square_footage : '',
              'numberOfFloors' => $oldBuildersRisk->number_floors ? $oldBuildersRisk->number_floors : '',
              'numberOfUnitsDwelling' => $oldBuildersRisk->number_dwelling ?  $oldBuildersRisk->number_dwelling : '',
              'jobSiteSecurity' => [
                 'value' => $oldBuildersRisk->jobsite_security ? $oldBuildersRisk->jobsite_security : '',
                 'label' => $oldBuildersRisk->jobsite_security ? $oldBuildersRisk->jobsite_security : '',
               ],
              'distanceToNearestFireHydrant' => $oldBuildersRisk->firehydrant_distance ? $oldBuildersRisk->firehydrant_distance : '',
              'distanceToNearestFireStation' => $oldBuildersRisk->firestation_distance ? $oldBuildersRisk->firestation_distance : '',

              //form functionality
              'isEditing' => false,
              'isUpdate' => true,

              //expirration data
              'expirationOfIM' => $oldExpirationBuildersRisk->expiration_date ? $oldExpirationBuildersRisk->expiration_date : '',
              'priorCarrier' => $oldExpirationBuildersRisk->prior_carrier ? $oldExpirationBuildersRisk->prior_carrier : '',
              //have loss data
             'isHaveLossChecked' => $oldHaveLoss ? true : false,
             'dateOfClaim' => $oldHaveLoss ? $oldHaveLoss->date_of_claim : '',
             'lossAmount' => $oldHaveLoss ? $oldHaveLoss->loss_amount : '',
            ];

            if(count($changes) > 0){
                event (new UpdateGeneralInformationEvent($id, $userProfileId, $changes, now(), 'builders-risk-update'));
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::info("Error for Builders Risk", [$e->getMessage()]);
            return $this->sendError('Error in saving Builders Risk', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $generalInformation = GeneralInformation::where('leads_id', $id)->first();
        $buildersRisk = BuildersRisk::where('general_information_id', $generalInformation->id)->first();
        $newConstruction = NewContruction::where('builders_risk_id', $buildersRisk->id)->first();
        $renovation = Rennovation::where('builders_risk_id', $buildersRisk->id)->first();
        $newConstructionData = $newConstruction ? $newConstruction : [];
        $renovationData = $renovation ? $renovation : [];
        $haveLoss = HaveLoss::getHaveLossbyLeadIdProduct($id, 6);
        $expirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 6);
        $data = [
            //builders risk data
            'propertyAddress' => $buildersRisk->property_address ? $buildersRisk->property_address : '',
            'valueOfExistingStructure' => $buildersRisk->value_of_structure ? $buildersRisk->value_of_structure : '',
            'valueOfWorkBeingPerformed' => $buildersRisk->value_of_work ? $buildersRisk->value_of_work : '',
            'porjectStarted' => [
                'value' => $buildersRisk->has_project_started == 1 ? 'Yes' : 'No',
                'label' => $buildersRisk->has_project_started == 1 ? 'Yes' : 'No',
            ],
            'dateProjectStarted' => $buildersRisk->project_started_date,
            'newConstructionRenovation' => [
                'value' => $buildersRisk->construction_status == 1 ? 'New Construction' : 'Renovation',
                'label' => $buildersRisk->construction_status == 1 ? 'New Construction' : 'Renovation',
            ],

            //new construction data
            'operationDescription' => $newConstructionData ? $newConstructionData->description_operation : '',

            //renovation data
            'propertyDescription' => $renovation->description ? $renovation->description : '',
            'roofingUpdateYear' => $renovation->last_update_roofing ? $renovation->last_update_roofing : '',
            'heatingUpdateYear' => $renovation->last_update_heating ? $renovation->last_update_heating : '',
            'plumbingUpdateYear' => $renovation->last_update_plumbing  ? $renovation->last_update_plumbing : '',
            'electricalUpdateYear' => $renovation->last_update_electrical ? $renovation->last_update_electrical : '',
            'structureOccupiedDuringRemodelRenovation' => $renovation->stucture_occupied ? $renovation->stucture_occupied : '',
            'whenWasTheStructureBuilt' => $renovation->structure_built ? $renovation->structure_built : '',
            'descriptionOfOperationsForTheProject' => $renovation->description_operation ? $renovation->description_operation : '',

            //builders risk data
            'constructionType' =>[
                'value' => $buildersRisk->construction_type ? $buildersRisk->construction_type : '',
                'label' => $buildersRisk->construction_type ? $buildersRisk->construction_type : '',
            ],
            'protectionClass' => [
                'value' => $buildersRisk->protection_class ? $buildersRisk->protection_class : '',
                'label' => $buildersRisk->protection_class ? $buildersRisk->protection_class : '',
            ],
            'squareFootage' => $buildersRisk->square_footage ? $buildersRisk->square_footage : '',
            'numberOfFloors' => $buildersRisk->number_floors ? $buildersRisk->number_floors : '',
            'numberOfUnitsDwelling' => $buildersRisk->number_dwelling ? $buildersRisk->number_dwelling : '',
            'jobSiteSecurity' => [
                'value' => $buildersRisk->jobsite_security ? $buildersRisk->jobsite_security : '',
                'label' => $buildersRisk->jobsite_security ? $buildersRisk->jobsite_security : '',
            ],
            'distanceToNearestFireHydrant' => $buildersRisk->firehydrant_distance ? $buildersRisk->firehydrant_distance : '',
            'distanceToNearestFireStation' => $buildersRisk->firestation_distance ? $buildersRisk->firestation_distance : '',

            //form functionality
            'isEditing' => false,
            'isUpdate' => true,

            //expirration data
            'expirationOfIM' => $expirationBuildersRisk->expiration_date ? $expirationBuildersRisk->expiration_date : '',
            'priorCarrier' => $expirationBuildersRisk->prior_carrier ? $expirationBuildersRisk->prior_carrier : '',

            //have loss data
            'isHaveLossChecked' => $haveLoss ? true : false,
            'dateOfClaim' => $haveLoss ? $haveLoss->date_of_claim : '',
            'lossAmount' => $haveLoss ? $haveLoss->loss_amount : '',

        ];
        Log::info("Data for Builders Risk", [$data]);
        return response()->json(['data' => $data, 'Builders Risk Retrieved successfully']);
    }

    public function getPreviousBuildersRiskInformation($id)
    {
        $leadHistory = LeadHistory::find($id);
        $changes = json_decode($leadHistory->changes, true);
        return response()->json(['data' => $changes, 'Previous Builders Risk Information Retrieved successfully']);
    }

}
