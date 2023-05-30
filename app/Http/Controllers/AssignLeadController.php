<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Lead;
use App\Models\LeadsAssign;
use App\Models\Site;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Collective\Html\FormFacade as Form;
use function PHPUnit\TestFixture\func;
use DateTimeZone;

class AssignLeadController extends Controller
{
    //
    public function index(Request $request)
    {
        $this->authorize('viewLeadsFunnel', Lead::find(1));
        $userProfiles = UserProfile::whereHas('position', function ($query){
            $query->where('name', 'Application Taker');
            })->get();

        $accounts = UserProfile::all();
//        dd($userProfiles);
        $sites = Site::all();
        $leads = Lead::all();
        $classCodeLeads = ClassCodeLead::all();
        $timezones = [
            'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
            'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
            'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
            'Pacific' => ['CA', 'OR', 'WA'],
            'Alaska' => ['AK'],
            'Hawaii-Aleutian' => ['HI']
        ];


//        $selectedTimezone = $request->input('timezone');
//        $selectedStateAbbr = array_search($selectedTimezone, $timezones);
        if($request->ajax()){
            if(Cache::has('leads_funnel'))
            {
                $data = Cache::get('leads_funnel');

                if (!empty($request->get('timezone'))){
                    $timezoneStates = $timezones[$request->get('timezone')];
                    $data = $data->whereIn('state_abbr', $timezoneStates);
                }
//                 Apply filters to the cached data
                if (!empty($request->get('website_originated'))) {
                    $data = $data->filter(function ($row) use ($request) {
                        return $row['website_originated'] == $request->get('website_originated');

                    });

                }
                if (!empty($request->get('states'))){
                    $data = $data->filter(function ($row) use ($request){
                        return $row['state_abbr'] == $request->get('states');
                    });
                }

                if (!empty($request->get('classCodeLead'))){
                    $data = $data->filter(function ($row) use ($request){
                        return strtolower($row['class_code']) == strtolower($request->get('classCodeLead'));
                    });
                }
            }else{
                $query = Lead::where('status', 1);

                if (!empty($request->get('website_originated'))) {
                    $query->where('website_originated', $request->get('website_originated'));
                }
                if (!empty($request->get('states'))){
                    $query->where('state_abbr', $request->get('states'));
                }
                if (!empty($request->get('classCodeLead'))){
                    $query->where('class_code', $request->get('classCodeLead'));
                }

                $data = $query->select('id', 'company_name', 'tel_num', 'state_abbr',
                    'class_code', 'website_originated', 'created_at', 'updated_at')->get();

                Cache::put('leads_funnel', $data, 60 * 60);
            }
            if (!empty($request->get('website'))) {
                $data = $data->filter(function ($row) use ($request) {
                    return $row['website_originated'] == $request->get('website');
                });
            }

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('created_at_formatted', function ($data) {
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('updated_at_formatted', function ($data) {
                    return Carbon::parse($data->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]"  class="users_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
//        $shuffledLeads = $leads->shuffle();
//        $shuffledUsers = $userProfiles->shuffle();
//        $numLeadsAssigned = 0;
//
//        dd($shuffledLeads);

        return view('leads.assign_leads.index', compact('userProfiles', 'sites','timezones', 'accounts', 'classCodeLeads'));
    }

    public function getDataTableLeads(Request $request)
    {
        $userProfiles = UserProfile::all();
        $userProfileId = $request->input('userProfile');
        $accountProfileValue = $request->input('accountProfileValue');

        if($userProfileId){
            $userProfile = UserProfile::with(['leads' => function($query){
                $query->where('status', 2);
            }])->find($userProfileId);
            $leads = $userProfile ? $userProfile->leads : collect();
        }elseif ($accountProfileValue){
            $accounts = UserProfile::find($accountProfileValue);
            $leads = $accounts ? $accounts->leads()->where('status', 2)->get() : collect();
        }else{
            $leads = collect();
        }
          if($request->ajax()){
              if(!empty($leads)){
                 $data = $leads->toArray();
              } else {
                  $data = [];
              }
              return DataTables::of($data)->addIndexColumn()
//                  ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]"  class="users_checkbox" value="{{$id}}" />')
                  ->addColumn('action', function ($row) {
                      $voidButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm" id="' . $row['id'] . '" name="void"  type="button"  ><i class="ri-user-unfollow-line" ></i></button>';
                      $redeployButton = '<button class="btn btn-outline-info waves-effect waves-light btn-sm" id="' . $row['id'] . '" name="redeploy"  type="button " ><i class="ri-user-shared-line"></i></button>';
                      return $redeployButton . ' '. $voidButton;
                  })
                  ->make(true);
          }

    }

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
            Lead::whereIn('id', $leadsId)
                ->update([
                    'user_profile_id' => $leadsRecevierId,
                    'status' => 2
                ]);
            Cache::forget('leads_funnel');
            Cache::forget('leads_data');
            Cache::forget('apptaker_leads');
        return response()->json(['success' => 'the leads are succesfully assign into'. ' '  . $userProfile->firstname . ' ' . $userProfile->american_surname]);
    }

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

            $lead->user_profile_id = $user->id;
            $lead->status = 2;
            $lead->save();

        }
        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');
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
        Lead::whereIn('id', $shuffledLeads->pluck('id'))
            ->update([
                'user_profile_id' => $userProfileId,
                'status' => 2
            ]);

        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');
        return response()->json(['success' => 'Random Leads are Assign to Users']);
    }

    public function void(Request $request)
    {
        $leadsId = $request->input('id');
        if(!is_array($leadsId)){
            $leadsId = explode(',', $leadsId);
        }
        Lead::whereIn('id', $leadsId)
            ->update([
                'status' => 1,
                'user_profile_id' => null,
            ]);
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

        if(!is_array($leadsId)){
            $leadsId = explode(',',  $leadsId);
        }
        Lead::whereIn('id', $leadsId)
            ->update([
                'user_profile_id' => $userProfileId
            ]);

        return response()->json(['success' => 'Leads has been successfully redployed to'. $userProfile->firstname . ' ' . $userProfile->american_surname]);
    }
    public function edit($id)
    {
        $data = Lead::findorFail($id);
        return response()->json(['result' => $data]);
    }

    public function voidAll(Request $request)
    {
       $leadsId =  Lead::where('user_profile_id', $request->input('userProfileId'))->pluck('id')->toArray();
       $userProfile = UserProfile::find($request->input('userProfileId'));

        if(!is_array($leadsId)){
            $leadsId = explode(',',  $leadsId);
        }

       Lead::whereIn('id', $leadsId)
           ->update([
               'user_profile_id' => null,
               'status' => 1
           ]);
        Cache::forget('leads_funnel');
        Cache::forget('leads_data');
        Cache::forget('apptaker_leads');

        return response()->json(['success' => 'success all leads has been voided into ' . $userProfile->firstname .  ' ' . $userProfile->american_surname]);
    }
}

