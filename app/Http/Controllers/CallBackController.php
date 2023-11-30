<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\Disposition;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $dispositions = Disposition::all();
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
                return $date. ' ' .$time;
            })

            ->addColumn('disposition', function ($data){
                $disposition = Disposition::find($data->type);
                return $disposition ? $disposition->name : '';
            })
            ->addColumn('company_name', function ($data){
                $lead = Lead::find($data->lead_id);
                $companyName = '<a href="#" data-toggle="modal" id="companyLink" name="companyLinkButtonData" data-target="#leadsDataModal" data-id="'.$lead->id.'" data-callbackid="'.$data->id.'" data-remarks="'.$data->remarks.'" data-date="'.$data->date_time.'" data-name="'.$lead->company_name.'">'.$lead->company_name.'</a>';
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

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $type = 0;
            switch($data['dispositionId']){
                case 2:
                    $type = 2;
                    break;
                case 11:
                    $type = 11;
                    break;
                case 12:
                    $type = 12;
                    break;
                case 6:
                    $type = 6;
                    break;
            }

            $lead = Lead::find($data['leadId']);
            $lead->disposition_id = $data['dispositionId'];
            $lead->save();

            $callback = new Callback();
            $callback->lead_id = $data['leadId'];
            $callback->type = $type;
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
        $callback = Callback::find($id);
        $data = $request->all();
        dd($data);
        // try{
        //     DB::beginTransaction();
        //     $data = $request->all();
        //     $callback = Callback::where('lead_id', $id)->first();
        //     $callback->date_time = $data['dateTime'];
        //     $callback->remarks = $data['callBackRemarks'] ? $data['callBackRemarks'] : ' ';
        //     $callback->status = $data['status'];
        //     $callback->save();

        //     DB::commit();
        //     return response()->json(['success' => 'Succefully Updated in callback'], 200);

        // }catch(\Exception $e){
        //     DB::rollback();
        //     Log::error($e->getMessage());

        //     // Handle the exception and return an appropriate error response
        //     return response()->json(['error' => 'An error occurred'], 500);
        // }

    }
}