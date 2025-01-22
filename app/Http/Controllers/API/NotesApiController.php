<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LeadNotes;
use App\Models\OldCrmLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotesApiController extends BaseController
{
    //

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $note = new LeadNotes();
            $note->lead_id = $data['lead_id'];
            $note->user_profile_id = 1;
            $note->title = $data['title'];
            $note->description = $data['description'];
            $note->save();

            $oldCrmLink = new OldCrmLink();
            $oldCrmLink->lead_id = $data['lead_id'];
            $oldCrmLink->crm_link = $data['crm_link'];
            $oldCrmLink->save();

            DB::commit();
            return $this->sendResponse(['data' => $note->toArray(), 'status' => 200, 'message' => 'Note Created Successfully',  'success' => true,], 'Note created successfully.', 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return $this->sendError(['message' => $e->getMessage(), 'status' => 500,  'success' => false,], 500);
        }
    }
}
