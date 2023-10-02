<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LeadNotes;
use App\Models\User;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    //

    public function createNotes(Request $request)
    {
        $noteTitle = $request->input('noteTitle');
        $noteDescription = $request->input('noteDescription');
        $userProfileId = User::find(auth()->user()->id)->userProfile->id;
        $leadId = $request->input('leadId');

        $leadNotes = new LeadNotes();
        $leadNotes->lead_id = $leadId;
        $leadNotes->user_profile_id = $userProfileId;
        $leadNotes->title = $noteTitle;
        $leadNotes->description = $noteDescription;
        $leadNotes->save();
    }

    public function getNotes($id)
    {
        if(request()->ajax()){
            $leadNotes = LeadNotes::findorFail($id);
            $fullamericanName = $leadNotes->userProfile->fullAmericanName();
            return response()->json(['result' => $leadNotes, 'fullamericanName' => $fullamericanName]);
        }
    }
}
