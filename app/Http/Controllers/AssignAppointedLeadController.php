<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssignAppointedLeadController extends Controller
{
    //
    public function index(Request $request)
    {
        $userProfile = new UserProfile();
        $apptaker = $userProfile->apptaker();
        $quoters = $userProfile->qouter();
        $userProfiles = $userProfile->userProfiles();
        if($request->ajax())
        {
            $leads = new Lead();
            $appointedLeads = $leads->getAppointedLeads();
            $appointedLeadsIds = $appointedLeads->pluck('id');
            $generalInformationIds = [];
            $products = [];
            foreach($appointedLeadsIds as $appointedLeadsId)
            {
                $generalInformationId = GeneralInformation::getIdByLeadId($appointedLeadsId);
                if($generalInformationId !== null){
                    array_push($generalInformationIds, $generalInformationId);
                }
            }
            if($generalInformationIds !== null){
                foreach($generalInformationIds as $generalInformationId){
                    $product = GeneralInformation::getProductByGeneralInformationId($generalInformationId);
                    array_push($products, $product);
                }
            }
            $index = 0;
            return DataTables::of($appointedLeads)
                   ->addIndexColumn()
                   ->addColumn('products', function($row) use (&$products, &$index){
                    $productGroups = array_chunk($products[$index++], 3);
                    $containers = [];

                    foreach ($productGroups as $group) {
                        $spans = array_map(function($product) {
                            return "<span class='badge bg-info permission-badge'><h6>{$product}</h6></span>";
                        }, $group);
                        $containers[] = '<div>' . implode(' ', $spans) . '</div>';
                    }
                    return implode('', $containers);
                   })
                   ->addColumn('current_user', function($appointedLeads){
                          $userProfile = $appointedLeads->userProfile->first();
                          $currentUserName = $userProfile ? $userProfile->fullAmericanName(): 'N/A';
                          return $currentUserName;
                     })
                   ->rawColumns(['products'])
                   ->make(true);
        }
        return view('leads.quotation_leads.assign-appointed-leads', compact('quoters', 'userProfiles'));
    }
    public function assignAppointedLead(Request $request)
    {

    }
}
