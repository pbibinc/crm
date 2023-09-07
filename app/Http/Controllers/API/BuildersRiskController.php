<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BuildersRisk;
use App\Models\GeneralInformation;
use App\Models\NewContruction;
use App\Models\Rennovation;
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

            }
            if($data['porjectStarted'] == "yes"){
                $buildersRisk->project_started_date = $data['projectStartedDate'];
            }else{
                $buildersRisk->project_started_date = null;
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
            $buildersRiskId = $buildersRisk->id;
            $buildersRisk->property_address = $data['propertyAddress'];
            $buildersRisk->value_of_structure = $data['valueOfExistingStructure'];
            $buildersRisk->value_of_work = $data['valueOfWorkBeingPerformed'];
            if($data['porjectStarted'] == "yes"){
                $buildersRisk->has_project_started = true;
            }elseif($data['porjectStarted'] == "no"){
                $buildersRisk->has_project_started = false;

            }
            if($data['porjectStarted'] == "yes"){
                $buildersRisk->project_started_date = $data['projectStartedDate'];
            }else{
                $buildersRisk->project_started_date = null;
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
                $newContruction = NewContruction::getNewContructionData($buildersRiskId);
                $newContruction->builders_risk_id = $buildersRisk->id;
                $newContruction->description_operation = $data['operationDescription'];
                $newContruction->save();
            }elseif($statusConstruction == "Renovation"){
                $renovation = Rennovation::getRennovationData($buildersRiskId);
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
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::info("Error for Builders Risk", [$e->getMessage()]);
            return $this->sendError('Error in saving Builders Risk', $e->getMessage());
        }


    }
}
