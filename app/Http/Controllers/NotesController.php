<?php

namespace App\Http\Controllers;

use App\Events\DeclinedRequest;
use App\Events\LeadNotesNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\GeneralInformation;
use App\Models\LeadNotes;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class NotesController extends Controller
{
    //

    public function createNotes(Request $request)
    {
        try{
            DB::beginTransaction();
            $validateData = $request->validate([
                'noteTitle' => 'required',
                'noteDescription' => 'required',
                'leadId' => 'required'
            ]);

            $noteTitle = $request->input('noteTitle');
            $noteDescription = $request->input('noteDescription');
            $status = $request->input('status');
            $userProfileId = User::find(auth()->user()->id)->userProfile->id;
            $leadId = $request->input('leadId');
            $generalInformationId = GeneralInformation::where('leads_id', $leadId)->first()->id;
            $productId = $request->input('productId');
            $notifyUserIds = $request->input('userToNotify');
            $icon = $request->input('icon') ? $request->input('icon') : 'info';
            $departmentIds = $request->input('departmentIds');

            $leadNotes = new LeadNotes();
            $leadNotes->lead_id = $leadId;
            $leadNotes->user_profile_id = $userProfileId;
            $leadNotes->title = $noteTitle;
            $leadNotes->description = $noteDescription;
            $leadNotes->status = $status;
            $leadNotes->save();

            if($notifyUserIds !== null){
              foreach($notifyUserIds as $notifyUserId){
                $user = User::find($notifyUserId);
                $user->sendNoteNotification($user, $noteTitle, $userProfileId,  $noteDescription, $leadId);
                broadcast(new LeadNotesNotificationEvent($noteTitle, $noteDescription, $notifyUserId, $leadId, $userProfileId, $icon));
              }
            }

            if($departmentIds !== null){
                $userIds = UserProfile::whereIn('department_id', $departmentIds)->pluck('user_id')->unique()->toArray();
                foreach($userIds as $userId){
                  $user = User::find($userId);
                  $user->sendNoteNotification($user, $noteTitle, $userProfileId,  $noteDescription, $leadId);
                  broadcast(new LeadNotesNotificationEvent($noteTitle, $noteDescription, $userId, $leadId, $userProfileId, $icon));
                }
            }

            DB::commit();
            return response()->json(['message' => 'Data stored successfully']);
        }catch (ValidationException $e){
            DB::rollBack();
            Log::error('Notes Error', [$e->validator->errors()]);
            return response()->json([
                'errors' => $e->validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }
    }

    public function getNotes($id)
    {
        if(request()->ajax()){

            $leadNotes = LeadNotes::findorFail($id);
            $fullamericanName = $leadNotes->userProfile->fullAmericanName();
            return response()->json(['result' => $leadNotes, 'fullamericanName' => $fullamericanName]);
        }
    }

    public function getGeneralInformation($id)
    {

    }

    public function getNoteUsingLeadid($id)
    {
        if(request()->ajax()){
            $leadNotes = LeadNotes::where('lead_id', $id)->with('userProfile')->get();
            $userProfileId = UserProfile::where('user_id', auth()->user()->id)->first()->id;
            return response()->json(['notes' => $leadNotes, 'userProfileId' => $userProfileId]);
        }
    }
}