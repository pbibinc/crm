<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessOwnersPolicyDetails;
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
class BussinessOwnersPolicyDetailsController extends Controller
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

            $policyDetails = new PolicyDetail();
            $policyDetails->selected_quote_id = $data['businessOwnersHiddenQuoteId'];
            $policyDetails->quotation_product_id = $data['businessOwnersHiddenInputId'];
            $policyDetails->policy_number = $data['businessOwnersNumber'];
            $policyDetails->carrier = $data['businessOwnersCarrierInput'];
            $policyDetails->market = $data['businessOwnersMarketInput'];
            $policyDetails->payment_mode = $data['businessOwnersPaymentTermInput'];
            $policyDetails->effective_date = $data['businessOwnersEffectiveDate'];
            $policyDetails->expiration_date = $data['businessOwnersExpirationDate'];
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

            $businessOwnersPolicyDetails = new BusinessOwnersPolicyDetails();
            $businessOwnersPolicyDetails->policy_details_id = $policyDetails->id;
            $businessOwnersPolicyDetails->is_addl_insd = $request->has('businessOwnersAddlInsd') ? '1' : '0';
            $businessOwnersPolicyDetails->is_subr_wvd = $request->has('businessOwnersSubrWvd') ? '1' : '0';
            $businessOwnersPolicyDetails->save();

            $quotationProduct = QuotationProduct::find($data['businessOwnersHiddenInputId']);
            $quotationProduct->status = 8;
            $quotationProduct->save();

            $quotationComparison = SelectedQuote::find($data['businessOwnersHiddenQuoteId']);
            $quotationComparison->quote_no = $data['businessOwnersNumber'];
            $quotationComparison->save();

            DB::commit();
            return response()->json(['success' => 'Business Owners Policy Details has been saved successfully']);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
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