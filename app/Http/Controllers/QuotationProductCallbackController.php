<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QuotationProduct;
use App\Models\QuotationProductCallback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotationProductCallbackController extends Controller
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

            // $callBack = new QuotationProductCallback();
            // $callBack->quotation_product_id = $request->id;
            // $callBack->date_time = $request->callbackDateTime;
            // $callBack->remarks = $request->remarks;
            // $callBack->save();


            $quotationProduct = QuotationProduct::find($request->id);
            $quotationProduct->callback_date = $request->callbackDateTime;
            $quotationProduct->save();

            DB::commit();
            return response()->json(['success' => 'Callback successfully added'], 200);
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
        // $quotationCallback = QuotationProductCallback::where('quotation_product_id', $id)->first();
        $quotationCallback = QuotationProduct::find($id);
        return response()->json(['quotationCallback' => $quotationCallback]);
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
            // $callBack = QuotationProductCallback::find($id);
            // $callBack->quotation_product_id = $request->id;
            // $callBack->date_time = $request->callbackDateTime;
            // $callBack->remarks = $request->remarks;
            // $callBack->save();


            $quotationProduct = QuotationProduct::find($request->id);
            $quotationProduct->callback_date = $request->callbackDateTime;
            $quotationProduct->save();

            DB::commit();
            return response()->json(['success' => 'Callback successfully added'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
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