<?php

namespace App\Http\Controllers\API;

use App\Models\GeneralLiabilities;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
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

}


?>