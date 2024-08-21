<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BuildersRiskPolicyDetails;
use App\Models\Metadata;
use App\Models\PolicyAdditionalValue;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
class BuildersRiskPolicyDetailsController extends Controller
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
        //
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

            //code for saving product
            $quotationProduct = QuotationProduct::find($data['buildersRiskHiddenInputId']);

            $policyDetails = new PolicyDetail();
            $policyDetails->selected_quote_id = $data['buildersRiskHiddenQuoteId'];
            $policyDetails->quotation_product_id = $data['buildersRiskHiddenInputId'];
            $policyDetails->policy_number = $data['buildersRiskPolicyNumber'];
            $policyDetails->carrier = $data['buildersRiskCarrierInput'];
            $policyDetails->market = $data['buildersRiskMarketInput'];
            $policyDetails->payment_mode = $data['buildersRiskPaymentTermInput'];
            $policyDetails->effective_date = $data['buildersRiskEffectiveDate'];
            $policyDetails->expiration_date = $data['buildersRiskExpirationDate'];
            $policyDetails->media_id = $mediaId;
            if($quotationProduct->status == 20 ){
                $previousPolicy = PolicyDetail::where('quotation_product_id', $quotationProduct->id)->where('status', 'Renewal Request To Bind')->get();
                foreach($previousPolicy as $policy){
                    $policy->status = 'old policy';
                    $policy->save();
                }
                $policyDetails->status = 'renewal issued';
                $quotationProduct->status = 8;
                $quotationProduct->save();
            }else if($quotationProduct->status == 26){
                $policyDetails->status = 'recovered policy issued';
                $quotationProduct->status = 8;
                $quotationProduct->save();
            }else{
                $policyDetails->status = 'issued';
                $quotationProduct->status = 8;
                $quotationProduct->save();
            }
            $policyDetails->save();

            $buildersRiskPolicyDetails = new BuildersRiskPolicyDetails();
            $buildersRiskPolicyDetails->policy_details_id = $policyDetails->id;
            $buildersRiskPolicyDetails->is_subr_wvd = $request->has('buildersRiskAddlInsd') ? '1' : '0';
            $buildersRiskPolicyDetails->is_addl_insd = $request->has('buildersRiskSubrWvd') ? '1' : '0';
            $buildersRiskPolicyDetails->save();

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

            $quotationProduct = QuotationProduct::find($data['buildersRiskHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            $quoteComparison = SelectedQuote::find($data['buildersRiskHiddenQuoteId']);
            $quoteComparison->quote_no = $data['buildersRiskPolicyNumber'];
            $quoteComparison->save();

            DB::commit();
            return response()->json(['message' => 'Builders Risk Policy Details added successfully'], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
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
        try{
            DB::beginTransaction();
            $data = $request->all();


            $policyDetails = PolicyDetail::find($id);
            $policyDetails->policy_number = $data['buildersRiskPolicyNumber'];
            $policyDetails->carrier = $data['buildersRiskCarrierInput'];
            $policyDetails->market = $data['buildersRiskMarketInput'];
            $policyDetails->payment_mode = $data['buildersRiskPaymentTermInput'];
            $policyDetails->effective_date = $data['buildersRiskEffectiveDate'];
            $policyDetails->expiration_date = $data['buildersRiskExpirationDate'];
            $policyDetails->save();

            $buildersRiskPolicyDetails = BuildersRiskPolicyDetails::where('policy_details_id', $id)->first();
            $buildersRiskPolicyDetails->policy_details_id = $policyDetails->id;
            $buildersRiskPolicyDetails->is_subr_wvd = $request->has('buildersRiskAddlInsd') ? '1' : '0';
            $buildersRiskPolicyDetails->is_addl_insd = $request->has('buildersRiskSubrWvd') ? '1' : '0';
            $buildersRiskPolicyDetails->save();

            if(isset($data['newBlankLimits']) && isset($data['newBlankValue'])){
                $blankLimits = $data['newBlankLimits'];
                $blankValues = $data['newBlankValue'];
                $oldValued = PolicyAdditionalValue::where('policy_details_id', $id)->get();
                foreach($oldValued as $oldValue){
                    $oldValue->delete();
                }
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


            DB::commit();
            return response()->json(['message' => 'Builders Risk Policy Details updated successfully'], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
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