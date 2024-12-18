<?php

namespace App\Http\Controllers;

use App\Events\HistoryLogsEvent;
use App\Models\Lead;
use App\Models\QuoteLead;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\QuotationProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointedProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userProfile = new UserProfile();
        $apptaker = $userProfile->apptaker();
        $quoters = $userProfile->qouter();
        $userProfiles = $userProfile->userProfiles();

        $qoutingCount = QuotationProduct::quotingProduct()->count();
        $lead = new Lead();
        $quoteLead = new QuoteLead();
        $appointedLeads = $lead->getAppointedLeads();
        $appointedLeadCount = $appointedLeads->count();

        // Now this is a paginated collection
        $appointedProducts = $quoteLead->getAppointedProductByLeads();
        $groupedProducts = $appointedProducts->groupBy('company');

        if ($request->ajax()) {
            return view('leads.appointed-products.pagination', compact('groupedProducts', 'appointedProducts'))->render();
        }

        return view('leads.appointed-products.index', compact('quoters', 'userProfiles', 'appointedLeadCount', 'qoutingCount', 'groupedProducts', 'appointedProducts'));
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

    public function changeProductStatus(Request $request)
    {
        try{
            DB::beginTransaction();

            $quotationProduct = QuotationProduct::find($request->id);
            $quotationProduct->status = $request->status;
            $quotationProduct->save();

            $leadId = $quotationProduct->QuoteInformation->QuoteLead->leads->id;
            $userProfileId = Auth::user()->userProfile->id;
            event(new HistoryLogsEvent($leadId, $userProfileId, 'Send For Quotation', $quotationProduct
            ->product . ' ' . 'has been sent for quotation'));

            DB::commit();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            DB::rollback();
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}