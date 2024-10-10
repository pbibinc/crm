<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\LeadNotesNotificationEvent;
use App\Models\User;

class GeneralNotificationController extends Controller
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
        //
        try{
            DB::beginTransaction();
            $data = $request->all();

            $userToNotify = $data['userToNotify'];
            $title = $data['title'];
            $description = $data['description'];
            $leadId = $data['leadId'];
            $link = $data['link'];
            $userProfileId = User::find(auth()->user()->id)->userProfile->id;
            $user = User::find($userToNotify);
            $user->sendGeneralNotifcation($user, $link, $userProfileId,  $title, $description);
            broadcast(new LeadNotesNotificationEvent($title, $description, $user->id, $leadId, $userProfileId, 'info'));

            DB::commit();
            return response()->json(['success' => 'Notification sent successfully.'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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
