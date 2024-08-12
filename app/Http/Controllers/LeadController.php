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
use App\Models\ScrubbedDnc;
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
        $query = Lead::select('id', 'company_name', 'website_originated','tel_num', 'state_abbr', 'created_at')->orderBy('id');
        return DataTables::of($query)
        ->addColumn('action_button', function ($query){
            $editButton =  '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$query->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';

            $addButton = '<button class="btn btn-outline-success waves-effect waves-light btn-sm btnAdd" data-id="'.$query->id.'" data-telnum="'.$query->tel_num.'" name="add"  type="button " ><i class="mdi mdi-plus"></i></button>';

            return $editButton . ' ' . $addButton;
        })
        ->addColumn('formatted_created_at', function($query){
            return \Carbon\Carbon::parse($query->created_at)->format('m/d/Y');
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

        // Validate the uploaded file
        $request->validate([
           'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Store the uploaded file temporarily
        $path = $request->file('file')->storeAs('temp', 'temp_file.xlsx' . $request->file('file')->getClientOriginalExtension());


        // Get the full path of the stored file
        $fullpath = str_replace('\\', '/', storage_path("app/{$path}"));

        //getting the all the data store into array
        try {
            $fileData = Excel::toArray([], $fullpath);

        } catch (\Exception $e) {
            Log::error('Error reading Excel file: ' . $e->getMessage());
            return back()->with('error', 'Error reading Excel file.');
        }
        $fileData = $fileData[0];

        $columns = [
            'company_name',
            'tel_num',
            'state_abbr',
            'class_code',
            'website_originated',
         ];

        // Get the existing phone numbers from the leads table
        $existingNumbers = Lead::pluck('tel_num')->toArray();

       // Filter out the rows with existing phone numbers
       $filteredNumbers = [];
       $newLeads = array_filter($fileData, function ($row) use ($existingNumbers, &$filteredNumbers, $columns) {
           // Ensure the row has the correct number of elements
           if (count($row) !== count($columns)) {
               Log::warning("Row does not match expected column count: " . json_encode($row));
               return false;
           }

           $lead = array_combine($columns, $row);
           if (in_array($lead['tel_num'], $existingNumbers) || in_array($lead['tel_num'], $filteredNumbers)) {
               return false;
           }

           $filteredNumbers[] = $lead['tel_num'];
           return true;
       });

       // Write the filtered data back to a temporary CSV file
       $filteredPath = str_replace('temp_file.xlsx', 'filtered_temp_file.csv', $fullpath);
       $filteredFile = fopen($filteredPath, 'w');
       foreach ($newLeads as $lead) {
         fputcsv($filteredFile, $lead);
        }
         fclose($filteredFile);

       try {
        LoadFile::file($filteredPath, $local = true)
            ->into('leads')
            ->columns($columns)
            ->fieldsTerminatedBy(',')
            ->load();
       } catch (\Exception $e) {
         Log::error('Error loading data into the database: ' . $e->getMessage());
         return back()->with('error', 'Error loading data into the database.');
       }


      // Update the created_at field for the newly inserted leads
      DB::table('leads')->whereNull('created_at')->update(['created_at' => now()]);

      // Delete the temporary files
      unlink($fullpath);
      unlink($filteredPath);

      // Clear the cache
      Cache::forget('apptaker_leads');

      return back()->with('success', 'Leads imported successfully.');
    }

    public function importDnc(Request $request)
    {
           // Validate the file
           $request->validate([
            'dnc-file' => 'required|mimes:xlsx,xls,csv'
           ]);
           $dncFile = $request->file('dnc-file');
           // Store the file temporarily
           $path = $dncFile->storeAs('temp', 'temp_dnc_file.xlsx' .$dncFile->getClientOriginalExtension());

          $fullpath = str_replace('\\', '/', storage_path("app/{$path}"));

          //getting all the data store into array
          try{
                $fileData = Excel::toArray([], $fullpath);
          }catch(\Exception $e){
              Log::error('Error reading Excel file: ' . $e->getMessage());
              return back()->with('error', 'Error reading Excel file.');
          }
          $fileData = $fileData[0];

          $existingDncNumbers = TempDnc::pluck('tel_num')->toArray();

          $filteredNumbers = [];

          $columns = [
              'company_name',
              'tel_num',
          ];

          $newDncLeads = array_filter($fileData, function($row) use ($existingDncNumbers, $filteredNumbers, $columns){
              if(count($row) !== count($columns)){
                  Log::warning("Row does not match expected column count: " . json_encode($row));
                  return false;
              }

              $lead = array_combine($columns, $row);
              if(in_array($lead['tel_num'], $existingDncNumbers) || in_array($lead['tel_num'], $filteredNumbers)){
                  return false;
              }

              $filteredNumbers[] = $lead['tel_num'];
              return true;
          });

          $filteredPath = str_replace('temp_dnc_file.xlsx', 'filtered_temp_dnc_file.csv', $fullpath);
          $filteredFile = fopen($filteredPath, 'w');
            foreach($newDncLeads as $lead){
                fputcsv($filteredFile, $lead);
            }
            fclose($filteredFile);
            try {
                LoadFile::file($filteredPath, $local = true)
                    ->into('temp_dnc_table')
                    ->columns($columns)
                    ->fieldsTerminatedBy(',')
                    ->load();
               } catch (\Exception $e) {
                 Log::error('Error loading data into the database: ' . $e->getMessage());
                 return back()->with('error', 'Error loading data into the database.');
               }

            DB::table('temp_dnc_table')->whereNull('created_at')->update(['created_at' => now()]);

            unlink($fullpath);
            unlink($filteredPath);

            return back()->with('success', 'Leads imported successfully.');

        return back();
    }

    public function addDnc(Request $request)
    {
        try{
            DB::beginTransaction();
            $telNum = $request->input('telNum');
            $companyName = $request->input('companyName');
            $tempDnc = new TempDnc();
            $tempDnc->company_name = $companyName;
            $tempDnc->tel_num = $telNum;
            $tempDnc->save();
            DB::commit();
            return response()->json(['success' => 'DNC Lead Added Successfully']);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
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

    public function destroy($dncIds)
    {
        try{
            DB::beginTransaction();
            $dncIds = explode(',', $dncIds);
            $scrubbedDncRecords = ScrubbedDnc::whereIn('id', $dncIds)->get(['lead_id']);
            ScrubbedDnc::whereIn('id', $dncIds)->delete();
            $leadIds = $scrubbedDncRecords->pluck('lead_id')->toArray();
            // Delete the corresponding leads based on the lead IDs
            Lead::whereIn('id', $leadIds)->update(['status' => 7]);
            $leadDeletion = Lead::whereIn('id', $leadIds)->delete();
            DB::commit();
            return response()->json(['success' => 'Leads Succesfully Deleted']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'An error occurred'], 500);
        }

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
        $dnc = new TempDnc();
        $dncLead = $dnc->select('id', 'company_name', 'tel_num', 'created_at')->orderBy('created_at', 'desc');
        $dncLeadCount = $dncLead->count();
        if($request->ajax()){
            return DataTables::of($dncLead)
            ->addColumn('formatted_created_at', function($dncLead){
                return \Carbon\Carbon::parse($dncLead->created_at)->format('m/d/Y');
            })
            ->addColumn('action', function($dncLead){
                $deleteButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm btnDelete" data-id="'.$dncLead->id.'" name="delete"  type="button " ><i class="mdi mdi-delete"></i></button>';
                $editButton = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$dncLead->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('leads.do-not-call.index', compact('dncLeadCount'));
    }

    public function editDnc($id)
    {
        $dnc = TempDnc::find($id);
        return response()->json(['data' => $dnc]);

    }

    public function updateDnc(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $tempDnc = TempDnc::find($data['id']);
            $tempDnc->company_name = $data['companyName'];
            $tempDnc->tel_num = $data['telNum'];
            $tempDnc->save();
            DB::commit();
            return response()->json(['success' => 'DNC Lead Updated Successfully']);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function deleteDnc(Request $request)
    {
        try{
            DB::beginTransaction();
            $id = $request->input('id');
            $tempDnc = TempDnc::find($id);
            $tempDnc->delete();
            DB::commit();
            return response()->json(['success' => 'DNC Lead Deleted Successfully']);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function export(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        Cache::put('exportToken', 'exporting', 60 * 60);
        $fileName = 'leads ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d') . '.csv';
        $query = Lead::whereBetween("created_at", [$startDate, $endDate])->select('company_name', 'tel_num', 'class_code')->get();
        $writer = SimpleExcelWriter::streamDownload($fileName);
        $i = 0;
        foreach($query->lazy(1000) as $lead){
            $writer->addRow($lead->toArray());
            if($i % 1000 === 0){
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
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        Cache::put('exportToken', 'exporting', 60 * 60);
        $fileName = 'dnc leads ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d') . '.csv';
        $query = TempDnc::whereBetween('created_at', [$startDate, $endDate])->select('company_name', 'tel_num')->get();
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

    public function storeAdditionalCompany(Request $request)
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

    public function searchLead(Request $request)
    {
       $search = $request->search;
       $leads = Lead::where('company_name', 'LIKE', "%{$search}%")
       ->orWhere('tel_num', 'LIKE', "%{$search}%")
       ->orWhereHas('GeneralInformation', function($query) use ($search){
        $query->where('email_address', 'LIKE', "%{$search}%")
        ->orWhere('firstname', 'LIKE', "%{$search}%")
        ->orWhere('lastname', 'LIKE', "%{$search}%")
        ->orWhere(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', "%{$search}%");
       })
       ->first();
       dd($leads);
       return response()->json(['leadId' => $leads->id]);
    }

    public function getLeadDataBySearch(Request $request)
    {
        $search = $request->search;
        $leads = Lead::withTrashed()->where('company_name', 'LIKE', "%{$search}%")
        ->orWhere('tel_num', 'LIKE', "%{$search}%")
        ->orWhereHas('GeneralInformation', function($query) use ($search){
         $query->where('email_address', 'LIKE', "%{$search}%")
         ->orWhere('firstname', 'LIKE', "%{$search}%")
         ->orWhere('lastname', 'LIKE', "%{$search}%")
         ->orWhere(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', "%{$search}%");
        })->with('generalInformation')->get();


        return response()->json(['leads' => $leads]);
    }

    public function requestForDnc(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $ids = $data['dncLeadsId'];
            foreach($ids as $id) {
                $tempDnc = new TempDnc();
                $lead = Lead::find($id);
                $tempDnc->company_name = $lead->company_name;
                $tempDnc->tel_num = $lead->tel_num;
                $tempDnc->save();
                $lead->update(['status' => 7]);
                $lead->delete();
            }
            DB::commit();
            return response()->json(['message' => 'The leads are successfully added to DNC Queue']);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}