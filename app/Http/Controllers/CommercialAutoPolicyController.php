<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommercialAutoPolicy;
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

class CommercialAutoPolicyController extends Controller
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
            $data = $request->all();
            DB::beginTransaction();

            $file = $data['file'];
            $basename = $file->getClientOriginalName();
            $directoryPath = public_path('backend/assets/attacedFiles/binding/commercial-auto-policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/binding/commercial-auto-policy' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $quotationProduct = QuotationProduct::find($data['commercialAutoHiddenInputId']);

            $policyDetails = new PolicyDetail();
            $policyDetails->selected_quote_id = $data['commercialAutoHiddenQuoteId'];
            $policyDetails->quotation_product_id = $data['commercialAutoHiddenInputId'];
            $policyDetails->policy_number = $data['commerciarlAutoPolicyNumber'];
            $policyDetails->carrier = $data['commercialAutoCarrierInput'];
            $policyDetails->market = $data['commercialAutoMarketInput'];
            $policyDetails->payment_mode = $data['commercialAutoPaymentTermInput'];
            $policyDetails->effective_date = $data['commercialAutoEffectiveDate'];
            $policyDetails->expiration_date = $data['commercialAutoExpirationDate'];
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

            $commercialAutoPolicy = new CommercialAutoPolicy();
            $commercialAutoPolicy->policy_details_id = $policyDetails->id;
            $commercialAutoPolicy->is_any_auto =  $request->has('anyAuto') ? '1' : '0';
            $commercialAutoPolicy->is_owned_auto =  $request->has('ownedAuto') ? '1' : '0';
            $commercialAutoPolicy->is_scheduled_auto =  $request->has('scheduledAuto') ? '1' : '0';
            $commercialAutoPolicy->is_hired_auto =  $request->has('hiredAutos') ? '1' : '0';
            $commercialAutoPolicy->is_non_owned_auto =  $request->has('nonOwned') ? '1' : '0';
            $commercialAutoPolicy->is_addl_insd =  $request->has('commercialAddlInsd') ? '1' : '0';
            $commercialAutoPolicy->is_subr_wvd =  $request->has('commercialAutoSubrWvd') ? '1' : '0';
            $commercialAutoPolicy->combined_single_unit = $data['combineUnit'];
            $commercialAutoPolicy->bi_per_person = $data['biPerPerson'];
            $commercialAutoPolicy->bi_per_accident = $data['biPerAccident'];
            $commercialAutoPolicy->property_damage = $data['propertyDamage'];
            $commercialAutoPolicy->save();

            //code for saving product
            $quotationProduct = QuotationProduct::find($data['commercialAutoHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            //code for quoation
            $quoteComparison = SelectedQuote::find($data['commercialAutoHiddenQuoteId']);
            $quoteComparison->quote_no = $data['commerciarlAutoPolicyNumber'];
            $quoteComparison->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Commercial Auto Policy has been created successfully']);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
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
            $policyDetails->policy_number = $data['commerciarlAutoPolicyNumber'];
            $policyDetails->carrier = $data['commercialAutoCarrierInput'];
            $policyDetails->market = $data['commercialAutoMarketInput'];
            $policyDetails->payment_mode = $data['commercialAutoPaymentTermInput'];
            $policyDetails->save();

            $commercialAutoPolicy = CommercialAutoPolicy::where('policy_details_id', $id)->first();
            $commercialAutoPolicy->is_any_auto =  $request->has('anyAuto') ? '1' : '0';
            $commercialAutoPolicy->is_owned_auto =  $request->has('ownedAuto') ? '1' : '0';
            $commercialAutoPolicy->is_scheduled_auto =  $request->has('scheduledAuto') ? '1' : '0';
            $commercialAutoPolicy->is_hired_auto =  $request->has('hiredAutos') ? '1' : '0';
            $commercialAutoPolicy->is_non_owned_auto =  $request->has('nonOwned') ? '1' : '0';
            $commercialAutoPolicy->is_addl_insd =  $request->has('commercialAddlInsd') ? '1' : '0';
            $commercialAutoPolicy->is_subr_wvd =  $request->has('commercialAutoSubrWvd') ? '1' : '0';
            $commercialAutoPolicy->combined_single_unit = $data['combineUnit'];
            $commercialAutoPolicy->bi_per_person = $data['biPerPerson'];
            $commercialAutoPolicy->bi_per_accident = $data['biPerAccident'];
            $commercialAutoPolicy->property_damage = $data['propertyDamage'];
            $commercialAutoPolicy->save();

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
            return response()->json(['status' => 'success', 'message' => 'Commercial Auto Policy has been updated successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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