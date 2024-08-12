<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\ScrubbedDnc;
use App\Models\TempDnc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ScrubbedDncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $scrubbedDnc = ScrubbedDnc::all()->sortBy('created_at');
        return DataTables::of($scrubbedDnc)
        ->addIndexColumn()
        ->addColumn('company_name', function($scrubbedDnc) {
            return $scrubbedDnc->lead->company_name;
        })
        ->addColumn('tel_num', function($scrubbedDnc) {
            return $scrubbedDnc->lead->tel_num;
        })
        ->addColumn('checkbox', function($scrubbedDnc){
            return '<input type="checkbox" name="leads_checkbox[]"  class="leads_checkbox" value="'.$scrubbedDnc->id.'" />';
            // return '<input type="checkbox" name="leads_checkbox[]" class="leads_checkbox" value="'.$scrubbedDnc->lead_id.'">';

        })
        ->rawColumns(['checkbox'])
        ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tempDncTelNum = TempDnc::pluck('tel_num')->toArray();
        $leads = Lead::pluck('tel_num', 'id')->toArray();

        $filteredLeads = array_filter($leads, function ($tel_num) use ($tempDncTelNum) {
            return in_array($tel_num, $tempDncTelNum);
        });
        $filteredLeadIds = array_keys($filteredLeads);

        foreach($filteredLeadIds as $leadId) {
            $scrubbedDnc = new ScrubbedDnc();
            if($scrubbedDnc->where('lead_id', $leadId)->exists()) {
                continue;
            }else{
                $scrubbedDnc->lead_id = $leadId;
                $scrubbedDnc->save();
            }

        };
        return response()->json(['message' => 'Scrubbed DNC created successfully']);
        // foreach

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function requestForDnc(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $ids = $data['ids'];
            foreach($ids as $id) {
                $scrubbedDnc = new ScrubbedDnc();
                $scrubbedDnc->lead_id = $id;
                $savedScrubbed = $scrubbedDnc->save();
                if($savedScrubbed) {
                    $tempDnc = TempDnc::where('tel_num', $scrubbedDnc->lead->tel_num)->first();
                    $tempDnc->delete();
                }else{

                }
            }
            DB::commit();
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }

}