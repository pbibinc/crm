<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BusinessOwnersPolicy;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BusinessOwnersPolicyController extends BaseController
{
    //
    public function storeBusinessOwnersPolicy(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            $BusinessOwnersPolicy = new BusinessOwnersPolicy();
            $BusinessOwnersPolicy->general_information_id = $generalInformationId;
            $BusinessOwnersPolicy->property_address = $data['propertyAddress'];
            $BusinessOwnersPolicy->loss_payee_information = $data['lossPayeeInformation'];
            $BusinessOwnersPolicy->building_industry = $data['buildingIndustry'];
            $BusinessOwnersPolicy->occupancy = $data['occupancy'];
            $BusinessOwnersPolicy->building_cost = $data['costOfBuilding'];
            $BusinessOwnersPolicy->business_property_limit = $data['buildingPropertyLimit'];
            $BusinessOwnersPolicy->building_construction_type = $data['buildingConstructionType'];
            $BusinessOwnersPolicy->year_built = $data['yearBuilt'];
            $BusinessOwnersPolicy->square_footage = $data['squareFootage'];
            $BusinessOwnersPolicy->floor_number = $data['numberOfFloors'];
            $BusinessOwnersPolicy->automatic_sprinkler_system = $data['automaticSprinklerSystem'];
            $BusinessOwnersPolicy->automatic_fire_alarm = $data['automaticFireAlarm'];
            $BusinessOwnersPolicy->nereast_fire_hydrant = $data['distanceToNearestFireHydrant'];
            $BusinessOwnersPolicy->nearest_fire_station = $data['distanceToNearestFireStation'];
            $BusinessOwnersPolicy->commercial_coocking_system = $data['automaticCommercialCookingExtinguishingSystem'];
            $BusinessOwnersPolicy->automatic_bulgar_alarm = $data['automaticBurglarAlarm'];
            $BusinessOwnersPolicy->security_camera = $data['securityCamera'];
            $BusinessOwnersPolicy->last_update_roofing = $data['lastUpdateRoofingYear'];
            $BusinessOwnersPolicy->last_update_heating = $data['lastUpdateHeatingYear'];
            $BusinessOwnersPolicy->last_update_plumbing = $data['lastUpdatePlumbingYear'];
            $BusinessOwnersPolicy->last_update_electrical = $data['lastUpdateElectricalYear'];
            $BusinessOwnersPolicy->amount_policy = $data['amountOfBusinessOwnersPolicy'];
            $BusinessOwnersPolicy->save();

            $expiration = new ExpirationProduct();
            $expiration->lead_id = $data['leadId'];
            $expiration->product = 7;
            $expiration->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expiration->prior_carrier = $data['priorCarrier'];
            $expiration->save();

            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = new HaveLoss();
                $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 7;
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfLoss'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Saving Business Owners Policy Data", ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage());
        }

    }

    public function updateBusinessOwnersPolicy(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            $BusinessOwnersPolicy = BusinessOwnersPolicy::getBusinessOwnersPolicyData($generalInformationId);
            $BusinessOwnersPolicy->property_address = $data['propertyAddress'];
            $BusinessOwnersPolicy->loss_payee_information = $data['lossPayeeInformation'];
            $BusinessOwnersPolicy->building_industry = $data['buildingIndustry'];
            $BusinessOwnersPolicy->occupancy = $data['occupancy'];
            $BusinessOwnersPolicy->building_cost = $data['costOfBuilding'];
            $BusinessOwnersPolicy->business_property_limit = $data['buildingPropertyLimit'];
            $BusinessOwnersPolicy->building_construction_type = $data['buildingConstructionType'];
            $BusinessOwnersPolicy->year_built = $data['yearBuilt'];
            $BusinessOwnersPolicy->square_footage = $data['squareFootage'];
            $BusinessOwnersPolicy->floor_number = $data['numberOfFloors'];
            $BusinessOwnersPolicy->automatic_sprinkler_system = $data['automaticSprinklerSystem'];
            $BusinessOwnersPolicy->automatic_fire_alarm = $data['automaticFireAlarm'];
            $BusinessOwnersPolicy->nereast_fire_hydrant = $data['distanceToNearestFireHydrant'];
            $BusinessOwnersPolicy->nearest_fire_station = $data['distanceToNearestFireStation'];
            $BusinessOwnersPolicy->commercial_coocking_system = $data['automaticCommercialCookingExtinguishingSystem'];
            $BusinessOwnersPolicy->automatic_bulgar_alarm = $data['automaticBurglarAlarm'];
            $BusinessOwnersPolicy->security_camera = $data['securityCamera'];
            $BusinessOwnersPolicy->last_update_roofing = $data['lastUpdateRoofingYear'];
            $BusinessOwnersPolicy->last_update_heating = $data['lastUpdateHeatingYear'];
            $BusinessOwnersPolicy->last_update_plumbing = $data['lastUpdatePlumbingYear'];
            $BusinessOwnersPolicy->last_update_electrical = $data['lastUpdateElectricalYear'];
            $BusinessOwnersPolicy->amount_policy = $data['amountOfBusinessOwnersPolicy'];
            $BusinessOwnersPolicy->save();

            $expirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 7);
            $expirationBuildersRisk->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expirationBuildersRisk->prior_carrier = $data['priorCarrier'];
            $expirationBuildersRisk->save();

            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }elseif($data['isHaveLossChecked'] == false)
            {
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
                $HaveLosstable->delete();
            }

            DB::commit();

        }catch(\Exception $e){
            Log::info("Error for Updating Business Owners Policy Data", ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage());
        }

    }
}
