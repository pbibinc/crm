<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\QuoteForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
}
