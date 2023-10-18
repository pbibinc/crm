<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Callback;
use App\Models\CrossSell;
use App\Models\ExcessLiability;
use App\Models\GeneralInformation;
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
             $quoteProduct->status = 2;
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
            $ExcessLiability = ExcessLiability::getExcessLiabilityData($GeneralInformationId);
            $ExcessLiability->excess_limit = $data['excessLimit'];
            $ExcessLiability->excess_date = Carbon::parse($data['excessEffectiveDate'])->toDateTimeString();
            $ExcessLiability->insurance_carrier = $data['insuranceCarrier'];
            $ExcessLiability->policy_number = $data['policyNumber'];
            $ExcessLiability->policy_premium = $data['policyPremium'];
            $ExcessLiability->general_liability_effective_date = Carbon::parse($data['generalLiabilityEffectiveDate'])->toDateTimeString();
            $ExcessLiability->general_liability_expiration_date = Carbon::parse($data['generalLiabilityExpirationDate'])->toDateTimeString();
            $ExcessLiability->save();

            $crossSell = CrossSell::getCrossSelByLeadIdProduct($id, 4);
            $crossSell->lead_id = $data['leadId'];
            $crossSell->cross_sell = $data['crossSell'];
            $crossSell->save();

            $callBackDate = Callback::getCallBackByLeadIdType($id, 4);
            $callBackDate->lead_id = $data['leadId'];
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
}
