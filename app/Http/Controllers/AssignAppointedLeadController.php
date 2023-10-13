<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $appointedLeadCount = Lead::getAppointedLeads()->count();
        $qoutingCount = QuotationProduct::quotingProduct()->count();
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
                    return '<div class="product-column">'. implode('', $containers) . '</div>';
                   })
                   ->addColumn('current_user', function($appointedLeads){
                          $userProfile = $appointedLeads->userProfile->first();
                          $currentUserName = $userProfile ? $userProfile->fullAmericanName(): 'N/A';
                          return $currentUserName;
                     })
                   ->addColumn('checkbox', function($appointedLeads) {
                        $userProfile = $appointedLeads->userProfile->first();
                        $currentUserId = $userProfile ? $userProfile->id : null;
                        $value = $appointedLeads->id . '_' . $currentUserId ;
                        return '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $value . '" />';
                    })
                   ->rawColumns(['products', 'checkbox'])
                   ->make(true);
        }
        return view('leads.quotation_leads.assign-appointed-leads', compact('quoters', 'userProfiles', 'appointedLeadCount', 'qoutingCount'));
    }
    public function assignAppointedLead(Request $request)
    {

        try{
            DB::beginTransaction();

            $combinedIds = $request->input('id');
            $products = $request->input('product');
            $combinedData = array_map(function($id, $product) {
                return ['id' => $id, 'product' => $product];
            }, $combinedIds, $products);
            $marketingSpecialistId = $request->input('marketSpecialistUserProfileId');
            $agentId = $request->input('agentUserProfileId');
            $userProfileId = $marketingSpecialistId ? $marketingSpecialistId : $agentId;
            if($userProfileId || $combinedIds){
                foreach($combinedData as $value){
                    list($leadsId, $userId) = explode('_', $value['id']);
                    $lead = Lead::find($leadsId);
                    $lead->status = 4;
                    $lead->save();
                    $qouteLead = $lead->quoteLead()->first();
                    if($qouteLead == null)
                    {
                        $qouteLead = new QuoteLead();
                        $qouteLead->user_profiles_id = $userProfileId;
                        $qouteLead->leads_id = $leadsId;
                        $qouteLead->save();

                        $quoteInformation = new QuoteInformation();
                        $quoteInformation->telemarket_id = $userId;
                        $quoteInformation->quoting_lead_id = $qouteLead->id;
                        $quoteInformation->status = 2;
                        $quoteInformation->remarks = ' ';
                        $quoteInformation->save();

                        foreach($value['product'] as $product){
                            $quotationProduct = new QuotationProduct();
                            $quotationProduct->quote_information_id = $quoteInformation->id;
                            $quotationProduct->product = $product;
                            $quotationProduct->status = 2;
                            $quotationProduct->save();
                        }
                    }else{
                        $qouteLead->user_profiles_id = $userProfileId;
                        $qouteLead->save();
                    }

                }
            }else{
                return response()->json(['error' => 'Please select a user profile']);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Assigning", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getDataTable(Request $request)
    {
        $marketSpecialistId = $request->input('marketSpecialistId');
        $accountProfileId = $request->input('accountProfileId');
        $userProfileId = $marketSpecialistId ? $marketSpecialistId : $accountProfileId;

        if($userProfileId){
           $leads =  Lead::getAssignQuoteLeadsByUserProfileId($userProfileId);
        }else{
            $leads = null;
        }

        if($request->ajax()){
            if($leads !== null){
                $data = $leads;
            }else{
                $data = [];
            }

            return DataTables::of($data)
                   ->addIndexColumn()
                   ->addColumn('checkbox', function($leads){
                        return '<input type="checkbox" name="leads_checkbox[]" class="leads_checkbox" value="' . $leads->id . '" />';
                    })
                   ->rawColumns(['checkbox'])
                   ->make(true);
        }
    }

    public function voidLeads(Request $request)
    {
        try{
            DB::beginTransaction();
            $leadsIds = $request->input('leadsId');
            foreach($leadsIds as $leadsId){
                $lead = Lead::find($leadsId);
                $lead->status = 3;
                $lead->save();

                $qouteLead = $lead->quoteLead()->first();
                $qouteLead->user_profiles_id = null;
                $qouteLead->save();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Voiding", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function redeployLeads(Request $request)
    {
        try{
            DB::beginTransaction();
            $leadsIds = $request->input('leadsId');
            $userProfileId = $request->input('userProfileId');
            foreach($leadsIds as $leadsId){
                $lead = Lead::find($leadsId);
                $qouteLead = $lead->quoteLead()->first();
                $qouteLead->user_profiles_id = $userProfileId;
                $qouteLead->save();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Redeploying", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
