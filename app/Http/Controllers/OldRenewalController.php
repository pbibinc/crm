<?php

namespace App\Http\Controllers;

use App\Events\HistoryLogsEvent;
use App\Http\Controllers\Controller;
use App\Models\PolicyDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class OldRenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer-service.renewal.old-renewal.index');
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

    public function getOldRenewalPolicyList(Request $request)
    {
        try {
            $policyDetail = new PolicyDetail();
            $oldRenewal = $policyDetail->whereIn('status', ['Old Renewal'])->orderBy('id', 'desc')->get();

            if ($request->ajax()) {
                return DataTables::of($oldRenewal)
                    ->addIndexColumn()
                    ->addColumn('policy_no', function($oldRenewal) {
                        $policyNumber = $oldRenewal->policy_number;
                        $leadId = optional($oldRenewal->QuotationProduct->QuoteInformation->quoteLead->leads)->id;
                        $policyNumberLink = $leadId
                            ? '<a href="/appointed-list/' . $leadId . '"  id="' . $oldRenewal->id . '">' . $policyNumber . '</a>'
                            : $policyNumber;
                        return $policyNumberLink ?? '';
                    })
                    ->addColumn('company_name', function($oldRenewal) {
                        return optional($oldRenewal->QuotationProduct->QuoteInformation->quoteLead->leads)->company_name ?? '';
                    })
                    ->addColumn('expired_date', function($oldRenewal){
                        return $oldRenewal->expiration_date
                        ? Carbon::parse($oldRenewal->expiration_date)->format('M d, Y') // Adjust the format as needed
                        : ' ';
                    })
                    ->addColumn('action', function($oldRenewal) {
                       $leadId = $oldRenewal->QuotationProduct->QuoteInformation->quoteLead->leads->id;
                       $subjectForRecoverButton = '<button type="button" class="btn btn-success btn-sm recoverPolicy" id="' . $oldRenewal->id . '"><i class="mdi mdi-recycle-variant"></i></button>';
                       $viewNoteButton = '<button class="btn btn-outline-primary btn-sm waves-effect waves-light viewNotedButton" id="'.$leadId.'"><i class="ri-message-2-line"></i></button>';
                       return $subjectForRecoverButton . ' ' . $viewNoteButton;
                    })
                    ->rawColumns(['policy_no', 'expired_date', 'action'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function forRewritePolicy(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            $user = Auth::user();
            $userProfile = $user->userProfile;

            $policyDetail = PolicyDetail::find($data['id']);
            $policyDetail->status = 'Rewrite Old Renewal';
            $policyDetail->save();

            $userProfile->AssignedForRewritePolicy()->attach($policyDetail->id, ['assigned_at' => now()]);

            $lead = $policyDetail->QuotationProduct->QuoteInformation->quoteLead->leads;
            event(new HistoryLogsEvent($lead->id, $userProfile->id, 'Policy For Recovery Rewrite', $policyDetail->policy_number . ' ' .  'has been set for recovery rewrite'));

            DB::commit();
            return response()->json(['success' => 'Policy has been set for recovery rewrite.']);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}