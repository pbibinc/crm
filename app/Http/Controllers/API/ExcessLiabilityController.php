<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Callback;
use App\Models\CrossSell;
use App\Models\ExcessLiability;
use App\Models\GeneralInformation;
use App\Models\LeadHistory;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExcessLiabilityController extends BaseController
{
    //
    public function saveExcessLiability(Request $request)
    {
        try{
            DB::beginTransaction();

            $data = $request->all();
            $ExcessLiability = new ExcessLiability();
            $ExcessLiability->general_information_id = GeneralInformation::getIdByLeadId($data['leadId']);
            $ExcessLiability->excess_limit = $data['excessLimit'];
            $ExcessLiability->excess_date = Carbon::parse($data['excessEffectiveDate'])->toDateTimeString();
            $ExcessLiability->insurance_carrier = $data['insuranceCarrier'];
            $ExcessLiability->policy_number = $data['policyNumber'];
            $ExcessLiability->policy_premium = $data['policyPremium'];
            $ExcessLiability->general_liability_effective_date = Carbon::parse($data['generalLiabilityEffectiveDate'])->toDateTimeString();
            $ExcessLiability->general_liability_expiration_date = Carbon::parse($data['generalLiabilityExpirationDate'])->toDateTimeString();
            $ExcessLiability->save();

             //code for saving the quote information
             $quoteProduct = new QuotationProduct();
             $leadId = $data['leadId'];
             $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
             if($quoteInformation){
                $quoteProduct->quote_information_id = $quoteInformation->id;
             }
             $quoteProduct->product = 'Excess Liability';
             $quoteProduct->status = 7;
             $quoteProduct->save();

            // $crossSell = new CrossSell();
            // $crossSell->lead_id = $data['leadId'];
            // $crossSell->product = 4;
            // $crossSell->cross_sell = $data['crossSell'];
            // $crossSell->save();

            $callBackDate = new Callback();
            $callBackDate->lead_id = $data['leadId'];
            $callBackDate->status = 1;
            $callBackDate->type = 4;
            $callBackDate->date_time = Carbon::parse($data['callBackDate'])->toDateTimeString();
            $callBackDate->remarks = $data['remarks'];
            $callBackDate->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Excess liability data", [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }

    }

    public function updateExcessLiability(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $GeneralInformationId = GeneralInformation::getIdByLeadId($id);
            $userProfileId = $data['userProfileId'];
            $ExcessLiability = ExcessLiability::getExcessLiabilityData($GeneralInformationId);
            $oldExcessLiability = ExcessLiability::getExcessLiabilityData($GeneralInformationId);
            $ExcessLiability->excess_limit = $data['excessLimit'];
            $ExcessLiability->excess_date = Carbon::parse($data['excessEffectiveDate'])->toDateTimeString();
            $ExcessLiability->insurance_carrier = $data['insuranceCarrier'];
            $ExcessLiability->policy_number = $data['policyNumber'];
            $ExcessLiability->policy_premium = $data['policyPremium'];
            $ExcessLiability->general_liability_effective_date = Carbon::parse($data['generalLiabilityEffectiveDate'])->toDateTimeString();
            $ExcessLiability->general_liability_expiration_date = Carbon::parse($data['generalLiabilityExpirationDate'])->toDateTimeString();
            $ExcessLiability->save();

            // $crossSell = CrossSell::getCrossSelByLeadIdProduct($id, 4);
            // $crossSell->lead_id = $data['leadId'];
            // $crossSell->cross_sell = $data['crossSell'];
            // $crossSell->save();

            $callBackDate = Callback::getCallBackByLeadIdType($id, 4);
            if($callBackDate){
                $callBackDate->lead_id = $data['leadId'];
                $callBackDate->date_time = Carbon::parse($data['callBackDate'])->toDateTimeString();
                $callBackDate->remarks = $data['remarks'];
                $callBackDate->save();;
            }
            $changes = [
                //excess general information
                'excessLimit' =>  [
                    'value' => $oldExcessLiability->excess_limit,
                    'label' => $oldExcessLiability->excess_limit,
                ],
                'effectiveDate' => $oldExcessLiability->excess_date,
                'excessEffectiveDate'=> $oldExcessLiability->excess_date,
                'insuranceCarrier'=> $oldExcessLiability->insurance_carrier,
                'policyNumber' => $oldExcessLiability->policy_number,
                'policyPremium' => $oldExcessLiability->policy_premium,
                'generalLiabilityEffectiveDate' => $oldExcessLiability->general_liability_effective_date,
                'generalLiabilityExpirationDate' => $oldExcessLiability->general_liability_expiration_date,


                //prerequiste data
                'leadId' => $id ,
                'isEditing' => false,
                'isUpdate' => true,
            ];


            if(count($changes) > 0){
                event(new UpdateGeneralInformationEvent($id, $userProfileId, $changes, now(), 'excess-liability-update'));
            }


            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Excess liability data", [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $generalInformation = GeneralInformation::where('leads_id', $id)->first();
        $excessLiabiity = ExcessLiability::where('general_information_id', $generalInformation->id)->first();

        $changes = [
            'excessLimit' =>  [
                'value' => $excessLiabiity->excess_limit,
                'label' => $excessLiabiity->excess_limit,
            ],
            'effectiveDate' => $excessLiabiity->excess_date,
            'excessEffectiveDate'=> $excessLiabiity->excess_date,
            'insuranceCarrier'=> $excessLiabiity->insurance_carrier,
            'policyNumber' => $excessLiabiity->policy_number,
            'policyPremium' => $excessLiabiity->policy_premium,
            'generalLiabilityEffectiveDate' => $excessLiabiity->general_liability_effective_date,
            'generalLiabilityExpirationDate' => $excessLiabiity->general_liability_expiration_date,
            'leadId' => $id ,
            'isEditing' => false,
            'isUpdate' => true,
        ];

        return response()->json(['data' => $changes, 'Excess Liability Data']);

    }

    public function getPrviousExcessLiabilityInformation($id)
    {
        $leadHistroy = LeadHistory::find($id);
        $changes = json_decode($leadHistroy->changes, true);
        return response()->json(['data' => $changes, 'Lead History Retrieved successfully']);
    }
}