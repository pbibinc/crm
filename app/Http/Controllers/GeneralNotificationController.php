<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\LeadNotesNotificationEvent;
use App\Events\MarkAsReadNotificationEvent;
use App\Models\User;
use App\Models\UserProfile;

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

    public function getNotification(Request $request)
    {
        try{
            $user = User::find(auth()->user()->id);
            $page = $request->input('page', 1);
            $notifications = $user->notifications()->paginate(10, ['*'], 'page', $page);
            $notificationData = $notifications->map(function($notification){
                $data = $notification->data;
                $senderImage = null;
                if(isset($data['sender'])){
                    $senderProfile = UserProfile::find($data['sender']);
                    $senderImage = $senderProfile ? $senderProfile->media->filepath ?? null : null;
                }
                if(isset($data['notifyBy'])){
                    $senderProfile = UserProfile::find($data['notifyBy']);
                    $senderImage = $senderProfile ? $senderProfile->media->filepath :  null;
                }

                return array_merge($data, [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'notifiable_type' => $notification->notifiable_type,
                    'notifiable_id' => $notification->notifiable_id,
                    'data' => $data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at,
                    'sender_image' => $senderImage ?? null,
                ]);

            });
            return response()->json([
            'data' => $notificationData,'current_page' => $notifications->currentPage(),
            'last_page' => $notifications->lastPage(),
            'per_page' => $notifications->perPage(),
            'total' => $notifications->total(),
            'next_page_url' => $notifications->nextPageUrl(),
            'prev_page_url' => $notifications->previousPageUrl(),
        ], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function markAsRead(Request $request)
    {
        try{
            $user = User::find(auth()->user()->id);
            $user->notifications()->find($request->id)->markAsRead();
            $count = $user->unreadNotifications->count();
            broadcast(new MarkAsReadNotificationEvent($count));
            return response()->json(['success' => 'Notification marked as read.'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNotificationCount(Request $request)
    {
        try{

            $user = User::find(auth()->user()->id);
            $count = $user->unreadNotifications->count();
            return response()->json(['data' => $count], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}