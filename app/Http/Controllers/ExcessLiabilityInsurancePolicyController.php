<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExcessLiabilityInsurancePolicy;
use App\Models\Metadata;
use App\Models\PolicyAdditionalValue;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ExcessLiabilityInsurancePolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $data = $request->all();
            $file = $data['file'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/policy'. '/' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $quotationProduct = QuotationProduct::find($data['excessInsuranceHiddenInputId']);

            $policyDetails = new PolicyDetail();
            $policyDetails->selected_quote_id = $data['excessInsuranceHiddenQuoteId'];
            $policyDetails->quotation_product_id = $data['excessInsuranceHiddenInputId'];
            $policyDetails->policy_number = $data['excessInsuranceNumber'];
            $policyDetails->carrier = $data['excessInsuranceCarrierInput'];
            $policyDetails->market = $data['excessInsuranceMarketInput'];
            $policyDetails->payment_mode = $data['excessInsurancePaymentTermInput'];
            $policyDetails->effective_date = $data['excessInsuranceEffectiveDate'];
            $policyDetails->expiration_date = $data['excessInsuranceExpirationDate'];
            $policyDetails->status = 'issued';
            $policyDetails->media_id = $mediaId;

            if($quotationProduct->status == 20){
                $previousPolicy = PolicyDetail::where('quotation_product_id', $quotationProduct->id)->where('status', 'Renewal Request To Bind')->get();
                foreach($previousPolicy as $policy){
                    $policy->status = 'old policy';
                    $policy->save();
                }
                $policyDetails->status = 'renewal issued';
                $quotationProduct->status = 8;
                $quotationProduct->save();
            }else{
                $policyDetails->status = 'issued';
                $quotationProduct->status = 8;
                $quotationProduct->save();
            }

            $policyDetails->save();

            $excessLiability = new ExcessLiabilityInsurancePolicy();
            $excessLiability->policy_details_id = $policyDetails->id;
            $excessLiability->is_umbrella_liability = $request->has('excessInsuranceUmbrellaLiabl') ? '1' : '0';
            $excessLiability->is_excess_liability = $request->has('excessInsuranceExcessLiability') ? '1' : '0';
            $excessLiability->is_occur = $request->has('excessInsuranceOccur') ? '1' : '0';
            $excessLiability->is_claims_made = $request->has('excessInsuranceClaimsMade') ? '1' : '0';
            $excessLiability->is_ded = $request->has('excessInsuranceDed') ? '1' : '0';
            $excessLiability->is_retention = $request->has('excessInsuranceRetention') ? '1' : '0';
            $excessLiability->is_addl_insd = $request->has('excessInsuranceAddlInsd') ? '1' : '0';
            $excessLiability->is_subr_wvd = $request->has('excessInsuranceSubrWvd') ? '1' : '0';
            $excessLiability->each_occurrence = $data['excessInsuranceEachOccurrence'];
            $excessLiability->aggregate = $data['excessInsuranceAggregate'];
            $excessLiability->save();

            if(isset($data['newBlankLimits']) && isset($data['newBlankValue'])){
                $blankLimits = $data['newBlankLimits'];
                $blankValues = $data['newBlankValue'];
                foreach($blankLimits as $key => $limit){
                    if(isset($blankValues[$key])){
                        $value = $blankValues[$key];
                        $policyAdditionalValue = new PolicyAdditionalValue();
                        $policyAdditionalValue->policy_details_id = $policyDetails->id;
                        $policyAdditionalValue->name = $limit;
                        $policyAdditionalValue->value = $value;
                        $policyAdditionalValue->save();
                    }
                }
            }

            $quotationProduct = QuotationProduct::find($data['excessInsuranceHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            $quoteComparison = SelectedQuote::find($data['excessInsuranceHiddenQuoteId']);
            $quoteComparison->quote_no = $data['excessInsuranceNumber'];
            $quoteComparison->save();

            DB::commit();
            return response()->json(['message' => 'Excess Liability Insurance Policy has been saved successfully'], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
