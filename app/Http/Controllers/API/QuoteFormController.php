<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Metadata;
use App\Models\QuoteForm;
use Illuminate\Http\Request;
use App\Models\SelectedQuote;
use App\Models\QuoteComparison;
use App\Models\PricingBreakdown;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SelectedPricingBreakDown;
use Illuminate\Support\Facades\File;
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

            $request->validate([
                'file_name' => 'required|string',
                'file_type' => 'required|string',
                'file_content' => 'required|string',
            ]);

            $fileContent = base64_decode($request->input('file_content')); // Decode the Base64 string
            $fileName = $request->input('file_name');
            $directoryPath = public_path('backend/assets/attacedFiles/binding/general-liability-insurance');

            // Create the directory if it doesn't exist
            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            // Create the full path where the file will be saved
            $filePath = $directoryPath . '/' . $fileName;

            // Save the decoded file content to the specified path
            File::put($filePath, $fileContent);

            // Get the metadata
            $type = mime_content_type($filePath); // Get the MIME type of the file
            $size = filesize($filePath); // Get the file size

            // Save metadata to the database
            $metadata = new Metadata();
            $metadata->basename = $fileName;
            $metadata->filename = $fileName;
            $metadata->filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $fileName;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

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
            $quoteComparison->media()->sync($metadata->id);

            $seletedPricingBreakDown = new SelectedPricingBreakDown();
            $seletedPricingBreakDown->fill($data);
            $seletedPricingBreakDown->save();

            $data['pricing_breakdown_id'] = $seletedPricingBreakDown->id;

            $selectedQuote = new SelectedQuote();
            $selectedQuote->fill($data);
            $selectedQuote->save();
            $selectedQuote->media()->sync($metadata->id);

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
