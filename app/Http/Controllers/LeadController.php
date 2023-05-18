<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\LeadsImport;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewImport', Lead::find(1));
        $leads = Lead::get();
        $newLeadsCount = $leads->where('status', 1)->count();
        $assignLeadsCount = $leads->where('status', 2)->count();
        if($request->ajax()){
            if(Cache::has('leads_data')){
                $data = Cache::get('leads_data');
            }else{
                $data = Lead::with('userProfile.position')
                    ->select('id', 'company_name', 'tel_num', 'state_abbr',
                        'website_originated', 'created_at', 'status', 'user_profile_id')->get();
                $data->map(function ($item){
                    $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d');
                    return $item;
                });
                Cache::put('leads_data', $data, 60 * 60);

            }
            return DataTables::of($data)->make(true);
        }
        return view('leads.generate_leads.index', compact('leads', 'newLeadsCount', 'assignLeadsCount'));

    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new LeadsImport,request()->file('file'));
        Cache::forget('leads_data');
        Cache::forget('leads_funnel');
        Cache::forget('apptaker_leads');
        return back();
    }

    public function store(Request $request)
    {
        $lead = new Lead;
       if($request->ajax()){
           $lead->company_name = $request->companyName;
           $lead->tel_num = $request->telNum;
           $lead->state_abbr = $request->stateAbbreviation;
           $lead->website_originated = $request->websiteOriginated;

           $existingLead = Lead::where('tel_num', $lead->tel_num)->first();
           if($existingLead){
               return response()->json(['error' => 'Telephone number must be unique'], 422);
           }
           $lead->save();
       }else{

       }
        Cache::forget('leads_data');
        Cache::forget('leads_funnel');
        Cache::forget('apptaker_leads');
        return response()->json(['success' => 'Leads Succesfully Created']);
    }

}
