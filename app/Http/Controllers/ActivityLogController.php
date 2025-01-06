<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\GeneralActivity;
use App\Models\LeadTaskScheduler;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
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
            $generalActivity = new GeneralActivity();
            $generalActivity->activity_date = $request->date;
            $generalActivity->title = $request->title;
            $generalActivity->description = $request->description;
            $generalActivity->save();
            DB::commit();

            return response()->json([
                'message' => 'Activity log stored successfully',
                'data' => $generalActivity
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'An error occurred while storing the activity log',
                'error' => $e->getMessage()
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

    public function getActivityLog()
    {
        try{
            $userProfileId = auth()->user()->userProfile->id;
            $activities = LeadTaskScheduler::where('assigned_to', $userProfileId)->where('status', '!=', 'completed')->orderBy('date_schedule', 'asc')->get();
            $leads = auth()->user()->userProfile->leads;
            $data = [];
            $generalActivity = GeneralActivity::orderBy('activity_date', 'asc')->get();
            $generalActivity->each(function ($activity) use (&$data) {
                $data[] = [
                    'id' => $activity->id,
                    'name' => $activity->title,
                    'date' => $activity->activity_date,
                    'type' => 'general',
                    'description' => $activity->description,
                    'color' => '#dc3545'
                ];
            });

            // Get all tasks assigned to the user
            $activities->each(function ($activity) use (&$data) {
                $assignedBy = $activity->assignedBy;
                $description = 'Assigned by ' . $assignedBy->firstname . ' ' . $assignedBy->lastname .
                ' for ' . $activity->leads->company_name .
                "<br>Description: " . $activity->description;
                $data[] = [
                    'id' => $activity->id,
                    'name' => 'Task',
                    'date' => $activity->date_schedule,
                    'type' => 'task',
                    'description' => $description,
                    'color' => '#007bff'
                ];
            });

            // Get all callbacks for the user
            foreach($leads as $lead){
                $callback = Callback::where('lead_id', $lead->id)->first();
                if($callback){
                    $data[] = [
                        'id' => $callback->id,
                        'name' => 'Callback',
                        'date' => $callback->date_time,
                        'type' => 'callback',
                        'description' => 'Call back for '. ' ' . $lead->company_name,
                        'color' => '#28a745' // Green for callbacks
                    ];
                }
            }

            return response()->json([
                'message' => 'Activity log retrieved successfully',
                'data' => $data
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'An error occurred while retrieving the activity log',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}