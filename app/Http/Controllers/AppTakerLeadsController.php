<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Disposition;
use App\Models\Lead;
use App\Models\RecreationalFacilities;
use App\Models\RemarksModel;
use App\Models\Site;
use App\Models\UnitedState;
use App\Models\User;
use App\Models\UserProfile;
use App\Notifications\AppointedNotification;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Notification;

class AppTakerLeadsController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $timezones = [
            'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
            'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
            'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
            'Pacific' => ['CA', 'OR', 'WA'],
            'Alaska' => ['AK'],
            'Hawaii-Aleutian' => ['HI']
        ];
        $sites = Site::all();
        $states = ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV',
            'AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI', 'AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY',
            'CA', 'OR', 'WA', 'AK', 'HI'
            ];
        $classCodeLeads = ClassCodeLead::orderBy('name', 'asc')->get();
        $sortedClassCodeLeads = ClassCodeLead::sortByName($classCodeLeads);
        $dispositions = Disposition::orderBy('name', 'asc')->get();
        $recreationalFacilities = RecreationalFacilities::all();
        $dataCount = Lead::getLeadsAppointed($user->id);
        $userProfiles = UserProfile::get()->sortBy('first_name');
        if($request->ajax()){
            $query = Lead::select('id', 'company_name', 'tel_num', 'class_code', 'state_abbr')
            ->where('status', 2)
            ->whereNull('disposition_id')
            ->whereHas('userProfile', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            return DataTables::of($query)
            ->addColumn('company_name_action', function ($query){
                           return '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$query->id.'" data-name="'.$query->company_name.'">'.$query->company_name.'</a>';
                        })
            ->rawColumns(['company_name_action'])
            ->make(true);
        }
        return view('leads.apptaker_leads.index', compact('timezones', 'sites', 'states', 'sortedClassCodeLeads', 'classCodeLeads', 'dispositions', 'recreationalFacilities', 'dataCount', 'userProfiles'));
    }
    public function multiStateWork(Request $request)
    {
        $formData = $request->all();
        Cache::put('multi_state', $formData,  60 * 60);
        return response()->json(['message' => 'added multiple selects']);
    }

    public function filterCities(Request $request)
    {
       $stateInput = $request->input('stateAbbr');
       $zipcodeInput = $request->input('zipcode');
       $cityInput = $request->input('city');
       $cities = [];
       $zipcode = [];
       if($zipcodeInput != null){
        $cities = UnitedState::where('zipcode', $zipcodeInput)->pluck('city')->first();
        $zipcode = UnitedState::where('state_abbr', $stateInput)->get();
       }
       if($cityInput != null){
        $zipcode = UnitedState::where('city', $cityInput)->pluck('zipcode')->first();
        $cities = UnitedState::where('state_abbr', $stateInput)->get();
       }
       if($stateInput != null){
        $cities = UnitedState::where('state_abbr', $stateInput)->get();
        $zipcode = UnitedState::where('state_abbr', $stateInput)->get();
       }

        return response()->json(['cities' => $cities, 'zipcode' => $zipcode]);
    }


    public function productForms(Request $request){
        return view('leads.apptaker_leads.questionare-new-tab');
    }

    public function listLeadId(Request $request){

        $leadId = $request->input('leadId');
        $user = Auth::user();
        $productId = $request->input('productId');
        $status = $request->input('status');
        $activityId = $request->input('activityId');
        $cachedUser = Cache::get('user_id');
        $cachedLeadId = Cache::get('lead_id');
        $cachedProductId = Cache::get('product_id');
        $cachedActivityId = Cache::get('activity_id');
        if($productId){
            if($productId == $cachedProductId){
                Cache::get('product_id');
            }else{
                Cache::put('product_id', $productId, 60 * 60);
            }
        }else{
            Cache::forget('product_id');
        }
        if($activityId){
            if($activityId == $cachedActivityId){
                Cache::get('activity_id');
            }else{
                Cache::put('activity_id', $activityId, 60 * 60);
            }
        }else{
            Cache::forget('activity_id');
        }

        if($leadId == $cachedLeadId){
            Cache::get('lead_id');
            Cache::get('user_id');
        }else{
            Cache::put('lead_id', $leadId, 60 * 60);
            Cache::put('user_id', $user->id, 60 * 360);
        }
        return response()->json(['success' => 'Lead id added to cache']);
    }

    public function storeLeadRemarksDisposition(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $leadSaving =  $lead->save();
            $remarksLead = new RemarksModel();
            $remarksLead->lead_id = $data['leadId'];
            $remarksLead->type = $data['dispositionId'];
            $remarksLead->remarks = isset($data['callBackRemarks']) ? $data['callBackRemarks'] : ' ';
            $remarksLead->save();
            DB::commit();
            return response()->json(['success' => 'Lead disposition and remarks saved successfully'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function reloadData(Request $request)
    {

        $data = $request->all();
        $user = User::find($data['userData']);

        Notification::send($user, new AppointedNotification());
        return response()->json(['message' => 'Reload request received'], 200);
    }

}