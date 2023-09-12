<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralLiabilities;
use App\Models\Lead;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{
    //

    public function appointedLeadsView(Request $request)
    {

        if($request->ajax()){
            $leads = Lead::getAppointedLeads();

            return DataTables::of($leads)
            ->addColumn('current_user', function($lead){
                $userProfile = $lead->userProfile->first();
                $currentUserName = $userProfile ? $userProfile->fullName(): 'N/A';

                return $currentUserName;
            })
            ->addColumn('action', function($lead){
                 $viewButton = '<button class="edit btn btn-info btn-sm" id="' . $lead->id . '"><i class="ri-eye-line"></i></button>';
                 return $viewButton;
            })
            ->make(true);

        }
        return view('leads.appointed_leads.index');
    }

    public function leadProfile(Request $request)
    {
        $lead = Lead::getLeads($request->leadId);
        $generalInformation = $lead->generalInformation;
        $timeLimit = 60 * 60;

        Cache::put('appointedLead', $lead, $timeLimit);
        Cache::put('generalInformation', $generalInformation, $timeLimit);


        return redirect()->route('lead-profile-view');
        // return view('leads.appointed_leads.index', compact('lead')

    }
    public function leadProfileView()
    {
        $lead = Cache::get('appointedLead');
        $generalInformation = Cache::get('generalInformation');
        // $generalLiabilities = GeneralLiabilities::
        $timezones = [
            'Eastern' => ['CT', 'DE', 'FL', 'GA', 'IN', 'KY', 'ME', 'MD', 'MA', 'MI', 'NH', 'NJ', 'NY', 'NC', 'OH', 'PA', 'RI', 'SC', 'TN', 'VT', 'VA', 'WV'],
            'Central' => ['AL', 'AR', 'IL', 'IA', 'KS', 'LA', 'MN', 'MS', 'MO', 'NE', 'ND', 'OK', 'SD', 'TX', 'WI'],
            'Mountain' => ['AZ', 'CO', 'ID', 'MT', 'NV', 'NM', 'UT', 'WY'],
            'Pacific' => ['CA', 'OR', 'WA'],
            'Alaska' => ['AK'],
            'Hawaii-Aleutian' => ['HI']
        ];
        $timezoneStrings = [
            'Eastern' => 'America/New_York',
            'Central' => 'America/Chicago',
            'Mountain' => 'America/Denver',
            'Pacific' => 'America/Los_Angeles',
            'Alaska' => 'America/Anchorage',
            'Hawaii-Aleutian' => 'Pacific/Honolulu'
        ];
        $timezoneForState = null;

        if(!$lead || !$generalInformation){
            return redirect()->route('leads.appointed-leads')->withErrors('No DATA found');
            // dd($lead, $generalInformation );
        }
        $usAddress = UnitedState::getUsAddress($generalInformation->zipcode);
        foreach($timezones as $timezone => $states){
            if(in_array($lead->state_abbr, $states)){
                $timezoneForState =  $timezoneStrings[$timezone];
            }

        }
        $localTime = Carbon::now($timezoneForState);
        $generalLiabilities = $generalInformation->generalLiabilities;
        // dd($generalInformation->id);



        return view('leads.appointed_leads.leads-profile', compact('lead', 'generalInformation', 'usAddress', 'localTime', 'generalLiabilities',));
    }
}
