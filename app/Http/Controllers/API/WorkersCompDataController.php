<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Callback;
use App\Models\ClasscodePerEmployee;
use App\Models\GeneralInformation;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\WorkersCompensation;
use App\Models\WorkersCompensationHaveLoss;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
class WorkersCompDataController extends BaseController
{
    public function saveWorkersComp(Request $request)
    {
        try{

        $token = $request->input('token');
        if(Cache::has($token)){
            return response()->json([
                'message' => 'Duplicate submission, please try again'
            ],422);
        }
        $token = Str::random(10);

        $data = $request->all();
              //Code for saving the common workers compensation data
        $generalInformationId = GeneralInformation::where('leads_id', $data['lead_id'])->first()->id;
        if (empty($generalInformationId)) {
            return response()->json(['error' => 'General Information Data is not yet saved.'], 409);
        }

        if(WorkersCompensation::where('general_information_id', $generalInformationId)->exists()){
            return response()->json(['error' => 'Workers Compenstation Data has been already saved.'], 409);
        }
        Cache::put($token, true, 10);
        DB::beginTransaction();
        $workersCompensation = new WorkersCompensation();
        $workersCompensation->general_information_id = $generalInformationId;
        $workersCompensation->is_owners_payroll_included = $data['is_owner_payroll_included'];
        $workersCompensation->payroll_amount = $data['total_payroll'];
        $workersCompensation->fein_number = $data['fein'];
        $workersCompensation->ssin_number = $data['ssn'];
        $workersCompensation->expiration = Carbon::parse($data['expiration'])->toDateString();
        $workersCompensation->prior_carrier = $data['prior_carrier'];
        $workersCompensation->workers_compensation_amount = $data['workers_compensation_amount'];
        $workersCompensation->policy_limit = $data['policy_limit'];
        $workersCompensation->each_accident = $data['each_accident'];
        $workersCompensation->each_employee = $data['each_employee'];
        $workersCompensation->save();

        if($data['isCallBack'] == true){
            $callback = new Callback();
            $callback->lead_id = $data['lead_id'];
            $callback->status = 2;
            $callback->type = 2;
            $callback->date_time = Carbon::parse($data['callBackDate'])->toDateString();
            $callback->remarks = $data['remarks'];
            $callback->save();
        }

         //code for saving the quote information
         $quoteProduct = new QuotationProduct();
         $leadId = $data['lead_id'];
         $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
         if($quoteInformation){
             $quoteProduct->quote_information_id = $quoteInformation->id;
         }
         $quoteProduct->product = 'Workers Compensation';
         $quoteProduct->status = 7;
         $quoteProduct->save();


         //save have loss
         if($data['have_loss'] == true){
             $workersCompensationHaveLoss = new WorkersCompensationHaveLoss();
             $workersCompensationHaveLoss->workers_compensation_id = $workersCompensation->id;
             $workersCompensationHaveLoss->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateString();
             $workersCompensationHaveLoss->loss_amount = $data['loss_amount'];
             $workersCompensationHaveLoss->save();
         }

         $mergedClassCodePerEmployee = array_map(function($employeeDescription, $numberOfEmployee) {
             return [
                 'employee_description' => $employeeDescription,
                 'number_of_employee' => $numberOfEmployee
             ];
         }, $data['employee_description'], $data['number_of_employee']);

         //code for classcode_per_employee saving
         foreach($mergedClassCodePerEmployee as $classCodePerEmployeeData){
             $classCodePerEmployee = new ClasscodePerEmployee();
             $classCodePerEmployee->workers_compensation_id = $workersCompensation->id;
             $classCodePerEmployee->employee_description = $classCodePerEmployeeData['employee_description'];
             $classCodePerEmployee->number_of_employee = $classCodePerEmployeeData['number_of_employee'];
             $classCodePerEmployee->save();
         }
         DB::commit();
         Cache::forget($token);
        }catch(\Exception $e){
            Log::info("Error for Workers Compensation", [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }




    }

    public function updateWorkersComp (Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            $generalInformationId = GeneralInformation::where('leads_id', $id)->first()->id;
            $workersCompenSationId = WorkersCompensation::where('general_information_id', $generalInformationId)->first()->id;
            $workersCompensation = WorkersCompensation::where('id', $workersCompenSationId)->first();
            $workersCompensation->is_owners_payroll_included = $data['is_owner_payroll_included'];
            $workersCompensation->payroll_amount = $data['total_payroll'];
            $workersCompensation->fein_number = $data['fein'];
            $workersCompensation->ssin_number = $data['ssn'];
            $workersCompensation->expiration = Carbon::parse($data['expiration'])->toDateString();
            $workersCompensation->prior_carrier = $data['prior_carrier'];
            $workersCompensation->workers_compensation_amount = $data['workers_compensation_amount'];
            $workersCompensation->policy_limit = $data['policy_limit'];
            $workersCompensation->each_accident = $data['each_accident'];
            $workersCompensation->each_employee = $data['each_employee'];
            $workersCompensation->save();

            if($data['isCallBack'] == true){
                $callBack = Callback::where('lead_id', $id)->where('type', 2)->first();
                if($callBack){
                    $callBack->lead_id = $id;
                    $callBack->status = 2;
                    $callBack->type = 2;
                    $callBack->date_time = Carbon::parse($data['callBackDate'])->toDateString();
                    $callBack->remarks = $data['remarks'];
                    $callBack->save();
                }else{
                    $callback = new Callback();
                    $callback->lead_id = $id;
                    $callback->status = 2;
                    $callback->type = 2;
                    $callback->date_time = Carbon::parse($data['callBackDate'])->toDateString();
                    $callback->remarks = $data['remarks'];
                    $callback->save();
                }

            }else{
                $callBack = Callback::where('lead_id', $id)->where('type', 2)->first();
                if($callBack){
                    $callBack->delete();
                }
            }


            if($data['have_loss']) {
                WorkersCompensationHaveLoss::updateOrCreate(
                    ['workers_compensation_id' => $workersCompenSationId],
                    [
                        'date_of_claim' => Carbon::parse($data['date_of_claim'])->toDateString(),
                        'loss_amount' => $data['loss_amount']
                    ]
                );
            } else {
                $workerCompHaveloss = WorkersCompensationHaveLoss::where('workers_compensation_id', $workersCompenSationId)->first();
                if($workerCompHaveloss) {
                    $workerCompHaveloss->delete();
                }
            }

            $classCodePerEmployee = ClasscodePerEmployee::where('workers_compensation_id', $workersCompenSationId)->get();
            $classCodePerEmployeeDelete = $classCodePerEmployee->each->delete();
            if($classCodePerEmployeeDelete){
             $mergedClassCodePerEmployee = array_map(function($employeeDescription, $numberOfEmployee) {
                 return [
                     'employee_description' => $employeeDescription,
                     'number_of_employee' => $numberOfEmployee
                 ];
             }, $data['employee_description'], $data['number_of_employee']);

             foreach($mergedClassCodePerEmployee as $classCodePerEmployeeData){
                 $classCodePerEmployee = new ClasscodePerEmployee();
                 $classCodePerEmployee->workers_compensation_id = $workersCompensation->id;
                 $classCodePerEmployee->employee_description = $classCodePerEmployeeData['employee_description'];
                 $classCodePerEmployee->number_of_employee = $classCodePerEmployeeData['number_of_employee'];
                 $classCodePerEmployee->save();
             }

            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::info("Error for Workers Compensation", [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }


    }

    public function getWorkersCompData($id)
    {
        $workersCompensationData = WorkersCompensation::where('general_information_id', $id)->first();
        if($workersCompensationData){
            return $this->sendResponse($workersCompensationData->toArray(), 'Workers Compensation Data retrieved successfully.');

        }else{
            return response()->json(null, 'Workers Compensation Data not found!');
        }
    }


}

?>