<?php

namespace App\Http\Controllers\API;

use App\Models\PolicyDetail;

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

}


?>