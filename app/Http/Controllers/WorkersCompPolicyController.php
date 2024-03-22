<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use App\Models\PolicyAdditionalValue;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\WorkersCompPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WorkersCompPolicyController extends Controller
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
            $directoryPath = public_path('backend/assets/attacedFiles/binding/workers-comp-policy');
            $type = $file->getClientMimeType();
            $size = $file->getSize();
            if(!File::isDirectory($directoryPath)){
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $file->move($directoryPath, $basename);
            $filepath = 'backend/assets/attacedFiles/binding/workers-comp-policy' . $basename;

            $metadata = new Metadata();
            $metadata->basename = $basename;
            $metadata->filename = $basename;
            $metadata->filepath = $filepath;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();
            $mediaId = $metadata->id;

            $policyDetails = new PolicyDetail();
            $policyDetails->quotation_product_id = $data['workersCompensationHiddenInputId'];
            $policyDetails->policy_number = $data['workersCompensationPolicyNumber'];
            $policyDetails->carrier = $data['workersCompensationCarrierInput'];
            $policyDetails->market = $data['workersCompensationMarketInput'];
            $policyDetails->payment_mode = $data['workersCompensationPaymentTermInput'];
            $policyDetails->effective_date = $data['workersCompensationEffectiveDate'];
            $policyDetails->expiration_date = $data['workersCompensationExpirationDate'];
            $policyDetails->status = 'issued';
            $policyDetails->media_id = $mediaId;
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

            $workerCompensationPolicy = new WorkersCompPolicy();
            $workerCompensationPolicy->policy_details_id = $policyDetails->id;
            $workerCompensationPolicy->is_subr_wvd = $request->has('workersCompSubrWvd') ? '1' : '0';
            $workerCompensationPolicy->is_per_statute = $request->has('workersPerstatute') ? '1' : '0';
            $workerCompensationPolicy->el_each_accident = $data['elEachAccident'];
            $workerCompensationPolicy->el_disease_each_employee = $data['elDiseasePolicyLimit'];
            $workerCompensationPolicy->el_disease_policy_limit = $data['elDiseaseEachEmployee'];
            $workerCompensationPolicy->save();

            $quotationProduct = QuotationProduct::find($data['workersCompensationHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            $quoteComparison = QuoteComparison::find($data['workersCompensationHiddenQuoteId']);
            $quoteComparison->quote_no = $data['workersCompensationHiddenQuoteId'];
            $quoteComparison->save();

            DB::commit();
            return response()->json(['success' => 'Workers Compensation Policy has been added successfully'], 200);
        }catch(\Exception $e){
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