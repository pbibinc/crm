<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\PolicyAdditionalValue;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\ToolsEquipmentPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ToolsEquipmentPolicyController extends Controller
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
            $directoryPath = public_path('backend/assets/attacedFiles/binding/tools-equipment-policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/binding/tools-equipment-policy' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $policyDetails = new PolicyDetail();
            $policyDetails->quotation_product_id = $data['toolsEquipmentHiddenInputId'];
            $policyDetails->policy_number = $data['toolsEquipmentPolicyNumber'];
            $policyDetails->carrier = $data['toolsEquipmentCarrierInput'];
            $policyDetails->market = $data['toolsEquipmentMarketInput'];
            $policyDetails->payment_mode = $data['toolsEquipmentPaymentTermInput'];
            $policyDetails->effective_date = $data['toolsEquipmentEffectiveDate'];
            $policyDetails->expiration_date = $data['toolsEquipmentExpirationDate'];
            $policyDetails->media_id = $mediaId;
            $policyDetails->save();

            $toolsEquipmentPolicy = new ToolsEquipmentPolicy();
            $toolsEquipmentPolicy->policy_details_id = $policyDetails->id;
            $toolsEquipmentPolicy->is_subr_wvd = $request->has('toolsEquipmentSubrWvd') ? '1' : '0';
            $toolsEquipmentPolicy->is_addl_insd = $request->has('toolsEquipmentAddlInsd') ? '1' : '0';
            $toolsEquipmentPolicy->save();

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

            $quotationProduct = QuotationProduct::find($data['toolsEquipmentHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            $quoteComparison = QuoteComparison::find($data['toolsEquipmentHiddenQuoteId']);
            $quoteComparison->quote_no = $data['toolsEquipmentPolicyNumber'];
            $quoteComparison->save();

            DB::commit();
            return response()->json(['message' => 'Tools & Equipment Policy has been successfully added.'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
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