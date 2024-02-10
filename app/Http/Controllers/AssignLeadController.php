<?php

namespace App\Http\Controllers;

use App\Events\LeadAssignEvent;
use App\Events\LeadReassignEvent;
use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\LeadsAssign;
use App\Models\Site;
use App\Models\UnitedState;
use App\Models\UserProfile;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Collective\Html\FormFacade as Form;
use function PHPUnit\TestFixture\func;
use DateTimeZone;
use Illuminate\Support\Facades\Log;

class AssignLeadController extends Controller
{
    //
    public function index(Request $request)
    {
        $this->authorize('viewLeadsFunnel', Lead::find(1));
        $userProfiles = UserProfile::whereHas('position', function ($query){
            $query->where('name', 'Application Taker');
            })->orderBy('id')->get();

        $accounts = UserProfile::all();
        $sites = Site::all();
        $classCodeLeads = ClassCodeLead::all();
        $websitesOriginated = Website::distinct()->orderBy('name')->pluck('name');
        $timezones = [
            'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
            'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
            'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
            'Pacific' => ['CA', 'OR', 'WA'],
            'Alaska' => ['AK'],
            'Hawaii-Aleutian' => ['HI']
        ];

        $states = [
            "AL" => "Alabama", "AK" => "Alaska", "AZ" => "Arizona", "AR" => "Arkansas", "CA" => "California", "CO" => "Colorado", "CT" => "Connecticut", "DE" => "Delaware",
            "FL" => "Florida", "GA" => "Georgia", "HI" => "Hawaii", "ID" => "Idaho", "IL" => "Illinois", "IN" => "Indiana", "IA" => "Iowa", "KS" => "Kansas", "KY" => "Kentucky",
            "LA" => "Louisiana", "ME" => "Maine", "MD" => "Maryland", "MA" => "Massachusetts", "MI" => "Michigan", "MN" => "Minnesota", "MS" => "Mississippi", "MO" => "Missouri",
            "MT" => "Montana", "NE" => "Nebraska", "NV" => "Nevada", "NH" => "New Hampshire", "NJ" => "New Jersey", "NM" => "New Mexico", "NY" => "New York", "NC" => "North Carolina",
            "ND" => "North Dakota", "OH" => "Ohio", "OK" => "Oklahoma", "OR" => "Oregon", "PA" => "Pennsylvania", "RI" => "Rhode Island", "SC" => "South Carolina", "SD" => "South Dakota",
            "TN" => "Tennessee", "TX" => "Texas", "UT" => "Utah", "VT" => "Vermont", "VA" => "Virginia", "WA" => "Washington", "WV" => "West Virginia", "WI" => "Wisconsin", "WY" => "Wyoming",
        ];

        $selectedUserProfile = null;

        if($request->get('appTakerId')){
            $selectedUserProfile = UserProfile::find($request->get('appTakerId'));
        }if ($request->get('accountsId')) {
            $selectedUserProfile = UserProfile::find($request->get('accountsId'));
        }

        if($selectedUserProfile){
            $leadsCountByState = $selectedUserProfile->getLeadCountByState();
        }else{
            $leadsCountByState = [];
        }

        if($request->ajax()){
                $query = Lead::select('id', 'company_name', 'state_abbr', 'class_code', 'website_originated', 'created_at')->where('status', 1)->orderBy('id');
                // if ($request->filled('website_originated')) {
                //     $query->where('website_originated', $request->website_originated);
                // }
                // dd($request->website_originated);
                if ($request->filled('timezone')) {
                    $timezoneStates = $timezones[$request->timezone];
                    $query->whereIn('state_abbr', $timezoneStates);
                }
                if ($request->filled('classCodeLead')) {
                    $query->where('class_code', $request->classCodeLead);
                }
                if ($request->filled('leadType')){
                    $query->where('prime_lead', $request->leadType);
                }

                if (!empty($request->get('leadType'))){
                    $query->where('prime_lead', $request->get('leadType'));
                }

                if($request->filled('website_originated')){
                    $websiteParts = explode('.', $request->website_originated);
                    $websiteName = $websiteParts[0]; // Get the first part of the domain
                    $query->where('website_originated', 'LIKE', "%{$websiteName}%");
                }
                // dd($query);

               // Filter by states
               if ($request->filled('states')) {
               // Convert the string to an array if it's not an array
               $selectedStateNames = is_array($request->states) ? $request->states : explode(',', $request->states);

                $query->where('state_abbr', $selectedStateNames[0]);
              }

            //   if($request->fille)

            return DataTables::of($query)->addIndexColumn()
                ->addColumn('created_at_formatted', function ($lead) {
                    return Carbon::parse($lead->created_at)->format('M d,Y');
                })
                ->addColumn('updated_at_formatted', function ($lead) {
                    return Carbon::parse($lead->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('checkbox', function ($lead) {
                    return '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="' . $lead->id . '" />';
                })
                ->rawColumns(['checkbox'])
                ->make(true);
        }
        return view('leads.assign_leads.index', compact('userProfiles', 'sites','timezones', 'accounts', 'classCodeLeads', 'leadsCountByState', 'states', 'websitesOriginated'));
    }

    public function getDataTableLeads(Request $request)
    {
        $userProfileId = $request->input('userProfile');
        $accountProfileValue = $request->input('accountProfileValue');
        if($userProfileId){
            $userProfile = UserProfile::with(['leads' => function($query) use ($userProfileId){
                $query->where('status', 2);
            }])->find($userProfileId);
            $leads = $userProfile ? $userProfile->leads()->where('current_user_id', '!=', 0) : collect();
        }elseif ($accountProfileValue){
            $accounts = UserProfile::find($accountProfileValue);
            $leads = $accounts ? $accounts->leads()->where('status', 2)->where('current_user_id', '!=', 0): collect();
        }else{
            $leads = collect();
        }
          if($request->ajax()){
              if($leads->count() > 0){
                 $data = $leads;
              } else {
                  $data = [];
              }
              return DataTables::of($data)->addIndexColumn()
                  ->addColumn('action', function ($row) {
                    $leadId = $row->lead_id;
                      $voidButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm" id="' . $leadId . '" name="void"  type="button"  ><i class="ri-user-unfollow-line" ></i></button>';
                      $redeployButton = '<button class="btn btn-outline-info waves-effect waves-light btn-sm" id="' . $leadId . '" name="redeploy"  type="button " ><i class="ri-user-shared-line"></i></button>';
                      return $redeployButton . ' '. $voidButton;
                  })
                  ->make(true);
          }
    }

    //assigning leads into premium leads
    public function assignPremiumLead(Request $request, Lead $lead)
    {
        $leadsId = $request->input('leadsId');
        Lead::whereIn('id',  $leadsId)
           ->update([
            'prime_lead' => 2
           ]);
        return response()->json(['success' => 'Leads are succesfully assign into prime lead']);
    }

    //assign single leads into a user
    public function assign(Request $request, Lead $lead)
    {
        $leadsId = $request->input('id');
        $userProfileId = $request->input('userProfileId');
        $accountProfileId = $request->input('accountProfileId');

        if($userProfileId){
            $userProfile = UserProfile::find($userProfileId);
            $leadsRecevierId = $userProfileId;
        }elseif ($accountProfileId){
            $userProfile = UserProfile::find($accountProfileId);
            $leadsRecevierId = $accountProfileId;
        }
            $leads = Lead::whereIn('id', $leadsId)->get();
            foreach($leads as $lead){
               $lead->userProfile()->attach($userProfile , [
                'assigned_at' => now(),
                'current_user_id' => $userProfile->id
            ]);
               $lead->status = 2;
               $lead->save();
               event(new LeadAssignEvent($lead, $userProfile->id, $userProfile->id, now()));
            }
        return response()->json(['success' => 'the leads are succesfully assign into'. ' '  . $userProfile->firstname . ' ' . $userProfile->american_surname]);
    }

    //assigning random leads into random users
    public function assignRandomLeads(Request $request)
    {
     $quantityLeadsRandom = $request->input('leadsQuantityRandom');
     $newLeads = Lead::where('status', 1)->get();
     $shuffledLeads =  $newLeads->shuffle()->take($quantityLeadsRandom);
     $userProfiles = UserProfile::whereHas('position', function ($query){
            $query->where('name', 'Application Taker');
        })->get();
     $shuffledUsers = $userProfiles->shuffle();
        foreach ($shuffledLeads as $index => $lead){
            $user = $shuffledUsers[$index % $shuffledUsers->count()];
            $lead->userProfile()->attach($user->id, [
                'assigned_at' => now(),
                'current_user_id' => $user->id
         ]);
            $lead->status = 2;
            $lead->save();
            event(new LeadAssignEvent($lead, $user->id, $user->id, now()));
        }
        return response()->json(['success' => 'Random Leads are Assign to Different Users']);
    }


    public function assignLeadsUser(Request $request)
    {
        $quantityUserLeads = $request->input('leadsQuantityUser');
        $newLeads = Lead::where('status', 1)->get();
        $userProfileIdValue = $request->input('userProfileId');
        $accountProfile = $request->input('accountProfileValue');
        $shuffledLeads =  $newLeads->shuffle()->take($quantityUserLeads);

        if($userProfileIdValue){
            $userProfileId = $userProfileIdValue;
        }elseif($accountProfile){
            $userProfileId = $accountProfile;
        }
        foreach($shuffledLeads as $lead){
            $lead->userProfile()->attach($userProfileId, [
                'assigned_at' => now(),
                'current_user_id' => $userProfileId
            ]);
            $lead->status = 2;
            $lead->save();
            event(new LeadAssignEvent($lead, $userProfileId, $userProfileId, now()));
         }
        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');
        return response()->json(['success' => 'Random Leads are Assign to Users']);
    }

    public function void(Request $request)
    {
        $leadsId = $request->input('id');
        if($request->input('userProfileId')){
            $userProfileId = $request->input('userProfileId');
        }
        if($request->input('accountProfileId')){
            $userProfileId = $request->input('accountProfileId');
        }
        if(!is_array($leadsId)){
            $leadsId = explode(',', $leadsId);
        }

        $leads = Lead::whereIn('id', $leadsId)->get();
        foreach ($leads as $lead) {
            $lead->userProfile()->detach($userProfileId);
            $lead->status = 1;
            $lead->save();
        }

        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');
        return response()->json(['success' => 'Leads has been voided successfully']);
    }

    public function redeploy(Request $request)
    {
        $leadsId = $request->input('id');
        $userProfileId = $request->input('userProfileId');
        $userProfile = UserProfile::find($userProfileId);
        $lead =Lead::find($leadsId);
        if($request->ajax()){
            $currentUserProfileId = $lead->userProfile()
            ->where('current_user_id', '!=', 0)
            ->pluck('user_profile_id')
            ->first();

            if($currentUserProfileId !== null){
                $lead->userProfile()->syncWithoutDetaching([
                    $currentUserProfileId => [
                        'current_user_id' => 0
                    ]
                ]);
            }
            if($lead->userProfile()->wherePivot('user_profile_id', $userProfileId)->exists()){
                $lead->userProfile()->syncWithoutDetaching([
                    $userProfileId => [
                        'reassigned_at' => now(),
                        'current_user_id' => $userProfileId
                    ]
            ]);
            }else{
                $lead->userProfile()->attach($userProfileId, [
                    'reassigned_at' => now(),
                    'current_user_id' => $userProfileId
                ]);
            }
            event(new LeadReassignEvent($lead, $userProfileId, $userProfileId, now()));
            return response()->json(['success' => 'Leads has been successfully redployed to'. $userProfile->firstname . ' ' . $userProfile->american_surname]);
        }else{
            return response()->json(['error' => 'An error has been encountered']);
        }
    }

    public function edit($id)
    {
        $data = Lead::findorFail($id);
        return response()->json(['result' => $data]);
    }

    public function voidAll(Request $request)
    {
    //    $leadsId =  Lead::where('user_profile_id', $request->input('userProfileId'))->pluck('id')->toArray();

       $userProfileId = $request->input('userProfileId');
       $accounProfileId = $request->input('accountProfileId');
       if($userProfileId){
        $leads = Lead::whereHas('userProfile', function($query) use ($userProfileId){
            $query->where('user_profile_id', $userProfileId);
        })->get();
       }

       if($accounProfileId){
        $leads = Lead::whereHas('userProfile', function($query) use ($accounProfileId){
            $query->where('user_profile_id', $accounProfileId);
        })->get();
       }

        // if(!is_array($leadsId)){
        //     $leadsId = explode(',',  $leadsId);
        // }
        foreach($leads as $lead){
            $lead->userProfile()->detach($userProfileId);
            $lead->status = 1;
            $lead->save();
        }

        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');

        return response()->json(['success' => 'success all leads has been voided']);
    }

    public function getStates(Request $request)
    {

        $selectedUserProfile = null;
        if($request->get('userProfileValue')){
            $selectedUserProfile = UserProfile::find($request->get('userProfileValue'));
        }
        // if ($request->get('accountsId')) {
        //     $selectedUserProfile = UserProfile::find($request->get('accountsId'));
        // }
        if($selectedUserProfile){
            $leadsCountByState = $selectedUserProfile->getLeadCountByState();

        }else{
            $leadsCountByState = [];
        }

        $states = [
            "AL" => "Alabama", "AK" => "Alaska", "AZ" => "Arizona", "AR" => "Arkansas", "CA" => "California", "CO" => "Colorado", "CT" => "Connecticut", "DE" => "Delaware",
            "FL" => "Florida", "GA" => "Georgia", "HI" => "Hawaii", "ID" => "Idaho", "IL" => "Illinois", "IN" => "Indiana", "IA" => "Iowa", "KS" => "Kansas", "KY" => "Kentucky",
            "LA" => "Louisiana", "ME" => "Maine", "MD" => "Maryland", "MA" => "Massachusetts", "MI" => "Michigan", "MN" => "Minnesota", "MS" => "Mississippi", "MO" => "Missouri",
            "MT" => "Montana", "NE" => "Nebraska", "NV" => "Nevada", "NH" => "New Hampshire", "NJ" => "New Jersey", "NM" => "New Mexico", "NY" => "New York", "NC" => "North Carolina",
            "ND" => "North Dakota", "OH" => "Ohio", "OK" => "Oklahoma", "OR" => "Oregon", "PA" => "Pennsylvania", "RI" => "Rhode Island", "SC" => "South Carolina", "SD" => "South Dakota",
            "TN" => "Tennessee", "TX" => "Texas", "UT" => "Utah", "VT" => "Vermont", "VA" => "Virginia", "WA" => "Washington", "WV" => "West Virginia", "WI" => "Wisconsin", "WY" => "Wyoming",
        ];

        $stateArray = [];
        foreach($states as $code => $name) {
            $count = $leadsCountByState[$code] ?? 0;
            $stateArray[$code] = $name . ' (' . $count . ')';
        }
        return response()->json($stateArray);
    }
}