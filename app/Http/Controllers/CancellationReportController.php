<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancellationReport;
use App\Models\PolicyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CancellationReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
      try{
        DB::beginTransaction();
        $data = $request->all();
        $cancellationReport = new CancellationReport();

        $cancellationReport->policy_details_id = $data['policyId'];
        $cancellationReport->type_of_cancellation = $data['typeOfCancellationDropdown'];
        $cancellationReport->agent_remarks = $data['agentRemakrs'];
        $cancellationReport->recovery_action = $data['recoveryAction'];
        if($data['intent'] = 1){
            $cancellationReport->reinstated_date = $data['reinstatedDate'];
            $cancellationReport->reinstated_eligibility_date = $data['reinstatedEligibilityDate'];

            $policyDetail = PolicyDetail::find($data['policyId']);
            $policyDetail->status = 'Intent';
            $policyDetail->save();
        }
        $cancellationReport->save();

        DB::commit();
      }catch(\Exception $e){
          return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
      }
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
}
