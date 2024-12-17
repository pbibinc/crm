<?php

namespace App\Http\Controllers;

use App\Events\AssignAppointedLeadEvent;
use App\Events\HistoryLogsEvent;
use App\Events\LeadNotesNotificationEvent;
use App\Events\ReassignedAppointedLead;
use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\Lead;
use App\Models\LeadNotes;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\QuoteLead;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $requestForQuoteProduct = QuotationProduct::where('status', 30)->count();
        $appointedProducts =  $quoteLead->requestForQuoteAppointedProductByLeads($appointedLeads);
        $appointedLeadCount = $appointedLeads->count();
        $quotationProduct = new QuotationProduct();
        // $appointedProducts = $quotationProduct->appointedProduct();
        $groupedProducts = collect($appointedProducts)->groupBy('company')->toArray();


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
            $userProfileId = Auth::user()->userProfile->id;
            if (is_array($products)) {
                foreach ($products as $product) {
                    $QuotationProduct = QuotationProduct::find($product);
                    if ($QuotationProduct) {
                        $QuotationProduct->status = 30;
                        $QuotationProduct->save();
                    } else {
                        Log::info("QuotationProduct not found for product ID: " . $product);
                        return response()->json(['error' => 'QuotationProduct not found for product ID: ' . $product], 404);
                    }
                    $leadId = $QuotationProduct->quoteInformation->quoteLead->leads->id;
                    $user = User::find(UserProfile::find($QuotationProduct->product_appointer_id)->user_id);
                    $user->sendNoteNotification($user, 'Approved' . ' ' . $QuotationProduct->product, $userProfileId, 'Approved for quotation', $leadId);
                    broadcast(new LeadNotesNotificationEvent('Approved' . ' ' . $QuotationProduct->product, 'Approved for quotation', $user->id, $leadId, $userProfileId, 'info'));
                    event(new HistoryLogsEvent($leadId, $userProfileId, 'Appoint Approved', $QuotationProduct->product . ' ' . 'Product has been approved for quotation'));
                }
            } else {
                $QuotationProduct = QuotationProduct::find($products);
                if ($QuotationProduct) {
                    $QuotationProduct->status = 30;
                    $QuotationProduct->save();
                } else {
                    Log::info("QuotationProduct not found for product ID: " . $products);
                    return response()->json(['error' => 'QuotationProduct not found for product ID: ' . $products], 404);
                }
                $leadId = $QuotationProduct->quoteInformation->quoteLead->leads->id;
                $user = User::find(UserProfile::find($QuotationProduct->product_appointer_id)->user_id);
                $user->sendNoteNotification($user, 'Approved' . ' ' . $QuotationProduct->product, $userProfileId, 'Approved for quotation', $leadId);
                broadcast(new LeadNotesNotificationEvent('Approved' . ' ' . $QuotationProduct->product, 'Approved for quotation', $user->id, $leadId, $userProfileId, 'info'));
                event(new HistoryLogsEvent($leadId, $userProfileId, 'Appoint Approved', $QuotationProduct->product . ' ' . 'Product has been approved for quotation'));
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

    public function declineAppointedProduct(Request $request)
    {
        try{
            DB::beginTransaction();
            $productId = $request->input('productId');
            $userProfileId = Auth::user()->userProfile->id;
            $noteDescription = $request->input('remarks');

            $quotationProduct = QuotationProduct::find($productId);
            $quotationProduct->status = 5;
            $quotationProduct->save();

            $appointerId = $quotationProduct->product_appointer_id;
            $user = User::find(UserProfile::find($appointerId)->user_id);
            $leadId = $quotationProduct->quoteInformation->quoteLead->leads->id;

            $user->sendNoteNotification($user, 'Declined' . ' ' . $quotationProduct->product, $userProfileId, $noteDescription, $leadId);

            $leadNotes = new LeadNotes();
            $leadNotes->lead_id = $leadId;
            $leadNotes->user_profile_id = $userProfileId;
            $leadNotes->title = 'Declined' . ' ' . $quotationProduct->product;
            $leadNotes->description = $noteDescription;
            $leadNotes->status = 'Declined Product';
            $leadNotes->save();

            event(new HistoryLogsEvent($leadId, $userProfileId, 'Declined', $quotationProduct->product . ' ' . 'Product has been declined'));
            broadcast(new LeadNotesNotificationEvent('Declined' . ' ' . $quotationProduct->product, $noteDescription, $user->id, $leadId, $userProfileId, 'danger'));
            DB::commit();
            return response()->json(['success' => 'Product has been declined successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Error for Declining", [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
