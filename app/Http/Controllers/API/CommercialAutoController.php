<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CommercialAuto;
use App\Models\CommercialAutoSupllemental;
use App\Models\CrossSell;
use App\Models\DriverInformation;
use App\Models\DriverSpouse;
use App\Models\ExpirationProduct;
use App\Models\GeneralInformation;
use App\Models\HaveLoss;
use App\Models\VehicleInformation;
use Barryvdh\Debugbar\LaravelDebugbar;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommercialAutoController extends BaseController
{
    public function saveCommercialAuto(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            $comercialAuto = new CommercialAuto();

            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            if($generalInformationId){
                $comercialAuto->general_information_id = $generalInformationId;
                $comercialAuto->ssn = $data['ssnValue'];
                $comercialAuto->fein = $data['feinValue'];


                $comercialAuto->garage_address = $data['garage_address'];
                $comercialAuto->save();
            }else{
                return $this->sendError('General Information not found');
            }

            $vehicleInformationData = $data['vehicle_information'];

            foreach($vehicleInformationData as $dataVehicle){
                $vehicleInformation = new VehicleInformation();
                $vehicleInformation->commercial_auto_id = $comercialAuto->id;
                $vehicleInformation->year = $dataVehicle['year'];
                $vehicleInformation->make = $dataVehicle['make'];
                $vehicleInformation->model = $dataVehicle['model'];
                $vehicleInformation->vin = $dataVehicle['vin'];
                $vehicleInformation->radius_miles = $dataVehicle['radius'];
                $vehicleInformation->cost_new_vehicle = $dataVehicle['cost'];
                $vehicleInformation->save();
            }

            $driverInformation = $data['driver_information'];

            foreach($driverInformation as $driverInformationData){
                $driverInformation = new DriverInformation();
                $driverInformation->commercial_auto_id = $comercialAuto->id;
                $driverInformation->fullname = $driverInformationData['firstName'] . ' ' . $driverInformationData['lastname'];
                $driverDataDateRaw = Carbon::parse($driverInformationData['date_of_birth'])->toDateTimeString();
                $driverInformation->date_of_birth = $driverDataDateRaw;
                $driverInformation->driver_license_number = $driverInformationData['driver_license_number'];
                Log::info("Marital_status", [$driverInformationData['martial_status']['value']]);
                $driverInformation->marital_status = $driverInformationData['martial_status']['value'];

                $driverInformation->years_of_experience = $driverInformationData['years_driving_experience'];
                $driverInformation->save();

                $spouseName = $driverInformationData['spouse_name'] ?? null;
                if(!is_null($spouseName) && !empty($spouseName)){
                    $spouseInformation = new DriverSpouse();
                    $spouseInformation->driver_information_id = $driverInformation->id;
                    $spouseInformation->spouse_fullname = $spouseName;
                    $spouseInformation->save();
                }
            }

            $supplementalQuestionare = new CommercialAutoSupllemental();
            $supplementalQuestionare->commercial_auto_id = $comercialAuto->id;
            $supplementalQuestionare->vehicle_maintenance_program = $data['vehicle_maintenance_program'];
            $supplementalQuestionare->vehicle_maintenace_description = $data['vehicle_maintenace_description'] ?? "";
            $supplementalQuestionare->is_vehicle_customized = $data['is_vehicle_customized'];
            $supplementalQuestionare->vehicle_customized_description = $data['vehicle_customized_description'] ?? "";
            $supplementalQuestionare->is_vehicle_owned_by_prospect = $data['is_vehicle_owned_by_prospect'];
            $supplementalQuestionare->declined_canceled_nonrenew_policy = $data['declined_canceled_nonrenew_policy'];
            $supplementalQuestionare->prospect_loss = $data['prospect_loss'];
            $supplementalQuestionare->vehicle_use_for_towing = $data['vehicle_use_for_towing'];
            $supplementalQuestionare->save();

            $expirationAuto = new ExpirationProduct();
            $expirationAuto->lead_id = $data['leadId'];
            $expirationAuto->product = 3;
            $expirationAuto->prior_carrier = $data['prior_carrier'];
            $expirationAuto->save();

            if($data['cross_sell']){
                $crossSell = new CrossSell();
                $crossSell->lead_id = $data['leadId'];
                $crossSell->product = 3;
                $crossSell->cross_sell = $data['cross_sell']['value'];
                $crossSell->save();
            }

            if($data['have_loss'] == true){
                $HaveLosstable = new HaveLoss();
                $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 3;
                $HaveLosstable->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['loss_amount'];
                $HaveLosstable->save();
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Commercial Auto", [$e->getMessage()]);
            return $this->sendError('Error saving commercial auto data');
        }

    }

    public function updateCommercialAuto(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $generalInformationId = GeneralInformation::getIdByLeadId($id);
            $commercialAutoId = CommercialAuto::getIdbyGeneralInformationId($generalInformationId);
            $commercialAuto = CommercialAuto::getCommercialAuto($commercialAutoId);

            if($commercialAuto){
                $commercialAuto->general_information_id = $generalInformationId;
                $commercialAuto->fein = $data['feinValue'];
                $commercialAuto->ssn = $data['ssnValue'];
                $commercialAuto->garage_address = $data['garage_address'];
                $commercialAuto->save();
            }else{
                return $this->sendError('General Information not found');
            }

            $vehicleInformation = VehicleInformation::getVehicleInformation($commercialAutoId);

            $vehicleInformationData = $data['vehicle_information'];

            if($vehicleInformation){
                $vehicleInformaionDataDelete = $vehicleInformation->each->delete();
                if($vehicleInformaionDataDelete){
                    foreach($vehicleInformationData as $dataVehicle){
                        $vehicleInformationModel = new VehicleInformation();
                        $vehicleInformationModel->commercial_auto_id = $commercialAutoId;
                        $vehicleInformationModel->year = $dataVehicle['year'];
                        $vehicleInformationModel->make = $dataVehicle['make'];
                        $vehicleInformationModel->model = $dataVehicle['model'];
                        $vehicleInformationModel->vin = $dataVehicle['vin'];
                        $vehicleInformationModel->radius_miles = $dataVehicle['radius'];
                        $vehicleInformationModel->cost_new_vehicle = $dataVehicle['cost'];
                        $vehicleInformationModel->save();
                    }
                }
            }

            $driverInformation = DriverInformation::getDriverInformation($commercialAutoId);
            $driverInformationId = $driverInformation->pluck('id')->toArray();

            $driverSpouses = DriverSpouse::whereIn('driver_information_id', $driverInformationId)->get();


            if($driverInformation){
                $driverSpouseDelete = $driverSpouses->each->delete();
                $driverInformationDelete = $driverInformation->each->delete();
                if($driverInformationDelete){
                    $driverInformation = $data['driver_information'];

                    foreach($driverInformation as $driverInformationData){
                        $driverInformation = new DriverInformation();
                        $driverInformation->commercial_auto_id = $commercialAutoId;
                        $driverInformation->fullname = $driverInformationData['firstName'] . ' ' . $driverInformationData['lastname'];
                        $driverDataDateRaw = Carbon::parse($driverInformationData['date_of_birth'])->toDateTimeString();
                        $driverInformation->date_of_birth = $driverDataDateRaw;
                        $driverInformation->driver_license_number = $driverInformationData['driver_license_number'];
                        $driverInformation->marital_status = $driverInformationData['martial_status']['value'];
                        $driverInformation->years_of_experience = $driverInformationData['years_driving_experience'];
                        $driverInformation->save();

                        $spouseName = $driverInformationData['spouse_name'] ?? null;
                        if(!is_null($spouseName) && !empty($spouseName)){
                            $spouseInformation = new DriverSpouse();
                            $spouseInformation->driver_information_id = $driverInformation->id;
                            $spouseInformation->spouse_fullname = $spouseName;
                            $spouseInformation->save();
                        }
                    }
                }
            }

            $supplementalQuestionare = CommercialAutoSupllemental::getCommercialSupplementalAuto($commercialAutoId);
            $supplementalQuestionare->commercial_auto_id = $commercialAutoId;
            $supplementalQuestionare->vehicle_maintenance_program = $data['vehicle_maintenance_program'];
            $supplementalQuestionare->vehicle_maintenace_description = $data['vehicle_maintenance_program'] ?  $data['vehicle_maintenace_description'] : "";
            $supplementalQuestionare->is_vehicle_customized = $data['is_vehicle_customized'];
            $supplementalQuestionare->vehicle_customized_description = $data['is_vehicle_customized'] ? $data['vehicle_customized_description'] : "";
            $supplementalQuestionare->is_vehicle_owned_by_prospect = $data['is_vehicle_owned_by_prospect'];
            $supplementalQuestionare->declined_canceled_nonrenew_policy = $data['declined_canceled_nonrenew_policy'];
            $supplementalQuestionare->prospect_loss = $data['prospect_loss'];
            $supplementalQuestionare->vehicle_use_for_towing = $data['vehicle_use_for_towing'];
            $supplementalQuestionare->save();

            $expirationAuto = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 3);
            $expirationAuto->lead_id = $data['leadId'];
            $expirationAuto->product = 3;
            $expirationAuto->prior_carrier = $data['prior_carrier'];
            $expirationAuto->save();

            if($data['cross_sell']){
                $crossSell = CrossSell::getCrossSelByLeadIdProduct($id, 3);
                $crossSell->cross_sell = $data['cross_sell']['value'];
                $crossSell->save();
            }

            if($data['have_loss'] == true){
                $HaveLosstable = HaveLoss::getHaveLossbyLeadIdProduct($id, 3);
                if($HaveLosstable){
                    $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 3;
                $HaveLosstable->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['loss_amount'];
                $HaveLosstable->save();
                }else{
                    $haveLoss = new HaveLoss();
                    $haveLoss->lead_id = $data['leadId'];
                    $haveLoss->product = 3;
                    $haveLoss->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateTimeString();
                    $haveLoss->loss_amount = $data['loss_amount'];
                    $haveLoss->save();
                }

            }

            DB::commit();
        }catch(\Exception $e){
            Log::info("Error for Commercial Auto", [$e->getMessage()]);
            return $this->sendError('Error saving commercial auto data');
        }

    }
}
