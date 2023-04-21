<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControllerNew extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
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

    public function store(Dashboard $dashboard, Request $request)
    {
        // Collect input data
        $inputData = $request->only([
            'loginType', 'dayName', 'month', 'dayNum', 'year', 'hour', 'minutes', 'seconds', 'period'
        ]);

        // Convert month name to month number
        $monthNumber = Carbon::parse($inputData['month'])->month;

        // Combine the date and time values into a single string
        $dateTimeString = sprintf('%s-%s-%s %s:%s:%s %s', $inputData['year'], $monthNumber, $inputData['dayNum'], $inputData['hour'], $inputData['minutes'], $inputData['seconds'], $inputData['period']);

        // Parse and format the date and time using Carbon
        $dateTime = Carbon::createFromFormat('Y-n-d h:i:s A', $dateTimeString);
        $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

        // Assuming you have a unique identifier for the user or the time entry, e.g., user_id
        $user_id = auth()->user()->id;

        // Date Range within the day and between 10:00 pm to 8:00 am PHT (next day)
        $startOfDay = Carbon::today()->setTimezone('Asia/Manila')->setTime(22, 0, 0);
        $endOfDay = Carbon::tomorrow()->setTimezone('Asia/Manila')->setTime(8, 0, 0);

        // Use Case depends on the button that clicked
        switch ($inputData['loginType']) {
            case 'time_in':
                // Find the latest entry for the user with a time_out
                $latestTimeOut = Dashboard::where('user_id', $user_id)
                    ->whereNotNull('log_out')
                    ->latest('log_out')
                    ->first();

                // If there's a latest time_out entry and it is on the same day
                if ($latestTimeOut && Carbon::parse($latestTimeOut->log_out)->isSameDay($dateTime)) {
                    // OT In
                    Dashboard::create([
                        'user_id' => $user_id,
                        'login_type' => 'ot_in',
                        'log_in' => $formattedDateTime,
                    ]);

                    return response()->json(['success' => true, 'responseData' => 'Success on inserting the OT in entry.']);
                } else {
                    // Normal time_in
                    // If you are already timed in, you cannot log in again.
                    $ifAlreadyLoggedIn = Dashboard::where('user_id', $user_id)
                        ->whereNotNull('log_in')
                        ->whereNull('log_out')
                        ->whereBetween('log_in', [$startOfDay, $endOfDay])
                        ->latest()
                        ->first();

                    // If the user is already timed in, return an error message
                    if ($ifAlreadyLoggedIn) {
                        return response()->json(['error' => true, 'responseData' => 'Already Logged In!']);
                    }

                    // Create a new record
                    Dashboard::create([
                        'user_id' => $user_id,
                        'login_type' => 'time_in',
                        'log_in' => $formattedDateTime,
                    ]);

                    return response()->json(['success' => true, 'responseData' => 'Success on inserting the time in entry.']);
                }
                break;
            case 'time_out':
                // Find the latest entry for the user with an 'ot_in'
                $latestOtIn = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 'ot_in')
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest('log_in')
                    ->first();

                // If there's a latest 'ot_in' entry and it is on the same day
                if ($latestOtIn && Carbon::parse($latestOtIn->log_in)->isSameDay($dateTime)) {
                    // OT Out
                    // Update the entry
                    $latestOtIn->login_type = 'ot_out';
                    $latestOtIn->log_out = $formattedDateTime;
                    $latestOtIn->save();

                    return response()->json(['success' => true, 'responseData' => 'Success on updating the OT out entry.']);
                } else {
                    // Normal time_out
                    // If you are already timed out, you cannot time out again.
                    $ifAlreadyLoggedOut = Dashboard::where('user_id', $user_id)
                        ->whereNotNull('log_in')
                        ->whereNotNull('log_out')
                        ->whereBetween('log_in', [$startOfDay, $endOfDay])
                        ->latest()
                        ->first();

                    // If the user is already timed out, return an error message
                    if ($ifAlreadyLoggedOut) {
                        return response()->json(['error' => true, 'responseData' => 'Already Logged Out!']);
                    }

                    // Find the latest entry for the user that doesn't have a time_out yet
                    $timeEntry = Dashboard::where('user_id', $user_id)
                        ->whereNull('log_out')
                        ->orderBy('log_in', 'desc')
                        ->first();

                    // If there's a result
                    if ($timeEntry) {
                        // Update the entry
                        $timeEntry->login_type = 'time_out';
                        $timeEntry->log_out = $formattedDateTime;
                        $timeEntry->save();

                        return response()->json(['success' => true, 'responseData' => 'Success on updating the time out entry.']);
                    } else {
                        return response()->json(['success' => false, 'responseData' => 'Error on updating']);
                    }
                }
                break;
            case 'break_out':

                // If you are already timed in, you cannot logged in again.
                $ifAlreadyBreakOut = Dashboard::where('user_id', $user_id)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest()
                    ->first();

                // If the user is already timed in, return an error message
                if ($ifAlreadyBreakOut) {
                    return response()->json(['error' => true, 'responseData' => 'Already Break Out!']);
                }

                // Create a new record
                Dashboard::create([
                    'user_id' => $user_id,
                    'login_type' => 'break_out',
                    'log_in' => $formattedDateTime,
                ]);

                return response()->json(['success' => true, 'responseData' => 'Success on inserting the break out entry.']);
                break;
            case 'break_in':

                // If you are already timed out, you cannot timed out again.
                $ifAlreadyBreakIn = Dashboard::where('user_id', $user_id)
                    ->whereNotNull('log_in')
                    ->whereNotNull('log_out')
                    ->latest()
                    ->first();

                // If the user is already timed out, return an error message
                if ($ifAlreadyBreakIn) {
                    return response()->json(['error' => true, 'responseData' => 'Already Break In!']);
                }

                // Find the latest entry for the user that doesn't have a break_in yet
                $timeEntry = Dashboard::where('user_id', $user_id)
                    ->whereNull('log_out')
                    ->orderBy('log_in', 'desc')
                    ->first();

                // If theres a result
                if ($timeEntry) {
                    // Update the entry
                    $timeEntry->login_type = 'break_in';
                    $timeEntry->log_out = $formattedDateTime;
                    $timeEntry->save();
                    return response()->json(['success' => true, 'responseData' => 'Success on updating the break in entry.']);
                } else {
                    return response()->json(['success' => false, 'responseData' => 'error on updating the break in entry.']);
                }
                break;
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
