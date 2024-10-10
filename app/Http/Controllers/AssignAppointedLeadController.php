<?php

namespace App\Http\Controllers;

use App\Events\AssignAppointedLeadEvent;
use App\Events\ReassignedAppointedLead;
use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\User;
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

        $qoutingCount = QuotationProduct::quotingProduct()->count();
        $lead = new Lead();
        $quoteLead = new QuoteLead();
        $appointedLeads = $lead->getAppointedLeads();
        $requestForQuoteProduct = QuotationProduct::where('status', 29)->count( );
        $appointedProducts =  $quoteLead->requestForQuoteAppointedProductByLeads($appointedLeads);
        $appointedLeadCount = $appointedLeads->count();
        $quotationProduct = new QuotationProduct();
        // $appointedProducts = $quotationProduct->appointedProduct();
        $groupedProducts = collect($appointedProducts)->groupBy('company')->toArray();

        // if($request->ajax())
        // {
        //     $leads = new Lead();
        //     $appointedLeads = $leads->getAppointedLeads();
        //     $appointedLeadsIds = $appointedLeads->pluck('id');
        //     $generalInformationIds = [];
        //     $products = [];
        //     foreach($appointedLeadsIds as $appointedLeadsId)
        //     {
        //         $generalInformationId = GeneralInformation::getIdByLeadId($appointedLeadsId);
        //         if($generalInformationId !== null){
        //             array_push($generalInformationIds, $generalInformationId);
        //         }
        //     }
        //     if($generalInformationIds !== null){
        //         foreach($generalInformationIds as $generalInformationId){
        //             $product = GeneralInformation::getProductByGeneralInformationId($generalInformationId);
        //             array_push($products, $product);
        //         }
        //     }
        //     $index = 0;
        //     return DataTables::of($appointedLeads)
        //            ->addIndexColumn()
        //            ->addColumn('products', function($row) use (&$products, &$index){
        //             $productGroups = array_chunk($products[$index++], 3);
        //             $containers = [];

        //             foreach ($productGroups as $group) {
        //                 $spans = array_map(function($product) {
        //                     return "<span class='badge bg-info permission-badge'><h6>{$product}</h6></span>";
        //                 }, $group);
        //                 $containers[] = '<div>' . implode(' ', $spans) . '</div>';
        //             }
        //             return '<div class="product-column">'. implode('', $containers) . '</div>';
        //            })
        //            ->addColumn('current_user', function($appointedLeads){
        //                   $userProfile = $appointedLeads->userProfile->first();
        //                   $currentUserName = $userProfile ? $userProfile->fullAmericanName(): 'N/A';
        //                   return $currentUserName;
        //              })
        //            ->addColumn('checkbox', function($appointedLeads) {
        //                 $userProfile = $appointedLeads->userProfile->first();
        //                 $currentUserId = $userProfile ? $userProfile->id : null;
        //                 $value = $appointedLeads->id . '_' . $currentUserId ;
        //                 return '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $value . '" />';
        //             })
        //            ->rawColumns(['products', 'checkbox'])
        //            ->make(true);
        // }
        return view('leads.quotation_leads.assign-appointed-leads', compact('quoters', 'userProfiles', 'appointedLeadCount', 'qoutingCount', 'groupedProducts', 'appointedProducts', 'requestForQuoteProduct'));
    }

    public function assignAppointedLead(Request $request)
    {
        try{
            DB::beginTransaction();
            $products = $request->input('product');
            $marketingSpecialistId = $request->input('marketSpecialistUserProfileId');
            $agentId = $request->input('agentUserProfileId');
            $userProfileId = $marketingSpecialistId ? $marketingSpecialistId : $agentId;
            $userProfile = UserProfile::find($userProfileId);
            $user =  User::find($userProfile->user_id);
            $productCount = 0;
            if($userProfileId || $products){
                foreach($products as $product){
                    $QuotationProduct = QuotationProduct::find($product);
                    $QuotationProduct->user_profile_id = $userProfileId;
                    $QuotationProduct->status = 2;
                    $QuotationProduct->save();
                    $productCount++;
                    $leadData = $QuotationProduct->quoteInformation->quoteLead->leads;
                    $leadId  = $leadData->id;
                    event(new AssignAppointedLeadEvent($leadId, $userProfile->id, $product, $user->id));
                }
                $user->sendAppointedNotification($user, $productCount, $userProfile->fullAmericanName(), );

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
            $assignedProduct = QuotationProduct::getProductByUserProfileId($userProfileId);
        }else{
            $assignedProduct = null;
        }

        if($request->ajax()){
            if($assignedProduct !== null){
                $data = $assignedProduct;
            }else{
                $data = [];
            }

            return DataTables::of($data)
                   ->addIndexColumn()
                   ->addColumn('checkbox', function($assignedProduct){
                        return '<input type="checkbox" name="leads_checkbox[]" class="leads_checkbox" value="' . $assignedProduct->id . '" />';
                    })
                    ->addColumn('company', function($assignedProduct){
                        return $assignedProduct->quoteInformation->quoteLead->leads->company_name;
                    })
                   ->rawColumns(['checkbox'])
                   ->make(true);
        }
    }

    public function voidLeads(Request $request)
    {
        try{
            DB::beginTransaction();
            $productsArray = $request->input('productId');
            foreach($productsArray as $product){
                $QuotationProduct = QuotationProduct::find($product);
                $QuotationProduct->status = 7;
                $QuotationProduct->user_profile_id = null;
                $QuotationProduct->save();
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

            $productId = $request->input('productId');
            $userProfileId = $request->input('userProfileId');
            $oldProductOwnerUserProfileId = $request->input('oldProductOwnerUserProfileId');
            $userProfileData = UserProfile::find($oldProductOwnerUserProfileId);
            $newUserProfileData = UserProfile::find($userProfileId);
            $oldUser = User::find($userProfileData->user_id);
            $newUser = User::find($newUserProfileData->user_id);
            $productCount = 0;
            foreach($productId as $id){
                $QuotationProduct = QuotationProduct::find($id);
                $QuotationProduct->user_profile_id = $userProfileId;
                $QuotationProduct->save();
                $Lead = $QuotationProduct->quoteInformation->quoteLead->leads;
                $ReceivableName = UserProfile::find($userProfileId)->fullAmericanName();
                $oldOwnerName = UserProfile::find($oldProductOwnerUserProfileId)->fullAmericanName();
                event (new ReassignedAppointedLead($Lead->id, $Lead->company_name , $ReceivableName, $QuotationProduct->product, $oldOwnerName, $id, $userProfileId, $oldUser->id, $newUser->id));
                $productCount++;
            }
            $oldUser->sendReassignAppointedNotification($oldUser, $productCount, $ReceivableName);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Redeploying", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function requestToQuote(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $products = $data['productId'];

            if (is_array($products)) {
                foreach ($products as $product) {
                    $QuotationProduct = QuotationProduct::find($product);
                    if ($QuotationProduct) {
                        $QuotationProduct->status = 29;
                        $QuotationProduct->save();
                    } else {
                        Log::info("QuotationProduct not found for product ID: " . $product);
                        return response()->json(['error' => 'QuotationProduct not found for product ID: ' . $product], 404);
                    }
                }
            } else {
                $QuotationProduct = QuotationProduct::find($products);
                if ($QuotationProduct) {
                    $QuotationProduct->status = 29;
                    $QuotationProduct->save();
                } else {
                    Log::info("QuotationProduct not found for product ID: " . $products);
                    return response()->json(['error' => 'QuotationProduct not found for product ID: ' . $products], 404);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Quote request processed successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info("Error for Requesting to Quote", [$e->getMessage()]);
            return response()->json([
                'error' => 'An error occurred while requesting to quote.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
