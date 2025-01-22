<?php

namespace App\Http\Controllers\API;


use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesPolicyDetails;
use App\Models\Metadata;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Switch_;

class PoliciesDataController extends BaseController
{

    public function getPolicyDetailInstance($policyId)
    {
        $policyDetail = PolicyDetail::find($policyId);
        if (is_null($policyDetail)) {
            return $this->sendError('Policy Detail not found.');
        }
        return $this->sendResponse($policyDetail->toArray(), 'Policy Detail retrieved successfully.');

    }

    public function getSampleData()
    {
        $totalSales = 300;
        $directNew = 80;
        $renewalSales =120;
        $directRewrite = 100;
        return response()->json([
            'totalSales' => $totalSales,
            'directNew' => $directNew,
            'renewalSales' => $renewalSales,
            'directRewrite' => $directRewrite
        ]);
    }

    public function getPolicyInformation($policyId)
    {
        $policyDetail = PolicyDetail::find($policyId);
        $quotationProduct = QuotationProduct::find($policyDetail->quotation_product_id);
        if($quotationProduct->product == 'General Liability'){
            $generalLiabilty = GeneralLiabilities::find($policyDetail->id);
            return response()->json([
                'policyDetail' => $policyDetail,
                'generalLiabilty' => $generalLiabilty
            ]);
        }
    }

    public function storePolicy(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            Log::info("policy" . json_encode($data));
            // Ensure that the incoming request is an array of policies
            if (!is_array($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request format. Expected an array of policies.',
                    'status' => 400
                ], 400);
            }

            $createdPolicies = [];

            foreach ($data as $value) {
                // Validate each policy object inside the array
                $validator = Validator::make($value, [
                    'file_name' => 'required|string',
                    'file_type' => 'required|string',
                    'policy_file_content' => 'required|string',
                    'quotation_product_id' => 'required|integer',
                    'selected_quote_id' => 'required|integer',
                    'policy_number' => 'required|string',
                    'carrier' => 'required|string',
                    'market' => 'required|string',
                    'payment_mode' => 'required|string',
                    'effective_date' => 'required|date',
                    'expiration_date' => 'required|date',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                        'status' => 422
                    ], 422);
                }

                // Decode the base64 file content and save the file
                $fileContent = base64_decode($value['policy_file_content']);
                $fileName = $value['file_name'];
                $directoryPath = public_path('backend/assets/attachedFiles/binding/general-liability-insurance');

                if (!File::isDirectory($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $filePath = $directoryPath . '/' . $fileName;
                File::put($filePath, $fileContent);

                // Create metadata
                $type = mime_content_type($filePath);
                $size = filesize($filePath);

                $metadata = new Metadata();
                $metadata->basename = $fileName;
                $metadata->filename = $fileName;
                $metadata->filepath = 'backend/assets/attachedFiles/binding/general-liability-insurance/' . $fileName;
                $metadata->type = $type;
                $metadata->size = $size;
                $metadata->save();

                // Create Policy Detail
                $policyDetail = new PolicyDetail();
                $policyDetail->quotation_product_id = $value['quotation_product_id'];
                $policyDetail->selected_quote_id = $value['selected_quote_id'];
                $policyDetail->policy_number = $value['policy_number'];
                $policyDetail->carrier = $value['carrier'];
                $policyDetail->market = $value['market'];
                $policyDetail->payment_mode = $value['payment_mode'];
                $policyDetail->effective_date = $value['effective_date'];
                $policyDetail->expiration_date = $value['expiration_date'];
                $policyDetail->status = $value['status'];
                $policyDetail->media_id = $metadata->id;
                $policyDetail->save();

                // Check if the product is General Liability
                $product = QuotationProduct::find($policyDetail->quotation_product_id);
                if ($product && $product->product == 'General Liability') {
                    $this->storeGeneralLiability($policyDetail->id, $value);
                }

                // Store created policy in array
                $createdPolicies[] = $policyDetail;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Policy Details Created Successfully',
                'data' => $createdPolicies,
                'status' => 201
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Policy Detail Creation Failed: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    private function storeGeneralLiability($policyDetailsId, $data)
    {
        $generalLiability = new GeneralLiabilities();
        $generalLiability->policy_details_id = $policyDetailsId;
        $generalLiability->is_commercial_gl = $data['is_commercial_gl'];
        $generalLiability->is_occur = $data['is_occur'];
        $generalLiability->is_policy = $data['is_policy'];
        $generalLiability->is_project = $data['is_project'];
        $generalLiability->is_loc = $data['is_loc'];
        $generalLiability->is_additional_insd = $data['is_additional_insd'];
        $generalLiability->is_subr_wvd = $data['is_subr_wvd'];
        $generalLiability->is_claims_made = $data['is_claims_made'];
        $generalLiability->each_occurence = $data['each_occurence'];
        $generalLiability->damage_to_rented = $data['damage_to_rented'];
        $generalLiability->medical_expenses = $data['medical_expenses'];
        $generalLiability->per_adv_injury = $data['per_adv_injury'];
        $generalLiability->gen_aggregate = $data['gen_aggregate'];
        $generalLiability->product_comp = $data['product_comp'];
        $generalLiability->save();
    }

}


?>