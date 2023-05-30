<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassCodeLead;
use App\Models\Disposition;
use App\Models\Lead;
use App\Models\Site;
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
                // log::info($data);

            }else{
                $query = Lead::where('user_profile_id', $user->id);
                $data = $query->select('id', 'company_name', 'tel_num', 'state_abbr', 'website_originated', 'created_at', 'disposition_id', 'class_code')->get();

                $dispositions = Disposition::all();
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

            // if (!empty($request->get('states'))){
            //     $data = $data->filter(function ($row) use ($request){
            //         return $row['state_abbr'] == $request->get('states');
            //     });
            // }

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('created_at_formatted', function ($data) {
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('company_name_action', function ($data){
                   return '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                })
                ->addColumn('dispositions', function ($data){
                    $options = '<option value="">dispositions</option>';
                    foreach ($data->dispositions as $disposition){
                        $options .= '<option value="'.$disposition->id.'">'.$disposition->name.'</option>';
                    }
                    return '<select name="dispositions" id="dispositionDrodown'.$data->id.'" data-row="'.$data->id.'" class="form-control select2">'.$options.'</select>';
                })
                ->addColumn('company_name_action', function($data){
                  return  '<a href="#" data-toggle="modal" id="companyLink'.$data->id.'" data-row="'.$data->id.'" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                })
             
                ->rawColumns(['company_name_action', 'dispositions', 'company_name_action',])
                ->make(true);
        }
        return view('leads.apptaker_leads.index', compact('timezones', 'sites', 'states', 'classCodeLeads'));

    }
}
