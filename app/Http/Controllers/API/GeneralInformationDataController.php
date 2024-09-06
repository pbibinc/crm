<?php

namespace App\Http\Controllers\API;

use App\Events\AppointmentTaken;
use App\Events\UpdateGeneralInformationEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\PolicyDetail;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\UserProfile;
use HelloSign\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class GeneralInformationDataController extends BaseController
{
    public function getGeneralInformationData(Request $request)
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
            Cache::put('general_information_data', $data);
            if(GeneralInformation::where('leads_id', $data['lead_id'])->exists()){
                $generalInformation = GeneralInformation::where('leads_id', $data['lead_id'])->first();
                $userProfile = LeadHistory::getAppointerUserProfile($data['lead_id']);
                return response()->json(['message' => 'General Informmation Data has been already saved', 'generalInformation' => $generalInformation, 'userProfile' => $userProfile], 409);
            }
            //saving gneral information data
            // Log::info("user id", [Auth::user()->id]);
            $generalInformation = new GeneralInformation();
            $generalInformation->firstname = $data['firstname'];
            $generalInformation->lastname = $data['lastname'];
            $generalInformation->job_position = $data['job_position'];
            $generalInformation->address = $data['address'];
            $generalInformation->zipcode = $data['zipcode'];
            $generalInformation->state = $data['state'];
            $generalInformation->alt_num = $data['alt_num'] ? $data['alt_num'] : '99999999999';
            $generalInformation->email_address = $data['email'];
            $generalInformation->fax = $data['fax'] ? $data['fax'] : '9999999999';
            $generalInformation->gross_receipt = $data['gross_receipt'];
            $generalInformation->full_time_employee = $data['full_time_employee'];
            $generalInformation->part_time_employee = $data['part_time_employee'];
            $generalInformation->employee_payroll = $data['employee_payroll'];
            $generalInformation->all_trade_work = $data['all_trade_work'];
            $generalInformation->leads_id = $data['lead_id'];
            $generalInformation->owners_payroll = $data['owners_payroll'];
            $generalInformation->sub_out = $data['sub_out'] ? $data['sub_out'] : 0;
            $generalInformation->material_cost = $data['material_cost'];
            $generalInformationSaving =  $generalInformation->save();
            if($generalInformationSaving){
                //saving of quotelead
                $quoteLeadTable = new QuoteLead();
                $quoteLeadTable->leads_id = $data['lead_id'];
                $quoteLeadTable->save();

                //saving of quote information
                $quoteInformation = new QuoteInformation();

                $quoteInformation->telemarket_id = 1;
                $quoteInformation->quoting_lead_id = $quoteLeadTable->id;
                $quoteInformation->status = 2;
                $quoteInformation->remarks = ' ';
                $quoteInformation->save();
            }

            $Lead = Lead::getLeads($data['lead_id']);
            $Lead->disposition_id = 1;
            $Lead->status= 3;
            $Lead->save();
            event(new AppointmentTaken($Lead, $Lead->userProfile[0]->id, $Lead->userProfile[0]->id, now()));

            DB::commit();
            Cache::forget($token);
            return response()->json(['message' => 'General Information Data saved successfully'], 200);
        }
        catch(\Exception $e){
            DB::rollback();
            Log::error("Error for General Information".$e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // return $this->sendResponse($generalInformation,'General Information Data retrieved successfully.');
    }

    public function edit($id)
    {
        $leads = Lead::find($id);
        $userId = Cache::get('user_id');
        $generalInformation = $leads->generalInformation;
        // $userId = Auth::user()->id;
        $generalInformationData = [
            'address' => $generalInformation->address,
            'all_trade_work' => $generalInformation->all_trade_work,
            'alt_num' => $generalInformation->alt_num,
            'amount' => $generalInformation->material_cost,
            'email' => $generalInformation->email_address,
            'employee_payroll' => $generalInformation->employee_payroll,
            'fax' => $generalInformation->fax,
            'firstname' => $generalInformation->firstname,
            'full_time_employee' => $generalInformation->full_time_employee,
            'gross_receipt' => $generalInformation->gross_receipt,
            'job_position' => $generalInformation->job_position,
            'lastname' => $generalInformation->lastname,
            'owners_payroll' => $generalInformation->owners_payroll,
            'part_time_employee' => $generalInformation->part_time_employee,
            'state' => [
                'value' => $generalInformation->state,
                'label' => $generalInformation->state
            ],
            'sub_out' => $generalInformation->sub_out,
            'zipcode' => [
                'value' => $generalInformation->zipcode,
                'label' => $generalInformation->zipcode
            ],

            'userId' => $userId,
            'isUpdate' => true,
            'isEditing' => false,
        ];
        return $this->sendResponse($generalInformationData,'General Information Data retrieved successfully.');
    }

    public function updateGenneralInformationData(Request $request, $id)
    {
       try{
        DB::beginTransaction();
        $data = $request->all();
        Log::info("Data", [$data]);
        // $policyDetail = PolicyDetail::where('quotation_product_id', $data['productId'])->first();
         $userProfileId = UserProfile::where('user_id', $data['userId'])->first()->id;
         $changes = [];
         $originalData = GeneralInformation::where('leads_id', $id)->first();
         $generalInformation = $originalData;
         $defaultValues = [
            'alt_num' => '99999999999',
            'fax' => '9999999999',
            'sub_out' => ' '
         ];
         foreach($defaultValues as $property => $defaultValue){
                if(!isset($data[$property]) || $data[$property] === null){
                    $data[$property] = $defaultValue;
                }
         }
         foreach($data as $key => $value){
            if (isset($generalInformation->$key) && $generalInformation->$key !== $value) {
                Log::info("General Information - {$key}: Old value: {$generalInformation->$key}, New value: {$value}");
                $changes[$key] = [
                    'old' => $generalInformation->$key,
                    'new' => $value
                ];
                $generalInformation->$key = $value;
            }
         }
        //  $generalInformation->firstname = $data['firstname'];
        //  $generalInformation->lastname = $data['lastname'];
        //  $generalInformation->job_position = $data['job_position'];
        //  $generalInformation->address = $data['address'];
        //  $generalInformation->zipcode = $data['zipcode'];
        //  $generalInformation->state = $data['state'];
        //  $generalInformation->alt_num = $data['alt_num'] ? $data['alt_num'] : '99999999999';
        //  $generalInformation->email_address = $data['email'];
        //  $generalInformation->fax = $data['fax'] ? $data['fax'] : '9999999999';
        //  $generalInformation->gross_receipt = $data['gross_receipt'];
        //  $generalInformation->full_time_employee = $data['full_time_employee'];
        //  $generalInformation->part_time_employee = $data['part_time_employee'];
        //  $generalInformation->employee_payroll = $data['employee_payroll'];
        //  $generalInformation->all_trade_work = $data['all_trade_work'];
        //  $generalInformation->owners_payroll = $data['owners_payroll'];
        //  $generalInformation->sub_out = $data['sub_out'] ? $data['sub_out'] : ' ';
        //  $generalInformation->material_cost = $data['material_cost'];
         $generalInformation->save();
         if(count($changes) > 0){
            event(new UpdateGeneralInformationEvent($id, $userProfileId, $changes, now(), 'general-information-update'));
         }

        DB::commit();
       }catch(\Exception $e){
        DB::rollback();
        Log::info("Error for General Information", [$e]);
        return response()->json(['message' => 'Data updated successfully'], 200);
       }

    }

    public function generalInformationData()
    {
        $generalInformation = GeneralInformation::all();
        $userId = Auth::user()->id;
        return $this->sendResponse($generalInformation,'General Information Data retrieved successfully.');
    }
}


?>