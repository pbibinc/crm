<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BusinessOwnersPolicy;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use App\Models\LeadHistory;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
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

             //code for saving the quote information
             $quoteProduct = new QuotationProduct();
             $leadId = $data['leadId'];
             $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
             if($quoteInformation){
                 $quoteProduct->quote_information_id = $quoteInformation->id;
             }
             $quoteProduct->product = 'Business Owners';
             $quoteProduct->status = 7;
             $quoteProduct->save();


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
            $userProfileId = $data['userProfileId'];
            $oldBusinessOwnersPolicy = BusinessOwnersPolicy::getBusinessOwnersPolicyData($generalInformationId);
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
            $oldExpirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 7);
            $expirationBuildersRisk->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expirationBuildersRisk->prior_carrier = $data['priorCarrier'];
            $expirationBuildersRisk->save();
            $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
            $oldHaveLoss =  HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
            if($data['isHaveLossChecked'] == true){
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }elseif($data['isHaveLossChecked'] == false)
            {
                if($HaveLosstable){
                    $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
                    $HaveLosstable->delete();
                }
            }
            $changes = [
                //business owners policy data
                'propertyAddress' => $oldBusinessOwnersPolicy->property_address,
                'lossPayeeInformation' => $oldBusinessOwnersPolicy->loss_payee_information,
                'buildingIndustry' => [
                    'value' => $oldBusinessOwnersPolicy->building_industry,
                    'label' => $oldBusinessOwnersPolicy->building_industry
                ],
                'occupancy' => [
                    'value' => $oldBusinessOwnersPolicy->occupancy,
                    'label' => $oldBusinessOwnersPolicy->occupancy
                ],
                'costOfBuilding' => $oldBusinessOwnersPolicy->building_cost,
                'buildingPropertyLimit' => $oldBusinessOwnersPolicy->business_property_limit,
                'buildingConstructionType' => [
                    'value' => $oldBusinessOwnersPolicy->building_construction_type,
                    'label' => $oldBusinessOwnersPolicy->building_construction_type
                ],
                'yearBuilt' => $oldBusinessOwnersPolicy->year_built,
                'squareFootage' => $oldBusinessOwnersPolicy->square_footage,
                'numberOfFloors' => $oldBusinessOwnersPolicy->floor_number,
                'automaticSprinklerSystem' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_sprinkler_system,
                    'label' => $oldBusinessOwnersPolicy->automatic_sprinkler_system
                ],
                'automaticFireAlarm' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_fire_alarm,
                    'label' => $oldBusinessOwnersPolicy->automatic_fire_alarm
                ],
                'distanceToNearestFireHydrant' => $oldBusinessOwnersPolicy->nereast_fire_hydrant,
                'distanceToNearestFireStation' => $oldBusinessOwnersPolicy->nearest_fire_station,
                'automaticCommercialCookingExtinguishingSystem' =>[
                    'value' => $oldBusinessOwnersPolicy->commercial_coocking_system,
                    'label' => $oldBusinessOwnersPolicy->commercial_coocking_system
                ],
                'automaticBurglarAlarm' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_bulgar_alarm,
                    'label' => $oldBusinessOwnersPolicy->automatic_bulgar_alarm
                ],
                'securityCamera' => [
                    'value' => $oldBusinessOwnersPolicy->security_camera,
                    'label' => $oldBusinessOwnersPolicy->security_camera
                ],
                'lastUpdateRoofingYear' => $oldBusinessOwnersPolicy->last_update_roofing,
                'lastUpdateHeatingYear' => $oldBusinessOwnersPolicy->last_update_heating,
                'lastUpdatePlumbingYear' => $oldBusinessOwnersPolicy->last_update_plumbing,
                'lastUpdateElectricalYear' => $oldBusinessOwnersPolicy->last_update_electrical,
                'amountOfBusinessOwnersPolicy' => $oldBusinessOwnersPolicy->amount_policy,

                //form function
                'isEditing' => false,
                'isUpdate' => true,

                //expiration of IM
                'expirationOfIM' => $oldExpirationBuildersRisk->expiration_date,
                'priorCarrier' => $oldExpirationBuildersRisk->prior_carrier,

                //have loss
                'isHaveLossChecked' => $oldHaveLoss ? true : false,
                'dateOfClaim' => $oldHaveLoss ? $oldHaveLoss->date_of_claim : null,
                'lossAmount' => $oldHaveLoss ? $oldHaveLoss->loss_amount : null

            ];
            if(count($changes) > 0){
                event(new UpdateGeneralInformationEvent($id, $userProfileId, $changes, now(), 'business-owners-policy-update'));
            }
            DB::commit();
        }catch(\Exception $e){
            Log::info("Error for Updating Business Owners Policy Data", ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage());
        }

    }

    public function edit($id)
    {
        try{
            $generalInformationId = GeneralInformation::getIdByLeadId($id);
            $oldBusinessOwnersPolicy = BusinessOwnersPolicy::getBusinessOwnersPolicyData($generalInformationId);
            $expirationBuildersRisk = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 7);
            $haveLoss = HaveLoss::getHaveLossbyLeadIdProduct($id, 7);
            $businessOwnersPolicyData = [
                //business owners policy data
                'propertyAddress' => $oldBusinessOwnersPolicy->property_address,
                'lossPayeeInformation' => $oldBusinessOwnersPolicy->loss_payee_information,
                'buildingIndustry' => [
                    'value' => $oldBusinessOwnersPolicy->building_industry,
                    'label' => $oldBusinessOwnersPolicy->building_industry
                ],
                'occupancy' => [
                    'value' => $oldBusinessOwnersPolicy->occupancy,
                    'label' => $oldBusinessOwnersPolicy->occupancy
                ],
                'costOfBuilding' => $oldBusinessOwnersPolicy->building_cost,
                'buildingPropertyLimit' => $oldBusinessOwnersPolicy->business_property_limit,
                'buildingConstructionType' => [
                    'value' => $oldBusinessOwnersPolicy->building_construction_type,
                    'label' => $oldBusinessOwnersPolicy->building_construction_type
                ],
                'yearBuilt' => $oldBusinessOwnersPolicy->year_built,
                'squareFootage' => $oldBusinessOwnersPolicy->square_footage,
                'numberOfFloors' => $oldBusinessOwnersPolicy->floor_number,
                'automaticSprinklerSystem' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_sprinkler_system,
                    'label' => $oldBusinessOwnersPolicy->automatic_sprinkler_system
                ],
                'automaticFireAlarm' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_fire_alarm,
                    'label' => $oldBusinessOwnersPolicy->automatic_fire_alarm
                ],
                'distanceToNearestFireHydrant' => $oldBusinessOwnersPolicy->nereast_fire_hydrant,
                'distanceToNearestFireStation' => $oldBusinessOwnersPolicy->nearest_fire_station,
                'automaticCommercialCookingExtinguishingSystem' =>[
                    'value' => $oldBusinessOwnersPolicy->commercial_coocking_system,
                    'label' => $oldBusinessOwnersPolicy->commercial_coocking_system
                ],
                'automaticBurglarAlarm' => [
                    'value' => $oldBusinessOwnersPolicy->automatic_bulgar_alarm,
                    'label' => $oldBusinessOwnersPolicy->automatic_bulgar_alarm
                ],
                'securityCamera' => [
                    'value' => $oldBusinessOwnersPolicy->security_camera,
                    'label' => $oldBusinessOwnersPolicy->security_camera
                ],
                'lastUpdateRoofingYear' => $oldBusinessOwnersPolicy->last_update_roofing,
                'lastUpdateHeatingYear' => $oldBusinessOwnersPolicy->last_update_heating,
                'lastUpdatePlumbingYear' => $oldBusinessOwnersPolicy->last_update_plumbing,
                'lastUpdateElectricalYear' => $oldBusinessOwnersPolicy->last_update_electrical,
                'amountOfBusinessOwnersPolicy' => $oldBusinessOwnersPolicy->amount_policy,

                //form function
                'isEditing' => false,
                'isUpdate' => true,

                //expiration of IM
                'expirationOfIM' => $expirationBuildersRisk->expiration_date,
                'priorCarrier' => $expirationBuildersRisk->prior_carrier,

                //have loss
                'isHaveLossChecked' => $haveLoss ? true : false,
                'dateOfClaim' => $haveLoss ? $haveLoss->date_of_claim : null,
                'lossAmount' => $haveLoss ? $haveLoss->loss_amount : null

            ];
            Log::info("Business Owners Policy Data Retrieved Successfully", ['businessOwnersPolicyData' => $businessOwnersPolicyData]);
            return response()->json(['data' => $businessOwnersPolicyData, 'Business Owners Policy Retrieved successfully']);
        }catch(\Exception $e){
            Log::info("Error for Editing Business Owners Policy Data", ['error' => $e->getMessage()]);
            return $this->sendError($e->getMessage());
        }
    }

    public function getPreviousBusinessOwnersPolicyInformation($id)
    {
        $leadHistory = LeadHistory::find($id);
        $changes = json_decode($leadHistory->changes, true);
        return response()->json(['data' => $changes, 'Previous Business Owners Policy Information Retrieved successfully']);
    }
}