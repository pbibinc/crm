<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Lead;
use App\Models\UnitedState;
use Illuminate\Support\Facades\Cache;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class LeadDetailController extends BaseController
{
    public function index()
    {
        $lead = Lead::all();
        return $this->sendResponse($lead->toArray(), 'Lead retrieved successfully.');
    }
    public function show()
    {
        $leadId = Cache::get('lead_id');
        $productId = Cache::get('product_id');
        $lead = Lead::find($leadId);
        if (is_null($lead)) {
            return $this->sendError('Lead not found.');
        }
        $lead->productId = $productId ? $productId : null;
        return $this->sendResponse($lead->toArray(), 'Lead retrieved successfully.');
    }
    public function leadAddress()
    {
        $leadId = Cache::get('lead_id');
        $stateAbbr = Lead::find($leadId)->state_abbr;
        $leadAddress = UnitedState::where('state_abbr', $stateAbbr)->get();
        if(is_null($leadAddress)){
            return $this->sendError('State not found.');
        }
        return $this->sendResponse($leadAddress, 'State retrieved successfully.');
    }
}

?>