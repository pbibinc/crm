<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\Disposition;
use App\Models\Lead;
use App\Models\RemarksModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Termwind\Components\Dd;
use Yajra\DataTables\Facades\DataTables;

class CallBackController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();
        $leads = $user->userProfile->leads;
        $callbacks = [];
        $leadArr = [];
        $dispositions = Disposition::orderBy('name', 'asc')->get();
        foreach($leads as $lead){
            $callback = Callback::where('lead_id', $lead->id)->first();
            if($callback){
                $callbacks[] = $callback;
                $leadArr[] = $lead;
            }
        }
        if($request->ajax()){
            return DataTables::of($callbacks)
            ->addColumn('date', function ($data) {
                $date = date('M d, Y', strtotime($data->date_time));
                $time =  date('h:i A', strtotime($data->date_time));
                return $date;
            })
            ->addColumn('disposition', function ($data){
                $disposition = Disposition::find($data->type);
            return $disposition ? $disposition->name : '';
            })
            ->addColumn('company_name', function ($data){
                $lead = Lead::find($data->lead_id);
                $remarkId = 0;
                $companyName = '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$lead->id.'" data-callbackid="'.$data->id.'" data-type="'.$data->type.'" data-remarks="'.$data->remarks.'" data-date="'.$data->date_time.'" data-remarksid="'.$remarkId.'" data-name="'.$lead->company_name.'">'.$lead->company_name.'</a>';
                return $lead ? $companyName : '';
            })
            ->addColumn('tel_num', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->tel_num : '';
            })
            ->addColumn('state_abbr', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->state_abbr : '';
            })
            ->addColumn('class_code', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->class_code : '';
            })
            ->rawColumns(['company_name'])
            ->make(true);
        }
        return view('leads.call_back.index', compact('leads', 'dispositions'));
    }

    public function callBackListToday(Request $request)
    {
        if($request->ajax())
        {
            $callBack = new Callback();
            $data = $callBack->getCallBackToday();
            // dd($data);
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name_link', function($data){
                $callData = Callback::where('lead_id', $data->id)->first();
                $companyName = '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$data->id.'" data-callbackid="'.$callData->id.'" data-type="'.$callData->type.'" data-remarks="'.$callData->remarks.'" data-date="'.$callData->date_time.'" data-remarksid="'.$data->id.'" data-name="'.$data->company_name.'">'.$data->company_name.'</a>';
                return $companyName;
            })
            ->addColumn('disposition', function($data){
                $disposition = Disposition::find($data->disposition_id);
                return $disposition->name;
            })
            ->addColumn('callback_date', function($data){
                $callBack = Callback::where('lead_id', $data->id)->first();
                $date = date('M d, Y', strtotime($callBack->date_time));
                $time =  date('h:i A', strtotime($callBack->date_time));
                return $time;
            })

            ->rawColumns(['company_name_link', 'disposition'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            if($data['status'] == 1){
                $lead = Lead::find($data['leadId']);
                $lead->disposition_id = $data['type'];
                $lead->save();
            }
            if(Callback::where('lead_id', $data['leadId'])->exists()){
                $callback = Callback::where('lead_id', $data['leadId'])->first();
            }else{
                $callback = new Callback();
            }
            $callback->lead_id = $data['leadId'];
            $callback->type = $data['type'];
            $callback->date_time = $data['dateTime'];
            $callback->remarks = $data['callBackRemarks'] ? $data['callBackRemarks'] : ' ';
            $callback->status = $data['status'];
            $callback->save();

            DB::commit();
            return response()->json(['success' => 'Succefully Added in callback'], 200);

        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            // Handle the exception and return an appropriate error response
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }

    public function storeAppointedCallback(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            if(Callback::where('lead_id', $data['leadId'])->exists()){
                $callback = Callback::where('lead_id', $data['leadId'])->first();
            }else{
                $callback = new Callback();
            }
            $callback->lead_id = $data['leadId'];
            $callback->type = $data['type'];
            $callback->date_time = $data['dateTime'];
            $callback->remarks = $data['callBackRemarks'] ? $data['callBackRemarks'] : ' ';
            $callback->status = $data['status'];
            $callback->save();

            DB::commit();
            return response()->json(['success' => 'Succefully Added in callback'], 200);

        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            // Handle the exception and return an appropriate error response
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $leadSaving = $lead->save();
            if($leadSaving){
                $callback = Callback::find($id);
                $callback->date_time = $data['dateTime'];
                $callback->remarks = isset($data['callBackRemarks']) ? $data['callBackRemarks'] : ' ';
                $callback->type = $data['dispositionId'];
                $callback->status = $data['status'];
                $callback->save();
            }
            DB::commit();
            return response()->json(['success' => 'Succefully Updated in callback'], 200);
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());

            // Handle the exception and return an appropriate error response
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }

    public function otherDispositionsData(Request $request)
    {
        $user = auth()->user();
        $leads = $user->userProfile->leads;
        $remarksLeads = [];
        foreach($leads as $lead){
            $remarksLead = RemarksModel::where('lead_id', $lead->id)->first();
            if($remarksLead){
                $remarksLeads[] = $remarksLead;
            }
        }
        if($request->ajax()){
            return DataTables::of($remarksLeads)
            ->addColumn('company_name', function ($data){
                $lead = Lead::find($data->lead_id);
                $callBackId = 0;
                $companyName = '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$lead->id.'" data-remarksid="'.$data->id.'" data-type="'.$data->type.'" data-remarks="'.$data->remarks.'" data-name="'.$lead->company_name.'" data-callbackid="'.$callBackId.'" class="companyLink">'.$lead->company_name.'</a>';
                return $lead ? $companyName : '';
            })
            ->addColumn('disposition', function ($data){
                $disposition = Disposition::find($data->type);
            return $disposition ? $disposition->name : '';
            })
            ->addColumn('tel_num', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->tel_num : '';
            })
            ->addColumn('class_code', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->class_code : '';
            })
            ->addColumn('state_abbr', function ($data){
                $lead = Lead::find($data->lead_id);
                return $lead ? $lead->state_abbr : '';
            })
            ->addColumn('created_at', function ($data) {
                $date = date('M d, Y', strtotime($data->updated_at));
                return $date;
            })
            ->rawColumns(['company_name'])
            ->make(true);
        }

    }

    public function updateNonCallbackDispositions(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $lead->save();

            $remarksLead = RemarksModel::find($id);
            $remarksLead->lead_id = $data['leadId'];
            $remarksLead->type = $data['dispositionId'];
            $remarksLead->remarks = isset($data['callBackRemarks']) ? $data['callBackRemarks'] : ' ';
            $remarksLead->save();

            DB::commit();
            return response()->json(['success' => 'Succefully updated'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }

    }

    public function deleteNonCallbackDisposition(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $leadSaving = $lead->save();
            if($leadSaving){
                $remarksLead = RemarksModel::find($id);
                $remarksLead->delete();
            }
            DB::commit();
            return response()->json(['success' => 'Succefully deleted'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function deleteCallBackDisposition(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $leadSaving = $lead->save();
            if($leadSaving){
                $callback = Callback::find($id);
                $callback->delete();
            }
            DB::commit();
            return response()->json(['success' => 'Succefully deleted'], 200);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

}
