<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Disposition;
use App\Models\Lead;
use App\Models\RecreationalFacilities;
use App\Models\Site;
use App\Models\UnitedState;
use App\Models\UserProfile;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

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
        $classCodeLeads = ClassCodeLead::all();
        $sortedClassCodeLeads = ClassCodeLead::sortByName($classCodeLeads);
        $dispositions = Disposition::all();
        $recreationalFacilities = RecreationalFacilities::all();
        // $cityAddress = Lead::select('city')->distinct()->get();
        $dataCount = Lead::getLeadsAppointed($user->id);
        if($request->ajax()){
            if(Cache::has('apptaker_leads')){
                $data = Cache::get('apptaker_leads');

                if (!empty($request->get('timezone'))){
                    $timezoneStates = $timezones[$request->get('timezone')];
                    $data = $data->whereIn('state_abbr', $timezoneStates);
                }

                if (!empty($request->get('classCodeLead'))){
                    $data = $data->filter(function ($row) use ($request){
                        return strtolower($row['class_code']) == strtolower($request->get('classCodeLead'));
                    });
                }
                if (!empty($request->get('states'))) {
                    $data = $data->filter(function ($row) use ($request){
                        return $row['state_abbr'] == $request->get('states');
                    });
                }
                if (!empty($request->get('leadType'))) {
                    $data = $data->filter(function ($row) use ($request){
                        return $row['prime_lead'] == $request->get('leadType');
                    });
                }
                // log::info($data);

            }else{
                $query = Lead::whereHas('userProfile', function ($q) use ($user){
                    $q->where('user_profile_id', $user->id);
                })
                ->where('status', 2);
                $data = $query->select('id', 'company_name', 'tel_num', 'state_abbr', 'website_originated', 'created_at', 'disposition_id', 'class_code', 'prime_lead')->get();
                $leadCollection = $data;

                // $dispositions = Disposition::all();
                $data->each(function ($lead) use ($dispositions){
                    $lead->dispositions = $dispositions;
                });

                Cache::put('apptaker_leads', $data, 60 * 60);
            }

            if (!empty($request->get('website'))) {
                $data = $data->filter(function ($row) use ($request) {
                    return $row['website_originated'] == $request->get('website');
                });
            }

            if (!empty($request->get('states'))) {
                $data = $data->filter(function ($row) use ($request) {
                    return $row['state_abbr'] == $request->get('states');
                });
            }
            if (!empty($request->get('leadType'))) {
                $data = $data->filter(function ($row) use ($request){
                    return $row['prime_lead'] == $request->get('leadType');
                });
            }
            // log::info($data);
            if (!empty($request->get('timezone'))){
                $timezoneStates = $timezones[$request->get('timezone')];
                $data = $data->whereIn('state_abbr', $timezoneStates);
            }

            if (!empty($request->get('classCodeLead'))){
                $data = $data->filter(function ($row) use ($request){
                    return strtolower($row['class_code']) == strtolower($request->get('classCodeLead'));
                });
            }
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('created_at_formatted', function ($data) {
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('company_name_action', function ($data){
                   return '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                })

                ->addColumn('company_name_action', function($data){
                  return  '<a href="#" data-toggle="modal" id="companyLink'.$data->id.'" data-row="'.$data->id.'" name="companyLinkButtonData" data-target="#leadsDataModal" data-telnum = "'.$data->tel_num.'"  data-state= "'.$data->state_abbr.'" data-id="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                })

                ->rawColumns(['company_name_action', 'dispositions', 'company_name_action',])
                ->with(['totalDataCount' => $data->count()])
                ->make(true);
        }


        return view('leads.apptaker_leads.index', compact('timezones', 'sites', 'states', 'sortedClassCodeLeads', 'classCodeLeads', 'dispositions', 'recreationalFacilities', 'dataCount'));

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

    public function productPdf(Request $request){
        $formData = $request->all();

        $pdf = PDF::loadView('leads.apptaker_leads.product_pdf_viewer.general-liability-pdf-view', $formData);
        return $pdf->download('product.pdf');
    }
    public function productForms(Request $request){
        return view('leads.apptaker_leads.questionare-new-tab');
    }

    public function listLeadId(Request $request){

        Cache::put('lead_id', $request->input('leadId'), 60 * 60);
    }
}