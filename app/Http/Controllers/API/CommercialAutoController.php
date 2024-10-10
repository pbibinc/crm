<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
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
use App\Models\LeadHistory;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\VehicleInformation;
use Barryvdh\Debugbar\LaravelDebugbar;
use Carbon\Carbon;
use Faker\Provider\Base;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
class CommercialAutoController extends BaseController
{
    public function saveCommercialAuto(Request $request)
    {
        try{
            $token = $request->input('token');
            if(Cache::has($token)){
                return response()->json([
                    'message' => 'Duplicate submission, please try again'
                ],422);
            }
            $token = Str::random(10);
            Cache::put($token, true, 10);
            DB::beginTransaction();
            $data = $request->all();
            $comercialAuto = new CommercialAuto();
            $generalInformationId = GeneralInformation::getIdByLeadId($data['leadId']);
            if(CommercialAuto::where('general_information_id', $generalInformationId)->exists()){
                return response()->json(['error' => 'General Liability Data has been already saved.'], 409);
            }
            if($generalInformationId){
                $comercialAuto->general_information_id = $generalInformationId;
                $comercialAuto->ssn = $data['ssnValue'];
                $comercialAuto->fein = $data['feinValue'];
                $comercialAuto->garage_address = $data['garage_address'];
                $comercialAuto->save();
            }else{
                return response()->json(['error' => 'General Information Data is not yet saved.'], 409);
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

            //code for saving the quote information
            $quoteProduct = new QuotationProduct();
            $leadId = $data['leadId'];
            $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
            if($quoteInformation){
               $quoteProduct->quote_information_id = $quoteInformation->id;
            }
            $quoteProduct->product = 'Commercial Auto';
            $quoteProduct->status = 7;
            $quoteProduct->save();

            // if($data['cross_sell']){
            //     $crossSell = new CrossSell();
            //     $crossSell->lead_id = $data['leadId'];
            //     $crossSell->product = 3;
            //     $crossSell->cross_sell = $data['cross_sell']['value'];
            //     $crossSell->save();
            // }

            if($data['have_loss'] == true){
                $HaveLosstable = new HaveLoss();
                $HaveLosstable->lead_id = $data['leadId'];
                $HaveLosstable->product = 3;
                $HaveLosstable->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateTimeString();
                $HaveLosstable->loss_amount = $data['loss_amount'];
                $HaveLosstable->save();
            }
            DB::commit();
            Cache::forget($token);
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
            $userProfileId = $data['userProfileId'];
            if(!$commercialAuto){
                return $this->sendError('Commercial Auto not found');
            }
            $oldCommercialAuto = $commercialAuto;
            $updateDate = [
                'general_information_id' => $generalInformationId,
                'fein' => $data['feinValue'],
                'ssn' => $data['ssnValue'],
                'garage_address' => $data['garage_address']
            ];
            foreach ($updateDate as $key => $newValue) {
                $oldValue = $commercialAuto->$key;
                if ($oldValue !== $newValue) {
                    // $changes['generalAutoInformation'][$key] = [
                    //     'old' => $oldValue,
                    //     'new' => $newValue
                    // ];
                    $commercialAuto->$key = $newValue;
                }
            }
            $commercialAuto->save();

            $vehicleInformation = VehicleInformation::getVehicleInformation($commercialAutoId);
            $oldVehicleInformation = VehicleInformation::getVehicleInformation($commercialAutoId);
            // $oldVehicleInformation = $vehicleInformation->map(function($data){
            //     return [
            //         'year' => $data->year,
            //         'make' => $data->make,
            //         'model' => $data->model,
            //         'vin' => $data->vin,
            //         'radius' => $data->radius_miles,
            //         'cost' => $data->cost_new_vehicle
            //     ];
            // })->toArray();

            $vehicleInformationData = $data['vehicle_information'];
            $vehicleInfoArr = [];
            if($vehicleInformation){
                $vehicleInformaionDataDelete = $vehicleInformation->each->delete();
                if($vehicleInformaionDataDelete){
                    foreach($vehicleInformationData as $dataVehicle){
                        $vehicleInfo = new VehicleInformation([
                            'commercial_auto_id' => $commercialAutoId,
                            'year' => $dataVehicle['year'],
                            'make' => $dataVehicle['make'],
                            'model' => $dataVehicle['model'],
                            'vin' => $dataVehicle['vin'],
                            'radius_miles' => $dataVehicle['radius'],
                            'cost_new_vehicle' => $dataVehicle['cost']
                        ]);
                        $vehicleInfoArr[] = $vehicleInfo->toArray();
                        $vehicleInfo->save();
                    }
                    // $changes['vehicle_information'][] = [
                    //     'old' => $oldVehicleInformation,
                    //     'new' => $vehicleInfoArr
                    // ];
                }
            }

            $driverInformation = DriverInformation::getDriverInformation($commercialAutoId);
            $oldDriverInformation = DriverInformation::getDriverInformation($commercialAutoId);
            // $oldDriverInformation = $driverInformation->map(function($data){
            //     return [
            //         'fullname' => $data->fullname,
            //         'date_of_birth' => Carbon::parse($data->date_of_birth)->format('m/d/Y'),
            //         'driver_license_number' => $data->driver_license_number,
            //         'marital_status' => $data->marital_status,
            //         'years_of_experience' => $data->years_of_experience
            //     ];
            // })->toArray();

            $driverInformationId = $driverInformation->pluck('id')->toArray();
            $driverSpouses = DriverSpouse::whereIn('driver_information_id', $driverInformationId)->get();
            $newDriverInfoArr = [];
            if($driverInformation){
                $driverSpouseDelete = $driverSpouses->each->delete();
                $driverInformationDelete = $driverInformation->each->delete();
                if($driverInformationDelete){
                    $driverInformation = $data['driver_information'];
                    foreach($driverInformation as $driverData){
                        $driverInfo = new DriverInformation([
                            'commercial_auto_id' => $commercialAutoId,
                            'fullname' => $driverData['firstName'] . ' ' . $driverData['lastname'],
                            'date_of_birth' => Carbon::parse($driverData['date_of_birth'])->toDateTimeString(),
                            'driver_license_number' => $driverData['driver_license_number'],
                            'marital_status' => $driverData['martial_status']['value'],
                            'years_of_experience' => $driverData['years_driving_experience']
                        ]);
                        $driverInfo->save();
                        $newDriverInfoArr[] = $driverInfo->toArray();
                        $spouseName = $driverData['spouse_name'] ?? null;
                        if(!is_null($spouseName) && !empty($spouseName)){
                            $spouseInformation = new DriverSpouse();
                            $spouseInformation->driver_information_id = $driverInfo->id;
                            $spouseInformation->spouse_fullname = $spouseName;
                            $spouseInformation->save();
                        }
                        // $changes['driver_information'][] = [
                        //     'old' => $oldDriverInformation,
                        //     'new' => $driverInfo->toArray()
                        // ];
                    }
                }
            }
            $supplementalQuestionare = CommercialAutoSupllemental::getCommercialSupplementalAuto($commercialAutoId);
            $oldSupplementalQuestionare = CommercialAutoSupllemental::getCommercialSupplementalAuto($commercialAutoId);
            $supplementalUpdatedQuestionare = [
                'commercial_auto_id' => $commercialAutoId,
                'vehicle_maintenance_program' => $data['vehicle_maintenance_program'],
                'vehicle_maintenace_description' => $data['vehicle_maintenace_description'] ?? "",
                'is_vehicle_customized' => $data['is_vehicle_customized'],
                'vehicle_customized_description' => $data['vehicle_customized_description'] ?? "",
                'is_vehicle_owned_by_prospect' => $data['is_vehicle_owned_by_prospect'],
                'declined_canceled_nonrenew_policy' => $data['declined_canceled_nonrenew_policy'],
                'prospect_loss' => $data['prospect_loss'],
                'vehicle_use_for_towing' => $data['vehicle_use_for_towing']
            ];

            foreach ($supplementalQuestionare as $key => $newValue) {
                $oldValue = $supplementalQuestionare->$key;
                if ($oldValue !== $newValue) {
                    // $changes['supplementalAnswer'][$key] = [
                    //     'old' => $oldValue,
                    //     'new' => $newValue
                    // ];
                    $supplementalQuestionare->$key = $newValue;
                }
            }
            $supplementalQuestionare->save();

            //updatinf for expiration product
            $expirationAuto = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 3);
            $oldExpirationProduct = ExpirationProduct::getExpirationProductByLeadIdProduct($id, 3);
            $updatedExpirationProduct = [
                'lead_id' => $data['leadId'],
                'product' => 3,
                'prior_carrier' => $data['prior_carrier']
            ];

            foreach ($updatedExpirationProduct as $key => $newValue){
                $oldValue = $expirationAuto->$key;
                if($oldValue !== $newValue){
                    // $changes['expirationProduct'][$key] = [
                    //     'old' => $oldValue,
                    //     'new' => $newValue
                    // ];
                    $expirationAuto->$key = $newValue;
                }
            }
            $expirationAuto->save();

            if($data['cross_sell']){
                $crossSell = CrossSell::getCrossSelByLeadIdProduct($id, 3);
                $crossSell->cross_sell = $data['cross_sell']['value'];
                $crossSell->save();
            }

            if($data['have_loss']) {
                $haveLoss = HaveLoss::where('lead_id', $data['leadId'])->where('product', 3)->first();
                $oldHaveLoss = $haveLoss;
                HaveLoss::updateOrCreate(
                    ['lead_id' => $data['leadId'], 'product' => 3],
                    [
                        'date_of_claim' => Carbon::parse($data['date_of_claim'])->toDateTimeString(),
                        'loss_amount' => $data['loss_amount']
                    ]
                );
            } else {
                $haveLossRecord = HaveLoss::where('lead_id', $data['leadId'])->where('product', 3)->first();
                $oldHaveLoss =  HaveLoss::where('lead_id', $data['leadId'])->where('product', 3)->first();
                if($haveLossRecord) {
                    $haveLossRecord->delete();
                }

            }
            $firstVehicle = $oldVehicleInformation->first();
            $otherVehicles = $oldVehicleInformation->slice(1);
            $changes = [
                 //vehicle information
                'firstVehicleInformation' => [
                    'year' => $firstVehicle->year,
                    'make' => $firstVehicle->make,
                    'model' => $firstVehicle->model,
                    'vin' => $firstVehicle->vin,
                    'radius' => $firstVehicle->radius_miles,
                    'cost' => $firstVehicle->cost_new_vehicle
                ],

                'vehicleInformation' => $otherVehicles->map(function($vehicle){
                    return [
                        'year' => $vehicle->year,
                        'make' => $vehicle->make,
                        'model' => $vehicle->model,
                        'vin' => $vehicle->vin,
                        'radius' => $vehicle->radius_miles,
                        'cost' => $vehicle->cost_new_vehicle
                    ];
                })->values()->all(),

                //common information
               'isEditing' => false,
               'isUpdate' => true,
               'feinValue' => $oldCommercialAuto->fein,
               'ssnValue' => $oldCommercialAuto->ssn,
               'garage_address' => $oldCommercialAuto->garage_address,

                 //driver information
                'driverInformation' => $oldDriverInformation->map(function($driver){
                    return [
                      'firstName' => explode(' ', $driver->fullname)[0],
                      'lastname' => explode(' ', $driver->fullname)[1],
                      'date_of_birth' => Carbon::parse($driver->date_of_birth)->format('m/d/Y'),
                      'driver_license_number' => $driver->driver_license_number,
                     'years_driving_experience' => $driver->years_of_experience,
                      'martial_status' => [
                        'value' => $driver->marital_status,
                        'label' => $driver->marital_status
                       ],
                      'spouse_name' => $driver->driverSpouse->spouse_fullname ?? null
                    ];
                })->values()->all(),
               'driverQuantity' => $oldDriverInformation->count(),

                //supplmental questionare
                'vehicle_maintenance_program' => $oldSupplementalQuestionare->vehicle_maintenance_program,
                'is_vehicle_customized' => $oldSupplementalQuestionare->is_vehicle_customized,
                'is_vehicle_owned_by_prospect' => $oldSupplementalQuestionare->is_vehicle_owned_by_prospect,
                'declined_canceled_nonrenew_policy' => $oldSupplementalQuestionare->declined_canceled_nonrenew_policy,
                'prospect_loss' => $oldSupplementalQuestionare->prospect_loss,
                'vehicle_use_for_towing' => $oldSupplementalQuestionare->vehicle_use_for_towing,
                'vehicle_maintenace_description' => $oldSupplementalQuestionare->vehicle_maintenace_description,
                'vehicle_customized_description' => $oldSupplementalQuestionare->vehicle_customized_description,

                 //expiration product
                 'expirationOfAuto' => Carbon::parse($oldExpirationProduct->expiration_date)->format('m/d/Y'),
                 'priorCarrier' => $oldExpirationProduct->prior_carrier,

                 //have loss information
                 'isHaveLossChecked' => $oldHaveLoss ? true : false,
                 'lossAmount' => $oldHaveLoss ? $oldHaveLoss->loss_amount : null,
                 'dateOfClaim' => $oldHaveLoss ? Carbon::parse($oldHaveLoss->date_of_claim)->format('m/d/Y') : null,
            ];
            if(count($changes) > 0){
                event(new UpdateGeneralInformationEvent($id, $userProfileId, $changes, now(), 'commercial-auto-update'));
            }
            DB::commit();
        }catch(\Exception $e){
            Log::info("Error for Commercial Auto", [$e->getMessage()]);
            return $this->sendError('Error saving commercial auto data');
        }
    }


    public function edit($id)
    {
        $generalInformation = GeneralInformation::where('leads_id', $id)->first();
        $commercialAuto = CommercialAuto::where('general_information_id', $generalInformation->id)->first();
        $vehicleInformation = VehicleInformation::where('commercial_auto_id', $commercialAuto->id)->get();
        $driverInformation = DriverInformation::where('commercial_auto_id', $commercialAuto->id)->get();
        $commercialAutoSupplemental = CommercialAutoSupllemental::where('commercial_auto_id', $commercialAuto->id)->first();
        $expirationProduct = ExpirationProduct::where('lead_id', $id)->where('product', 3)->first();
        $haveLoss = HaveLoss::where('lead_id', $id)->where('product', 3)->first();
        if (!$vehicleInformation instanceof \Illuminate\Support\Collection) {
            $vehicleInformation = collect(is_array($vehicleInformation) ? $vehicleInformation : [$vehicleInformation]);
        }
        $firstVehicle = $vehicleInformation->first();
        $otherVehicles = $vehicleInformation->slice(1);

        $commercialAutoData = [

            //vehicle information
            'firstVehicleInformation' => [
                'year' => $firstVehicle->year,
                'make' => $firstVehicle->make,
                'model' => $firstVehicle->model,
                'vin' => $firstVehicle->vin,
                'radius' => $firstVehicle->radius_miles,
                'cost' => $firstVehicle->cost_new_vehicle
            ],
            'vehicleInformation' => $otherVehicles->map(function($vehicle){
                return [
                    'year' => $vehicle->year,
                    'make' => $vehicle->make,
                    'model' => $vehicle->model,
                    'vin' => $vehicle->vin,
                    'radius' => $vehicle->radius_miles,
                    'cost' => $vehicle->cost_new_vehicle
                ];
            })->values()->all(),

            //common information
            'isEditing' => false,
            'isUpdate' => true,
            'feinValue' => $commercialAuto->fein,
            'ssnValue' => $commercialAuto->ssn,
            'garageAddress' => $commercialAuto->garage_address,

            //driver information
            'driverInformation' => $driverInformation->map(function($driver){
                return [
                    'firstName' => explode(' ', $driver->fullname)[0],
                    'lastname' => explode(' ', $driver->fullname)[1],
                    'date_of_birth' => Carbon::parse($driver->date_of_birth)->format('m/d/Y'),
                    'driver_license_number' => $driver->driver_license_number,
                    'years_driving_experience' => $driver->years_of_experience,
                    'martial_status' => [
                        'value' => $driver->marital_status,
                        'label' => $driver->marital_status
                    ],
                    'spouse_name' => $driver->driverSpouse->spouse_fullname ?? null
                ];
            })->values()->all(),
            'driverQuantity' => $driverInformation->count(),

            //supplmental questionare
            'vehicle_maintenance_program' =>
            $commercialAutoSupplemental->vehicle_maintenance_program,
            'is_vehicle_customized' => $commercialAutoSupplemental->is_vehicle_customized,
            'is_vehicle_owned_by_prospect' => $commercialAutoSupplemental->is_vehicle_owned_by_prospect,
            'declined_canceled_nonrenew_policy' => $commercialAutoSupplemental->declined_canceled_nonrenew_policy,
            'prospect_loss' => $commercialAutoSupplemental->prospect_loss,
            'vehicle_use_for_towing' => $commercialAutoSupplemental->vehicle_use_for_towing,
            'vehicle_maintenace_description' => $commercialAutoSupplemental->vehicle_maintenace_description,
            'vehicle_customized_description' => $commercialAutoSupplemental->vehicle_customized_description,

            //expiration product
            'expirationOfAuto' => Carbon::parse($expirationProduct->expiration_date)->format('m/d/Y'),
            'priorCarrier' => $expirationProduct->prior_carrier,

            //have loss information
            'isHaveLossChecked' => $haveLoss ? true : false,
            'lossAmount' => $haveLoss ? $haveLoss->loss_amount : null,
            'dateOfClaim' => $haveLoss ? Carbon::parse($haveLoss->date_of_claim)->format('m/d/Y') : null,

        ];
        Log::info("Commercial Auto", [$commercialAutoData]);
        return response()->json(['data' => $commercialAutoData, 'Commercial Auto Retrieved successfully']);
    }

    public function getPreviousCommercialAutoInformation($id)
    {
        $leadHistroy = LeadHistory::find($id);
        $changes = json_decode($leadHistroy->changes, true);
        return response()->json(['data' => $changes, 'Lead History Retrieved successfully']);
    }


}