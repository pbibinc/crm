<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CrossSell;
use App\Models\EquipmentInformation;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use App\Models\ToolsEquipment;
use Carbon\Carbon;
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
                $equipmentInformationModel->equipment = $equipmentInformation['equipment']['value'];
                $equipmentInformationModel->year = $equipmentInformation['year'];
                $equipmentInformationModel->make = $equipmentInformation['make'];
                $equipmentInformationModel->model = $equipmentInformation['model'];
                $equipmentInformationModel->serial_identification_no = $equipmentInformation['serialNo'];
                $equipmentInformationModel->value = $equipmentInformation['value'];
                $equipmentInformationModel->year_acquired = $equipmentInformation['yearAcquired'];
                $equipmentInformationModel->save();
            }

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

            if($data['crossSell']){
                $crossSell = new CrossSell();
                $crossSell->lead_id = $data['leadId'];
                $crossSell->product = 5;
                $crossSell->cross_sell = $data['crossSell']['value'];
                $crossSell->save();
            }



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
            $toolsEquipment->misc_tools_amount = $data['miscellaneousTools'];
            $toolsEquipment->rented_less_equipment = $data['rentedLeasedEquipment'];
            $toolsEquipment->scheduled_equipment = $data['scheduledEquipment'];
            $toolsEquipment->deductible_amount = $data['deductibleAmount'];
            $toolsEquipment->save();

            foreach($data['allEquipmentInformation'] as $equipmentInformation){
                $equipmentInformationModel = EquipmentInformation::getEquipmentInformation($toolsEquipmentId);
                $equipmentInformationModel->equipment = $equipmentInformation['equipment']['value'];
                $equipmentInformationModel->year = $equipmentInformation['year'];
                $equipmentInformationModel->make = $equipmentInformation['make'];
                $equipmentInformationModel->model = $equipmentInformation['model'];
                $equipmentInformationModel->serial_identification_no = $equipmentInformation['serialNo'];
                $equipmentInformationModel->value = $equipmentInformation['value'];
                $equipmentInformationModel->year_acquired = $equipmentInformation['yearAcquired'];
                $equipmentInformationModel->save();
            }

            $expirationAuto = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 5);
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

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Tools and Equipement:",  [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
}
