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
        try{
            DB::beginTransaction();

            $data = $request->all();

            $request->validate([
                'file_name' => 'required|string',
                'file_type' => 'required|string',
                'file_content' => 'required|string',
            ]);

            $fileContent = base64_decode($data['policy_file_content']);
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

            $metadata = new Metadata();
            $metadata->basename = $fileName;
            $metadata->filename = $fileName;
            $metadata->filepath = 'backend/assets/attacedFiles/binding/general-liability-insurance/' . $fileName;
            $metadata->type = $type;
            $metadata->size = $size;
            $metadata->save();

            $policyDetail = new PolicyDetail();
            $policyDetail->quotation_product_id = $data['quotation_product_id'];
            $policyDetail->selected_quote_id = $data['selected_quote_id'];
            $policyDetail->policy_number = $data['policy_number'];
            $policyDetail->carrier = $data['carrier'];
            $policyDetail->market = $data['market'];
            $policyDetail->payment_mode = $data['payment_mode'];
            $policyDetail->effective_date = $data['effective_date'];
            $policyDetail->expiration_date = $data['expiration_date'];
            $policyDetail->status = "issued";
            $policyDetail->media_id = $metadata->id;
            $policyDetail->save();

            $product = QuotationProduct::find($policyDetail->quotation_product_id);
            if($product->product == 'General Liability'){
                $this->storeGeneralLiability($policyDetail->id, $data);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Policy Detail Created Successfully',
                'data' => $policyDetail,
                'status' => 200
            ], 200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Policy Detail Creation Failed',
                'data' => $policyDetail,
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
