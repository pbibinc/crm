<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\QuoteForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PricingBreakdown;
use App\Models\QuoteComparison;
use App\Models\SelectedPricingBreakDown;
use App\Models\SelectedQuote;
use Illuminate\Support\Facades\Log;

class QuoteFormController extends Controller
{
    public function storeData(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $encodedData = json_encode($request->all());
                // DB::beginTransaction();
                $quoteForm = QuoteForm::create([
                    'data' => $encodedData,
                    'status' => 'Pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                // DB::commit();
                if ($quoteForm) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Quote form submitted successfully',
                        'data' => $quoteForm
                    ]);
                } else {
                    throw new \Exception('Form submission failed');
                }
            } else {
                throw new \Exception('Invalid request');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function storeQuoteInfo(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            $pricingBreakDown = PricingBreakdown::create([
                'premium' => $data['premium'],
                'endorsements' => $data['endorsements'],
                'policy_fee' => $data['policy_fee'],
                'inspection_fee' => $data['inspection_fee'],
                'stamping_fee' => $data['stamping_fee'],
                'surplus_lines_tax' => $data['surplus_lines_tax'],
                'placement_fee' => $data['placement_fee'],
                'broker_fee' => $data['broker_fee'],
                'miscellaneous_fee' => $data['miscellaneous_fee'],
            ]);


            $data['pricing_breakdown_id'] = $pricingBreakDown->id;

            $quoteComparison = new QuoteComparison();
            $quoteComparison->fill($data);
            $quoteComparison->save();

            $seletedPricingBreakDown = new SelectedPricingBreakDown();
            $seletedPricingBreakDown->fill($data);
            $seletedPricingBreakDown->save();

            $data['pricing_breakdown_id'] = $seletedPricingBreakDown->id;

            $selectedQuote = new SelectedQuote();
            $selectedQuote->fill($data);
            $selectedQuote->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $selectedQuote,
                'message' => 'Quote info stored successfully'
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to store quote info'
            ], 500);
        }
    }
}