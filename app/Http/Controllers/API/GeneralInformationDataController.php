<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GeneralInformation;
use Illuminate\Support\Facades\Cache;

class GeneralInformationDataController extends BaseController
{
    public function getGeneralInformationData(Request $request)
    {
        $data = $request->all();
        Cache::put('general_information_data', $data);
    
        $generalInformation = new GeneralInformation();
        $generalInformation->firstname = $data['firstname'];
        $generalInformation->lastname = $data['lastname'];
        $generalInformation->job_position = $data['job_position'];
        $generalInformation->address = $data['address'];
        $generalInformation->zipcode = $data['zipcode'];
        $generalInformation->state = $data['state'];
        $generalInformation->alt_num = $data['alt_num'];
        $generalInformation->email_address = $data['email'];
        $generalInformation->fax = $data['fax'];
        $generalInformation->gross_receipt = $data['gross_receipt'];
        $generalInformation->full_time_employee = $data['full_time_employee'];
        $generalInformation->part_time_employee = $data['part_time_employee'];
        $generalInformation->employee_payroll = $data['employee_payroll'];
        $generalInformation->all_trade_work = $data['all_trade_work'];
        $generalInformation->leads_id = $data['lead_id'];
        $generalInformation->owners_payroll = $data['owners_payroll'];
        $generalInformation->sub_out = $data['sub_out'];
        $generalInformation->material_cost = $data['material_cost'];
      
        $generalInformation->save();

        return $this->sendResponse($generalInformation,'General Information Data retrieved successfully.');
    }

    public function updateGenneralInformationData(Request $request, $id)
    {
       $data = $request->all();

       $generalInformation = GeneralInformation::where('leads_id', $id)->first();

       if($generalInformation){
        $generalInformation->firstname = $data['firstname'];
        $generalInformation->lastname = $data['lastname'];
        $generalInformation->job_position = $data['job_position'];
        $generalInformation->address = $data['address'];
        $generalInformation->zipcode = $data['zipcode'];
        $generalInformation->state = $data['state'];
        $generalInformation->alt_num = $data['alt_num'];
        $generalInformation->email_address = $data['email'];
        $generalInformation->fax = $data['fax'];
        $generalInformation->gross_receipt = $data['gross_receipt'];
        $generalInformation->full_time_employee = $data['full_time_employee'];
        $generalInformation->part_time_employee = $data['part_time_employee'];
        $generalInformation->employee_payroll = $data['employee_payroll'];
        $generalInformation->all_trade_work = $data['all_trade_work'];
        $generalInformation->owners_payroll = $data['owners_payroll'];
        $generalInformation->sub_out = $data['sub_out'];
        $generalInformation->material_cost = $data['material_cost'];
        $generalInformation->save();
       }else{
        return response()->json(['message' => 'General Information Data not found!'], 404);
       }
       return response()->json(['message' => 'Data updated successfully'], 200);
    }

    public function generalInformationData()
    {
        $generalInformation = GeneralInformation::all();
        return $this->sendResponse($generalInformation,'General Information Data retrieved successfully.');
    }
}

?>