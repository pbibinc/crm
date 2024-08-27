<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
use App\Http\Controllers\Controller;
use App\Models\CrossSell;
use App\Models\EquipmentInformation;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use App\Models\LeadHistory;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\ToolsEquipment;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ToolsEquipmentController extends Controller
{
    //
    public function storeToolsEquipment (Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            $toolsEquipment = new ToolsEquipment();
            $toolsEquipment->general_information_id = $generalInformationId;
            $toolsEquipment->misc_tools_amount = $data['miscellaneousTools'];
            $toolsEquipment->rented_less_equipment = $data['rentedLeasedEquipment'];
            $toolsEquipment->scheduled_equipment = $data['scheduledEquipment'];
            $toolsEquipment->deductible_amount = $data['deductibleAmount'];
            $toolsEquipment->save();

            foreach($data['allEquipmentInformation'] as $equipmentInformation){
                $equipmentInformationModel = new EquipmentInformation();
                $equipmentInformationModel->tools_equipment_id = $toolsEquipment->id;
                $equipmentInformationModel->equipment_type = $equipmentInformation['equipmentType']['value'];
                $equipmentInformationModel->equipment = $equipmentInformation['equipment']['value'];
                $equipmentInformationModel->year = $equipmentInformation['year'];
                $equipmentInformationModel->make = $equipmentInformation['make'];
                $equipmentInformationModel->model = $equipmentInformation['model'];
                $equipmentInformationModel->serial_identification_no = $equipmentInformation['serialNo'];
                $equipmentInformationModel->value = $equipmentInformation['value'];
                $equipmentInformationModel->year_acquired = $equipmentInformation['yearAcquired'];
                $equipmentInformationModel->save();
            }
            //code for saving the quote information
            $quoteProduct = new QuotationProduct();
            $leadId = $data['leadId'];
            $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
            if($quoteInformation){
                $quoteProduct->quote_information_id = $quoteInformation->id;
            }
            $quoteProduct->product = 'Tools Equipment';
            $quoteProduct->status = 7;
            $quoteProduct->save();

            $expirationAuto = new ExpirationProduct();
            $expirationAuto->lead_id = $data['leadId'];
            $expirationAuto->product = 5;
            $expirationAuto->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expirationAuto->prior_carrier = $data['priorCarrier'];
            $expirationAuto->save();

            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = new HaveLoss();
                $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 5;
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
            }

            // if($data['crossSell']){
            //     $crossSell = new CrossSell();
            //     $crossSell->lead_id = $data['leadId'];
            //     $crossSell->product = 5;
            //     $crossSell->cross_sell = $data['crossSell']['value'];
            //     $crossSell->save();
            // }

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Tools and Equipement:",  [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function updateToolsEquipment(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $generalInformationId = GeneralInformation::getIdByLeadId($id);
            $toolsEquipmentId = ToolsEquipment::getIdByGeneralInformationId($generalInformationId);
            $toolsEquipment = ToolsEquipment::getToolsEquipment($toolsEquipmentId);
            $oldToolEquipment = $toolsEquipment->replicate();
            $toolsEquipment->misc_tools_amount = $data['miscellaneousTools'];
            $toolsEquipment->rented_less_equipment = $data['rentedLeasedEquipment'];
            $toolsEquipment->scheduled_equipment = $data['scheduledEquipment'];
            $toolsEquipment->deductible_amount = $data['deductibleAmount'];
            $toolsEquipment->save();

            $equipmentInformationModel = EquipmentInformation::where('tools_equipment_id', $toolsEquipmentId)->get();
            $oldEquipInformationModel = $equipmentInformationModel->toArray();
            $equipmentDataDelete = $equipmentInformationModel->each->delete();
            if($equipmentDataDelete){
                foreach($data['allEquipmentInformation'] as $equipmentInformation){
                    $newEquipmentInformationModel = new EquipmentInformation();
                    $newEquipmentInformationModel->tools_equipment_id = $toolsEquipmentId;
                    $newEquipmentInformationModel->equipment_type = $equipmentInformation['equipmentType']['value'];
                    $newEquipmentInformationModel->equipment = $equipmentInformation['equipment']['value'];
                    $newEquipmentInformationModel->year = $equipmentInformation['year'];
                    $newEquipmentInformationModel->make = $equipmentInformation['make'];
                    $newEquipmentInformationModel->model = $equipmentInformation['model'];
                    $newEquipmentInformationModel->serial_identification_no = $equipmentInformation['serialNo'];
                    $newEquipmentInformationModel->value = $equipmentInformation['value'];
                    $newEquipmentInformationModel->year_acquired = $equipmentInformation['yearAcquired'];
                    $newEquipmentInformationModel->save();
                }
            }

            $expirationAuto = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 5);
            $oldExpirationProduct = $expirationAuto;
            $expirationAuto->expiration_date = Carbon::parse($data['expirationOfIM'])->toDateString();
            $expirationAuto->prior_carrier = $data['priorCarrier'];
            $expirationAuto->save();

            if($data['isHaveLossChecked'] == true){
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 5);
                if($HaveLosstable){
                $HaveLosstable->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['lossAmount'];
                $HaveLosstable->save();
                }else{
                    $haveLoss = new HaveLoss();
                    $haveLoss->lead_id = $data['leadId'];
                    $haveLoss->product = 5;
                    $haveLoss->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateTimeString();
                    $haveLoss->loss_amount = $data['lossAmount'];
                    $haveLoss->save();
                }

            }else{
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 5);
                if($HaveLosstable){
                    $HaveLosstable->delete();
                }
            }

            if($data['crossSell']){
                $crossSell = CrossSell::getCrossSelByLeadIdProduct($id, 5);
                $crossSell->cross_sell = $data['crossSell']['value'];
                $crossSell->save();
            }
            $firstEquipmentInformation = $oldEquipInformationModel ? array_shift($oldEquipInformationModel) : [];
            $firstEquipmentInformationData = [
                'equipment' => [
                    'value' => $firstEquipmentInformation['equipment'],
                    'label' => $firstEquipmentInformation['equipment']
                ],
                'year' => $firstEquipmentInformation['year'],
                'make' => $firstEquipmentInformation['make'],
                'model' => $firstEquipmentInformation['model'],
                'serialNo' => $firstEquipmentInformation['serial_identification_no'],
                'value' => $firstEquipmentInformation['value'],
                'yearAcquired' => $firstEquipmentInformation['year_acquired'],
            ];

            $otherEquipmentInformation = array_map(function ($equipment) {
                return [
                    'equipment' => [
                        'value' => $equipment['equipment'],
                        'label' => $equipment['equipment']
                    ],
                    'year' => $equipment['year'],
                    'make' => $equipment['make'],
                    'model' => $equipment['model'],
                    'serialNo' => $equipment['serial_identification_no'],
                    'value' => $equipment['value'],
                    'yearAcquired' => $equipment['year_acquired'],
                ];
            }, $oldEquipInformationModel);

            $typeOfEquipment = array_map(function ($type) {
                return [
                    'value' => (int)$type['equipment_type'],
                    'label' => $type['equipment_type'] == 1 ? 'Light/Medium Equipment' : 'Heavy Equipment'
                ];
            }, $oldEquipInformationModel);

            $changes = [
                'miscellaneousTools' => $oldToolEquipment->misc_tools_amount,
                'rentedLeasedEquipment' => $oldToolEquipment->rented_less_equipment,
                'scheduledEquipment' => $oldToolEquipment->scheduled_equipment,
                'deductibleAmount' => [
                    'value' => $oldToolEquipment->deductible_amount,
                    'label' => $oldToolEquipment->deductible_amount
                ],
                'firstEquipmentInformation' => $firstEquipmentInformationData,
                'equipmentInformation' => $otherEquipmentInformation,
                'fixedTypeOfEquipment' => [
                    'value' => (int)$firstEquipmentInformation['equipment_type'],
                    'label' => $firstEquipmentInformation['equipment_type'] == 1 ? 'Light/Medium Equipment' : 'Heavy Equipment'
                ],
                'typeOfEquipment' => $typeOfEquipment,
                'isEditing' => false,
                'isUpdate' => true,
                'expirationOfIM' => $oldExpirationProduct->expiration_date,
                'priorCarrier' => $oldExpirationProduct->prior_carrier,
            ];
            if(count($changes)){
                event(new UpdateGeneralInformationEvent($id, $data['userProfileId'], $changes, now(), 'tools-equipment-update'));
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Tools and Equipement:",  [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function edit($id)
    {
        $generalInformation = GeneralInformation::where('leads_id', $id)->first();
        $toolsEquipment = ToolsEquipment::where('general_information_id', $generalInformation->id)->first();
        $equipmentInformationData = EquipmentInformation::where('tools_equipment_id', $toolsEquipment->id)->get();
        $firstEquipmentInformation = $equipmentInformationData->first();
        $otherEquipmentInformation = $equipmentInformationData->slice(1);
        $otherEquipmentInformationData = [];
        $typeOfEquipment = [];
        $expirationProduct = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 5);
        if ($firstEquipmentInformation) {
            $firstEquipmentInformationData = [
                'equipment' => [
                    'value' => $firstEquipmentInformation->equipment,
                    'label' => $firstEquipmentInformation->equipment
                ],
                'year' => $firstEquipmentInformation->year,
                'make' => $firstEquipmentInformation->make,
                'model' => $firstEquipmentInformation->model,
                'serialNo' => $firstEquipmentInformation->serial_identification_no,
                'value' => $firstEquipmentInformation->value,
                'yearAcquired' => $firstEquipmentInformation->year_acquired,
            ];
        } else {
            // Handle the case where there is no equipment information
            $firstEquipmentInformation = [];
        }
        if($otherEquipmentInformation){
            $typeOfEquipment = $otherEquipmentInformation->map(function($type){
                return [
                    'value' => (int)$type->equipment_type,
                    'label' => $type->equipment_type == 1 ? 'Light/Medium Equipment' : 'Heavy Equipment'
                ];
            })->values()->all();
            $otherEquipmentInformationData = $otherEquipmentInformation->map(function($equipment){
                return [
                    'equipment' => [
                        'value' => $equipment->equipment,
                        'label' => $equipment->equipment
                    ],
                    'year' => $equipment->year,
                    'make' => $equipment->make,
                    'model' => $equipment->model,
                    'serialNo' => $equipment->serial_identification_no,
                    'value' => $equipment->value,
                    'yearAcquired' => $equipment->year_acquired,

                ];
            })->values()->all();
        }else{
            $otherEquipmentInformation = [];
            $typeOfEquipment = [];
        }
        $data = [

            'miscellaneousTools' => $toolsEquipment->misc_tools_amount,
            'rentedLeasedEquipment' => $toolsEquipment->rented_less_equipment,
            'scheduledEquipment' => $toolsEquipment->scheduled_equipment,
            'deductibleAmount' => [
                'value' => $toolsEquipment->deductible_amount,
                'label' => $toolsEquipment->deductible_amount
            ],

            'firstEquipmentInformation' => $firstEquipmentInformationData,
            'fixedTypeOfEquipment' =>[
                'value' => (int)$firstEquipmentInformation->equipment_type,
                'label' => $firstEquipmentInformation->equipment_type == 1 ? 'Light/Medium Equipment' : 'Heavy Equipment'
            ],
            'equipmentInformation' => $otherEquipmentInformationData,
            'typeOfEquipment' => $typeOfEquipment,

            //common information
            'isEditing' => false,
            'isUpdate' => true,

            //prior carrier and date
            'expirationOfIM' => $expirationProduct->expiration_date,
            'priorCarrier' => $expirationProduct->prior_carrier,

        ];
        return response()->json(['data' => $data, 'Commercial Auto Retrieved successfully']);
    }

    public function getPreviousToolsEquipmentInformation($id)
    {
        $leadHistroy = LeadHistory::find($id);
        $changes = json_decode($leadHistroy->changes, true);
        return response()->json(['data' => $changes, 'Lead History Retrieved successfully']);
    }

}