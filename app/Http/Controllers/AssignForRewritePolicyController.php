<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CancelledPolicyForRecall;
use App\Models\PolicyDetail;
use App\Models\UserProfile;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignForRewritePolicyController extends Controller
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

            $userProfile = UserProfile::find($data['userProfileId']);

            $policyIds = is_array($data['id']) ? $data['id'] : explode(',', $data['id']);

            foreach($policyIds as $policyId){
                $userProfile->AssignedForRewritePolicy()->attach($policyId, ['assigned_at' => now()]);
                $policyDetail = PolicyDetail::find($policyId);
                $policyDetail->status = 'For Rewrite';
                $policyDetail->save();

                $CancelledPolicyForRecall = CancelledPolicyForRecall::find($data['cancellationId']);
                $CancelledPolicyForRecall->status = 'For Rewrite';
                $CancelledPolicyForRecall->save();
            }


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Policy assigned for rewrite successfully'
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
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

    public function getuserProfileAndCancelledPolicy(Request $request)
    {
        try{
            $userProfile = UserProfile::find($request->userProfileId);
            $policyDetail = PolicyDetail::find($request->id);
            $product = $policyDetail->QuotationProduct;
            return response()->json([
                'userProfile' => $userProfile,
                'policyDetail' => $policyDetail,
                'product' => $product
            ], 200);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}