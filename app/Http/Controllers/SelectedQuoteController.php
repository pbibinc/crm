<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PricingBreakdown;
use App\Models\QuoationMarket;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use App\Models\SelectedPricingBreakDown;
use App\Models\SelectedQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SelectedQuoteController extends Controller
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
        try {
            DB::beginTransaction();
            $data = $request->all();
            $quoteComparison = QuoteComparison::find($data['id']);
            $quotationProduct = QuotationProduct::find($quoteComparison->quotation_product_id);

            // $selectedQuotes = SelectedQuote::where('quotation_product_id', $quotationProduct->id)->get();
            // foreach ($selectedQuotes as $selectedQuote) {
            //     $selectedQuote->recommended = 3;
            //     $selectedQuote->save();
            // }
            if (!$quoteComparison) {
                throw new \Exception("Quote Comparison not found.");
            }

            $pricingBreakdown = PricingBreakdown::find($quoteComparison->pricing_breakdown_id);


            if (!$pricingBreakdown) {
                throw new \Exception("Pricing Breakdown not found.");
            }

            $mediaIds = $quoteComparison->media->pluck('id');

            SelectedPricingBreakDown::create($pricingBreakdown->toArray());
            $selectedQuote = SelectedQuote::create($quoteComparison->toArray());
            $quotationProduct->update(['selected_quote_id' => $selectedQuote->id]);
            $selectedQuote->media()->attach($mediaIds);

            DB::commit();
            return response()->json(['success' => 'Quote comparison stored successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in storing selected quote', [$e->getMessage()]);
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
        $data = SelectedQuote::find($id);
        $media = $data->media;
        $pricingBreakdown = $data->SelectedPricingBreakDown;
        $market = QuoationMarket::find($data->quotation_market_id);
        return response()->json(['data' => $data, 'media' => $media, 'pricingBreakdown' => $pricingBreakdown, 'market' => $market]);
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

        if($request->ajax())
        {
            try{
                DB::beginTransaction();
                $request->input('selectedProduct_hidden_id');

                 //declaring variable for quocte comparison
                 $id = $request->input('selectedProduct_hidden_id');
                 $marketId = $request->input('selectedMarketDropdown');
                 $quotationNo = $request->input('selectedQuoteNo');
                 $fullPayment = $request->input('selectedFullPayment');
                 $downPayment = $request->input('selectedDownPayment');
                 $monthlyPayment = $request->input('selectedMonthlyPayment');
                 $numberOfPayment = $request->input('selectedNumberOfPayment');
                 $brokerFee = $request->input('selectedBrokerFee');
                 $reccomended = $request->input('selectedRecommended');
                 $productId = $request->input('selectedProductId');
                 $currentMarketId = $request->input('selectedCurrentMarketId');
                 $effectiveDate = $request->input('selectedEffectiveDate');
                 $sender = $request->input('selectedSender');

                //declaring variable for pricing breakdown
                $premmium = $request->input('selectedPremium');
                $endorsements = $request->input('selectedEndorsements');
                $policyFee = $request->input('selectedPolicyFee');
                $inspectionFee = $request->input('selectedInspectionFee');
                $stampingFee = $request->input('selectedStampingFee');
                $surplusLinesTax = $request->input('selectedSurplusLinesTax');
                $placementFee = $request->input('selectedPlacementFee');
                $miscellaneousFee = $request->input('selectedMiscellaneousFee');

                $quoteComparison = SelectedQuote::find($id);
                $pricingBreakDown = SelectedPricingBreakDown::find($quoteComparison->pricing_breakdown_id);
                $exists = SelectedQuote::where('quotation_market_id', $marketId)->where('quotation_product_id', $productId)->where('id', '!=', $id)->exists();

                if(!$exists || $currentMarketId == $marketId){
                    if($sender == 'broker'){
                        $quoteComparison->full_payment = $request->hiddenFullpayment;
                        $quoteComparison->down_payment = $request->hiddenDownpayment;
                        $quoteComparison->broker_fee = $request->brokerFee;
                        $quoteComparison->save();

                        $pricingBreakDown->broker_fee = $brokerFee;
                        $pricingBreakDown->save();
                    }else{
                     if($fullPayment && $downPayment && $monthlyPayment && $brokerFee){
                        $quoteComparison->quotation_product_id = $productId;
                        $quoteComparison->quotation_market_id = $marketId;
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->number_of_payments = $numberOfPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->recommended = $reccomended;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }else{
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->number_of_payments = $numberOfPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }
                     $quoteComparison->save();


                     $pricingBreakDown->premium = $premmium;
                     $pricingBreakDown->endorsements = $endorsements;
                     $pricingBreakDown->policy_fee = $policyFee;
                     $pricingBreakDown->inspection_fee = $inspectionFee;
                     $pricingBreakDown->stamping_fee = $stampingFee;
                     $pricingBreakDown->broker_fee = $brokerFee;
                     $pricingBreakDown->surplus_lines_tax = $surplusLinesTax;
                     $pricingBreakDown->placement_fee = $placementFee;
                     $pricingBreakDown->miscellaneous_fee = $miscellaneousFee;
                     $pricingBreakDown->save();

                    }
                DB::commit();
                return response()->json(['success' => 'Quote comparison updated successfully']);
                }else{
                    return response()->json(['error' => 'This market is already added'], 422);
                }

            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in updating quote comparison', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
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

    public function updateSelectedQuote(Request $request)
    {
        if($request->ajax())
        {
            try{
                DB::beginTransaction();
                $request->input('selectedProduct_hidden_id');

                 //declaring variable for quocte comparison
                 $selectedQuoteId = $request->input('selectedQuoteId');
                 $id = $request->input('selectedProduct_hidden_id');
                 $marketId = $request->input('selectedMarketDropdown');
                 $quotationNo = $request->input('selectedQuoteNo');
                 $fullPayment = $request->input('selectedFullPayment');
                 $downPayment = $request->input('selectedDownPayment');
                 $monthlyPayment = $request->input('selectedMonthlyPayment');
                 $numberOfPayment = $request->input('selectedNumberOfPayment');
                 $brokerFee = $request->input('selectedBrokerFee');
                 $reccomended = $request->input('selectedRecommended');
                 $productId = $request->input('selectedProductId');
                 $currentMarketId = $request->input('selectedCurrentMarketId');
                 $effectiveDate = $request->input('selectedEffectiveDate');
                 $sender = $request->input('selectedSender');

                //declaring variable for pricing breakdown
                $premmium = $request->input('selectedPremium');
                $endorsements = $request->input('selectedEndorsements');
                $policyFee = $request->input('selectedPolicyFee');
                $inspectionFee = $request->input('selectedInspectionFee');
                $stampingFee = $request->input('selectedStampingFee');
                $surplusLinesTax = $request->input('selectedSurplusLinesTax');
                $placementFee = $request->input('selectedPlacementFee');
                $miscellaneousFee = $request->input('selectedMiscellaneousFee');


                $quoteComparison = SelectedQuote::find($selectedQuoteId);
                $pricingBreakDown = SelectedPricingBreakDown::find($quoteComparison->pricing_breakdown_id);
                $exists = SelectedQuote::where('quotation_market_id', $marketId)->where('quotation_product_id', $productId)->where('id', '!=', $id)->exists();

                if(!$exists || $currentMarketId == $marketId){
                    if($sender == 'broker'){
                        $quoteComparison->full_payment = $request->hiddenFullpayment;
                        $quoteComparison->down_payment = $request->hiddenDownpayment;
                        $quoteComparison->broker_fee = $request->brokerFee;
                        $quoteComparison->save();

                        $pricingBreakDown->broker_fee = $brokerFee;
                        $pricingBreakDown->save();
                    }else{
                     if($fullPayment && $downPayment && $monthlyPayment && $brokerFee){
                        $quoteComparison->quotation_product_id = $productId;
                        $quoteComparison->quotation_market_id = $marketId;
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->number_of_payments = $numberOfPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->recommended = $reccomended;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }else{
                        $quoteComparison->full_payment = $fullPayment;
                        $quoteComparison->down_payment = $downPayment;
                        $quoteComparison->monthly_payment = $monthlyPayment;
                        $quoteComparison->number_of_payments = $numberOfPayment;
                        $quoteComparison->broker_fee = $brokerFee;
                        $quoteComparison->quote_no = $quotationNo;
                        $quoteComparison->effective_date = $effectiveDate;
                     }
                     $quoteComparison->save();


                     $pricingBreakDown->premium = $premmium;
                     $pricingBreakDown->endorsements = $endorsements;
                     $pricingBreakDown->policy_fee = $policyFee;
                     $pricingBreakDown->inspection_fee = $inspectionFee;
                     $pricingBreakDown->stamping_fee = $stampingFee;
                     $pricingBreakDown->broker_fee = $brokerFee;
                     $pricingBreakDown->surplus_lines_tax = $surplusLinesTax;
                     $pricingBreakDown->placement_fee = $placementFee;
                     $pricingBreakDown->miscellaneous_fee = $miscellaneousFee;
                     $pricingBreakDown->save();

                    }
                DB::commit();
                return response()->json(['success' => 'Quote comparison updated successfully']);
                }else{
                    return response()->json(['error' => 'This market is already added'], 422);
                }
            }catch(\Exception $e){
                DB::rollback();
                Log::error('Error in updating quote comparison', [$e->getMessage()]);
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    public function editSelectedQuote(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->input('id');
            $data = SelectedQuote::find($id);
            $media= $data->media;
            $pricingBreakdown = $data->PricingBreakdown;
            $market = QuoationMarket::find($data->quotation_market_id);
            $leads = $data->QuotationProduct->QuoteInformation->QuoteLead->leads;
            $generalInformation = $leads->generalInformation;
            return response()->json(['data' => $data, 'media' => $media, 'pricingBreakdown' => $pricingBreakdown, 'market' => $market, 'leads' => $leads, 'generalInformation' => $generalInformation]);
        }
    }

}