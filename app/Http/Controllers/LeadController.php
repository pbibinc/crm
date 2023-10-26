<?php

namespace App\Http\Controllers;

use App\Events\LeadImportEvent;
use App\Exports\LeadExport;
use App\Http\Controllers\Controller;
use App\Imports\DncImport;
use App\Imports\LeadsImport;
use App\Models\Classcode;
use App\Models\ClassCodeLead;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use EllGreen\LaravelLoadFile\Laravel\Facades\LoadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Cast;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\type;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewImport', Lead::find(1));
        $newLeadsCount = Lead::where('status', 1)->count();
        $assignLeadsCount = Lead::where('status', 2)->count();
        // $totalLeads = $newLeadsCount + $assignLeadsCount;
        // $unassignedPercentage = round(($newLeadsCount / $totalLeads) * 100);
        // if ($unassignedPercentage >= 50) {
        //    $arrowClass = 'ri-arrow-right-up-line';
        //    $message = "of leads haven't been assigned";
        //    $textClass = 'text-success';
        // } else {
        //    $message = "Leads that haven't been assigned";
        //    $arrowClass ='ri-arrow-right-down-line';
        //    $textClass = 'text-danger';
        //  }
        //  $assignData = [
        //     'unassignedPercentage' => $unassignedPercentage,
        //     'arrowClass' => $arrowClass,
        //     'message' => $message,
        //     'textClass' => $textClass
        // ];
        $classCodeLeads = ClassCodeLead::all();
        if ($request->ajax()) {
        $query = Lead::select('company_name', 'tel_num', 'state_abbr')->orderBy('id');
        return DataTables::of($query)->toJson();
        }
        return view('leads.generate_leads.index', compact('newLeadsCount', 'assignLeadsCount', 'classCodeLeads'));
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $path = $request->file('file')->storeAs(
            'temp', 'temp_file.csv'
        );

        $fullpath = str_replace('\\', '/', storage_path("app/{$path}"));
        // dd($fullpath);
        LoadFile::file($fullpath, $local = true)
        ->into('leads')
        ->columns([
            'company_name',
            'tel_num',
            'state_abbr',
            'class_code',
            'website_originated',
        ])
        ->fieldsTerminatedBy(',')
        ->load();

        DB::table('leads')
        ->whereNull('created_at')
        ->update(['created_at' => now()]);

        unlink($fullpath);

        // Excel::import(new LeadsImport,request()->file('file'));
        // Cache::forget('leads_funnel');
        Cache::forget('apptaker_leads');
        return back();
    }

    public function importDnc(Request $request)
    {
        $file = $request->file('dnc-file');
        $import = new DncImport();
        Excel::import($import, $file);
        Cache::forget('leads_dnc');
        $leads = $this->getDncData($import->getImportedData());
        Cache::put('leads_dnc', $leads, 60 * 60);

        return back();
    }

    public function addDnc(Request $request)
    {
        if($request->ajax()){
            $telNum = $request->input('telNum');
            if(empty($telNum)){
                return response()->json(['message' => 'please enter a tel num lead', 'hasLead' => false]);
            }else{
                $leadsDnc = Cache::get('leads_dnc');
                $telNums = [$telNum];
                if(!is_null($leadsDnc)){
                    $leadsDncArray = $leadsDnc->toArray();
                    $telNums = array_merge($telNums, array_column($leadsDncArray, 'tel_num'));
                    $leads = Lead::whereIn('tel_num', $telNums)->get();
                }else{
                    $leads = Lead::where('tel_num', $telNum)->get();
                }
                Cache::put('leads_dnc', $leads, 60 * 60);
                return response()->json(['message' => 'The leads are successfully added to DNC Queue', 'hasLead' => true]);
            }
        }
    }

    public function getDncData($collection)
    {
           if($collection){
            $dncNumbers = $collection->pluck([0])->toArray();
            $leads = Lead::whereIn('tel_num', $dncNumbers)->get();
           }else{
            $leads = [];
           }
           return $leads;
    }

    public function archive(Request $request)
    {
        $leads = Lead::latest();
        if($request->ajax()){
            $allDeletedleads = $leads->onlyTrashed()
            ->select('id', 'company_name', 'tel_num', 'state_abbr', 'website_originated', 'created_at', 'status', 'class_code')
            ->get();
            return DataTables::of($allDeletedleads)
                   ->addIndexColumn()
                   ->addColumn('restore', '<button class="btn btn-outline-primary waves-effect waves-light btn-sm" id="{{$id}}" name="restore"  type="button " ><i class="mdi mdi-backup-restore"></i></button>')
                   ->rawColumns(['restore'])
            ->make(true);
        }

        return view('leads.generate_leads.archive');
    }

    public function restore($id)
    {
        Lead::where('id', $id)->withTrashed()->restore();
        Cache::forget('leads_data');
    }

    public function destroy($leadsId)
    {
        $leadsId = explode(',', $leadsId);
        Lead::whereIn('id', $leadsId)->delete();
        $leadsDnc = Cache::get('leads_dnc');
        $leadsDncArray = $leadsDnc->toArray();
        $updatedLeadsDnc = array_filter($leadsDncArray, function($lead) use ($leadsId){
            return !in_array($lead['id'], $leadsId);
        });
        $leads = Lead::whereIn('tel_num', array_column($updatedLeadsDnc, 'tel_num'))->get();
        Cache::forget('leads_dnc');
        Cache::put('leads_dnc', $leads, 60 * 60);
        return response()->json(['success' => 'Leads Succesfully Deleted']);
    }

    public function leadsDnc(Request $request)
    {
        if($request->ajax())
        {
            if(Cache::get('leads_dnc')){
                $leads = Cache::get('leads_dnc');

            }else{
                $leads = collect();
            }
                 $data = DB::table('leads')
                            ->whereIn('tel_num', $leads->pluck('tel_num'))
                            ->select('id','company_name', 'tel_num', 'state_abbr')
                            ->get();

                return DataTables::of($data)
                       ->addIndexColumn()
                       ->addColumn('checkbox', '<input type="checkbox" name="leads_checkbox[]"  class="leads_checkbox" value="{{$id}}" />')
                // ->addColumn('company_name_action', function ($data){
                //     return '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                //     })
                ->rawColumns(['checkbox'])
                ->make(true);

        }

    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fileName = 'leads ' . $startDate . ' to ' . $endDate . '.xlsx';
        return Excel::download(new LeadExport($startDate, $endDate), $fileName);
    }

    public function store(Request $request)
    {
        $lead = new Lead;
        $user = Auth::user();
        $id = $user->id;
        $adminData = User::find($id);
        $leadGenerator = $user->userProfile;
       if($request->ajax()){
           $lead->company_name = $request->companyName;
           $lead->tel_num = $request->telNum;
           $lead->state_abbr = $request->stateAbbreviation;
           $lead->website_originated = $request->websiteOriginated;
           $lead->class_code = $request->classCodeLead;
           $lead->prime_lead = $request->leadTypeDropdown;
           $existingLead = Lead::where('tel_num', $lead->tel_num)->first();
           if($existingLead){
               return response()->json(['error' => 'Telephone number must be unique'], 422);
           }
           $lead->save();
           event(new LeadImportEvent($lead, $leadGenerator->id, now()));
       }else{

       }
        Cache::forget('leads_data');
        Cache::forget('leads_funnel');
        Cache::forget('apptaker_leads');
        return response()->json(['success' => 'Leads Succesfully Created']);
    }


}