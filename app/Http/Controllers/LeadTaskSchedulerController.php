<?php

namespace App\Http\Controllers;

use App\Events\LeadNotesNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\LeadTaskScheduler;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use Yajra\DataTables\Facades\DataTables;

class LeadTaskSchedulerController extends Controller
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

            $leadTaskScheduler = new LeadTaskScheduler();
            $leadTaskScheduler->assigned_by = auth()->user()->userProfile->id;
            $leadTaskScheduler->assigned_to = $data['taskAssignTo'];
            $leadTaskScheduler->leads_id = $data['leadId'];
            $leadTaskScheduler->description = $data['taskDescription'];
            $leadTaskScheduler->status = $data['taskStatus'];
            $leadTaskScheduler->date_schedule = $data['taskDate'];
            $leadTaskScheduler->save();

            $assignedToUserProfile  = UserProfile::find($data['taskAssignTo']);
            $user = User::find($assignedToUserProfile->user_id);

            $user->sendNoteNotification($user, 'Task Schedule On'. ' ' . $data['taskDate'] , $leadTaskScheduler->assigned_by, $data['taskDescription'], $data['leadId']);

            broadcast(new LeadNotesNotificationEvent('Task Schedule On'. ' ' .$data['taskDate'],  $data['taskDescription'], $user->id, $data['leadId'], $leadTaskScheduler->assigned_by, 'info'));

            DB::commit();
            return response()->json(['message' => 'Task has been successfully assigned'], 200);
        }catch(\Exception $e){
            DB::rollBack();
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
        try{
            $userProfileId = auth()->user()->userProfile->id;
            $leadTaskScheduler = LeadTaskScheduler::find($id);
            return response()->json([
                'message' => 'Task information retrieved successfully',
                'data' => $leadTaskScheduler
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'An error occurred while retrieving the task information',
                'error' => $e->getMessage()
            ], 500);
        }
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
      try{
        DB::beginTransaction();
        $data = $request->all();

        $leadTaskScheduler = LeadTaskScheduler::find($id);
        $leadTaskScheduler->assigned_to = $data['taskAssignTo'];
        $leadTaskScheduler->leads_id = $data['leadId'];
        $leadTaskScheduler->description = $data['taskDescription'];
        $leadTaskScheduler->status = $data['taskStatus'];
        $leadTaskScheduler->date_schedule = $data['taskDate'];
        $leadTaskScheduler->save();

        $assignedToUserProfile  = UserProfile::find($data['taskAssignTo']);

        $user = User::find($assignedToUserProfile->user_id);

        if($leadTaskScheduler->status == 'Completed'){
            $user = User::find($leadTaskScheduler->assigned_by);

            $user->sendNoteNotification($user, 'Completed Task', $leadTaskScheduler->assigned_to, $data['taskDescription'], $data['leadId']);

            broadcast(new LeadNotesNotificationEvent('Completed Task',  $data['taskDescription'], $user->id, $data['leadId'], $leadTaskScheduler->assigned_to, 'info'));
        }else{
            $user->sendNoteNotification($user, 'Task Schedule On'. $data['taskDate'] , $leadTaskScheduler->assigned_by, $data['taskDescription'], $data['leadId']);
            broadcast(new LeadNotesNotificationEvent('Task Schedule On'. $data['taskDate'],  $data['taskDescription'], $data['taskAssignTo'], $data['leadId'], $leadTaskScheduler->assigned_by, 'info'));
        }
        DB::commit();
        return response()->json(['message' => 'Task has been successfully assigned'], 200);
    }catch(\Exception $e){
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
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

    public function getTaskScheduler(Request $request)
    {
        $leadId = $request->input('leadId');
        $userProfileId = auth()->user()->userProfile->id;
        $taskScheduler = LeadTaskScheduler::where('leads_id', $leadId)
        ->where(function($query) use ($userProfileId){
            $query->where('assigned_to', $userProfileId);
        })
        ->whereNotIn('status', ['Completed', 'Remove'])->with(['assignedTo.media', 'assignedBy.media'])->get();
        return response()->json(['data' => $taskScheduler], 200);
    }

    public function getTaskSchedulerList(Request $request)
    {
        $leadId = $request->input('leadId');
        $tastSchedulerList = LeadTaskScheduler::where('leads_id', $leadId)->whereNot('status', 'Remove')->with(['assignedTo.media'])->orderBy('date_schedule')->get();
        return DataTables::of($tastSchedulerList)
        ->addColumn('assigned_to', function($taskScheduler){
            $assignedToName = $taskScheduler->assignedTo->firstname . ' ' . $taskScheduler->assignedTo->lastname;
            return $assignedToName ? $assignedToName : 'N/A';
        })
        ->addColumn('assigned_by', function($taskScheduler){
            $assignedByName = $taskScheduler->assignedTo->firstname . ' ' . $taskScheduler->assignedTo->lastname;
            return $assignedByName ? $assignedByName : 'N/A';
        })
        ->addColumn('date_schedule', function($taskScheduler){
            $dateschedule = \Carbon\Carbon::parse($taskScheduler->date_schedule)->format('m/d/Y');
            return $dateschedule ? $dateschedule : 'N/A';
        })
        ->make(true);
    }

    public function getTaskDetails(Request $request)
    {
        $taskScheduler = LeadTaskScheduler::with(['assignedTo', 'assignedBy'])
            ->find($request->input('taskId'));

        if (!$taskScheduler) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['data' => $taskScheduler], 200);
    }

    public function getTaskByStatus(Request $request)
    {
        $status = $request->input('status');
        $userProfileId = auth()->user()->userProfile->id;

        $tastSchedulerList = LeadTaskScheduler::with(['assignedTo.media', 'assignedBy.media'])
            ->where('status', $status)
            ->where(function($query) use ($userProfileId) {
                $query->where('assigned_to', $userProfileId);
            })
            ->orderBy('date_schedule', 'desc')
            ->paginate(10);
        return response()->json(['data' => $tastSchedulerList], 200);
    }

}