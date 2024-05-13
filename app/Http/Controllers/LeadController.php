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
use App\Models\TempDnc;
use App\Models\UnitedState;
use App\Models\User;
use App\Models\Website;
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
use Spatie\SimpleExcel\SimpleExcelWriter;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\type;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewImport', Lead::find(1));
        $newLeadsCount = Lead::where('status', 1)->count();
        $assignLeadsCount = Lead::where('status', 2)->count();
        $stateAbbr = UnitedState::distinct()->pluck('state_abbr');
        $classCodeLeads = ClassCodeLead::all();
        $websiteOriginated = Website::distinct()->orderBy('name')->pluck('name');;
        if ($request->ajax()) {
        $query = Lead::select('id', 'company_name', 'website_originated','tel_num', 'state_abbr')->orderBy('id');
        return DataTables::of($query)
        ->addColumn('action_button', function ($query){
            return '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$query->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
        })
        ->rawColumns(['action_button'])
        ->toJson();
        }
        return view('leads.generate_leads.index', compact('newLeadsCount', 'assignLeadsCount', 'classCodeLeads', 'stateAbbr', 'websiteOriginated'));
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
        // $file = $request->file('dnc-file');
        // $import = new DncImport();
        // Excel::import($import, $file);
        // $leads = $this->getDncData($import->getImportedData());
           // Validate the file
           $request->validate([
            'dnc-file' => 'required|mimes:xlsx,xls,csv'
           ]);

           // Store the file temporarily
          $path = $request->file('dnc-file')->storeAs(
             'temp', 'temp_dnc_file.csv'
           );

            $fullpath = str_replace('\\', '/', storage_path("app/{$path}"));

    // Load the file into a temporary collection or table
             LoadFile::file($fullpath, $local = true)
             ->into('temp_dnc_table') // You might need to create a temporary table or handle this differently
             ->columns(['tel_num']) // Assuming the first column is telephone numbers
             ->fieldsTerminatedBy(',')
             ->load();
        // Process the loaded data
        $tempDncTable = TempDnc::select('tel_num')->orderBy('id')->get();

        $this->getDncData($tempDncTable);

        // Cleanup
        unlink($fullpath);

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
        $dncNumber = $collection->pluck('tel_num')->toArray();
        $leadsId = Lead::whereIn('tel_num', $dncNumber)->pluck('id');
        if ($leadsId->isNotEmpty()) {
            // Update the disposition of these leads to 7
            Lead::whereIn('id', $leadsId)->update(['status' => 7]);
            TempDnc::truncate();
        }
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
        $leadDeletion = Lead::whereIn('id', $leadsId)->delete();
        if($leadDeletion){
            $lead = Lead::find($leadsId);
        }
        return response()->json(['success' => 'Leads Succesfully Deleted']);
    }

    public function leadsDnc(Request $request)
    {
        if($request->ajax())
        {
            $data = Lead::where('status', 7)->select('id','company_name', 'tel_num')->get();
                return DataTables::of($data)
                       ->addIndexColumn()
                       ->addColumn('checkbox', '<input type="checkbox" name="leads_checkbox[]"  class="leads_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }


    public function checkDncExport(Request $request)
    {
        if($request->ajax()){
            $data = Lead::where('disposition_id', 13)->select('id','company_name', 'tel_num')->get();
                return DataTables::of($data)
                       ->addIndexColumn()
                       ->addColumn('checkbox', '<input type="checkbox" name="leads_checkbox[]"  class="leads_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }

    public function viewDnc(Request $request)
    {

        if($request->ajax()){
            $lead = new Lead();
            $dncLead = $lead->getDncLead()->get();
            // dd($dncLead);
            return DataTables::of($dncLead)
            ->make(true);
        }
        return view('leads.do-not-call.index');
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        Cache::put('exportToken', 'exporting', 60 * 60);
        $fileName = 'leads ' . $startDate . ' to ' . $endDate . '.csv';
        $query = Lead::whereBetween("created_at", [$startDate, $endDate])->select('company_name', 'tel_num', 'class_code')->get();
        $writer = SimpleExcelWriter::streamDownload($fileName);
        $i = 0;
        foreach($query->lazy(50000) as $lead){
            $writer->addRow($lead->toArray());
            if($i % 50000 === 0){
                flush();
            }
            $i++;
        }
        Cache::forget('exportToken');
        return $writer->toBrowser();
        // return Excel::download(new LeadExport($startDate, $endDate), $fileName);
    }

    public function checkExport(Request $request)
    {
        $sessionToken = Cache::get('exportToken');
        return response()->json(['exportToken' =>  $sessionToken]);
    }

    public function exportDnc(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        Cache::put('exportToken', 'exporting', 60 * 60);
        $fileName = 'dnc leads ' . $startDate . ' to ' . $endDate . '.csv';
        $query = Lead::withTrashed()->where('status', 7)->whereBetween('deleted_at', [$startDate, $endDate])->select('company_name', 'tel_num', 'class_code')->get();
        $writer = SimpleExcelWriter::streamDownload($fileName);
        $i = 0;
        foreach($query->lazy(1000) as $lead){
            $writer->addRow($lead->toArray());
            if($i % 50000 === 0){
                flush();
            }
            $i++;
        }
        Cache::forget('exportToken');
        return $writer->toBrowser();
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
           $lead->tel_num = $request->addTelNum;
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
    public function edit($id)
    {
        $lead = Lead::find($id);

        $website = Website::where('name', 'LIKE', "%{$lead->website_originated}%")->first();
        return response()->json(['lead' => $lead, 'website' => $website]);
    }

    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($id);
            $lead->company_name = $data['companyName'];
            $lead->tel_num = $data['addTelNum'];
            $lead->state_abbr = $data['stateAbbreviation'];
            $lead->website_originated = $data['websiteOriginated'];
            $lead->class_code = $data['classCodeLead'];
            $lead->prime_lead = $data['leadTypeDropdown'];
            $lead->save();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }

    public function getCallBackAppointedLead(Request $request)
    {
        if($request->ajax())
        {
            $userProfileId = auth()->user()->userProfile->id;

            $data = Lead::getDncDispositionCallbackByUserProfileId($userProfileId);
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', function($data){
                $lead = Lead::find($data->lead_id);

                $companyName = '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$lead->id.'" data-name="'.$lead->company_name.'" class="companyLink">'.$lead->company_name.'</a>';
                return $lead ? $companyName : ' ';

            })
            ->addColumn('tel_num', function($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->tel_num : ' ';
            })
            ->addColumn('action', function($data){
                $leads = Lead::find($data->lead_id);
                $profileViewRoute = route('appointed-list-profile-view', ['leadsId' => $leads->id]);
                return '<a href="'.$profileViewRoute.'" class="viiew btn btn-success btn-sm" id="'.$leads->id.'" name"view"><i class="ri-eye-line"></i></a>';
            })
            ->addColumn('date_formatted', function($data){
                $date = date('M d, Y', strtotime($data->date_time));
                $time =  date('h:i A', strtotime($data->date_time));
                return $date. ' ' .$time;
            })
            ->rawColumns(['company_name', 'action'])
            ->make(true);
        }
    }


}