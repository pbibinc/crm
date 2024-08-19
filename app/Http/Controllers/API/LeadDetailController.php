<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Lead;
use App\Models\UnitedState;
use App\Models\UserProfile;
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
        $activityId = Cache::get('activity_id');
        $userProfileId = UserProfile::where('user_id', Cache::get('user_id'))->first()->id;
        $lead = Lead::find($leadId);
        if (is_null($lead)) {
            return $this->sendError('Lead not found.');
        }
        $lead->productId = $productId ? $productId : null;
        if($productId){
            $lead->products = $lead->getProducts() ;
        }
        $lead->userProfileId = $userProfileId ? $userProfileId : null;
        $lead->activityId = $activityId ? $activityId : null;
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

    public function getLeadInstanceById($id)
    {
        $lead = Lead::find($id);
        if (is_null($lead)) {
            return $this->sendError('Lead not found.');
        }
        return $this->sendResponse($lead->toArray(), 'Lead retrieved successfully.');
    }

    public function getAppointedSalesPerPerson()
    {
        $userName = ['Vincent Eniosas', 'RJ Vibar', 'Maechael Elchico'];
        $appointedSales = ['25', '30', '35'];
        $department = ['Sales', 'Sales', 'Sales'];
        $appointedSalesPerPerson = [];

        foreach ($userName as $key => $value) {
            $appointedSalesPerPerson[] = [
                'username' => $value,
                'appointed' => $appointedSales[$key],
                'department' => $department[$key]
            ];
        }

        return $this->sendResponse($appointedSalesPerPerson, 'Appointed Sales Per Person retrieved successfully.');
    }
}

?>