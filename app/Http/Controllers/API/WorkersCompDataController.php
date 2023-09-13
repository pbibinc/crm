<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ClasscodePerEmployee;
use App\Models\GeneralInformation;
use App\Models\WorkersCompensation;
use App\Models\WorkersCompensationHaveLoss;
use Carbon\Carbon;

class WorkersCompDataController extends BaseController
{
    public function saveWorkersComp(Request $request)
    {
        $data = $request->all();

        //Code for saving the common workers compensation data
        $workersCompensation = new WorkersCompensation();
        $generalInformationId = GeneralInformation::where('leads_id', $data['lead_id'])->first()->id;
        $workersCompensation->general_information_id = $generalInformationId;
        $workersCompensation->specific_employee_description = $data['specific_employee_description'];
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
        $workersCompensation->remarks = $data['remarks'];
        $workersCompensation->save();

        //save have loss
        if($data['have_loss'] == true){
            $workersCompensationHaveLoss = new WorkersCompensationHaveLoss();
            $workersCompensationHaveLoss->workers_compensation_id = $workersCompensation->id;
            $workersCompensationHaveLoss->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateString();
            $workersCompensationHaveLoss->loss_amount = $data['loss_amount'];
            $workersCompensationHaveLoss->save();
        }
        $workerCompHaveloss = new WorkersCompensationHaveLoss();
        $workerCompHaveloss->workers_compensation_id = $workersCompensation->id;
        $workerCompHaveloss->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateString();
        $workerCompHaveloss->loss_amount = $data['loss_amount'];
        $workerCompHaveloss->save();


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
    }

    public function updateWorkersComp (Request $request, $id)
    {
       $data = $request->all();

       $generalInformationId = GeneralInformation::where('leads_id', $id)->first()->id;
       $workersCompenSationId = WorkersCompensation::where('general_information_id', $generalInformationId)->first()->id;

       $workersCompensation = WorkersCompensation::where('id', $workersCompenSationId)->first();
       $workersCompensation->specific_employee_description = $data['specific_employee_description'];
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
       $workersCompensation->remarks = $data['remarks'];
       $workersCompensation->save();


       if($data['have_loss'] == true){
       $workerCompHaveloss = WorkersCompensationHaveLoss::where('workers_compensation_id', $workersCompenSationId)->first();
       $workerCompHaveloss->date_of_claim = Carbon::parse($data['date_of_claim'])->toDateString();
       $workerCompHaveloss->loss_amount = $data['loss_amount'];
       $workerCompHaveloss->save();
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
