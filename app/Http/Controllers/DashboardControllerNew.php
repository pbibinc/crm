<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Dashboard;
use App\Models\Attendance;
use App\Models\BoundInformation;
use App\Models\PolicyDetail;
use App\Models\QuotationProduct;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class DashboardControllerNew extends Controller
{

    // public function checkAuxLogoutStatus()
    // {
    //     // Assuming you have a unique identifier for the user or the time entry, e.g., user_id
    //     $user_id = auth()->user()->id;

    //     // Get Aux Records in database
    //     $auxLogOutStatus = Dashboard::where('user_id', $user_id)
    //         ->whereIn('login_type', [5, 6])
    //         ->whereNotNull('log_out')
    //         ->latest('log_in')
    //         ->first();

    //     return response()->json(['status' => $auxLogOutStatus]);
    // }

    public function getAuxHistoryData()
    {
        // Assuming you have a unique identifier for the user or the time entry, e.g., user_id
        $user_id = auth()->user()->id;

        // Get current weekday name
        $dayOfTheWeek = Carbon::now()->englishDayOfWeek;

        // Get Aux Records in database
        $auxRecords = Dashboard::where('user_id', $user_id)
            ->whereIn('login_type', [5, 6])
            ->whereNotNull('log_in')
            ->get();

        // Initialize the array to store updated records
        $auxUpdatedRecords = [];

        // Loop through the records and calculate total hours for each record
        foreach ($auxRecords as $auxRecord) {
            if ($auxRecord->log_in !== NULL) {
                $auxLogIn = Carbon::parse($auxRecord->log_in)->format('g:i:s A');
                $auxLogOut = empty($auxRecord->log_out) ? null : Carbon::parse($auxRecord->log_out)->format('g:i:s A');
                $createdAt = Carbon::parse($auxRecord->created_at)->format('F j, Y');

                // Calculate the duration
                if ($auxLogOut !== null) {
                    // Parse the times into Carbon instances
                    $login_time = Carbon::parse($auxRecord->log_in);
                    $logout_time = Carbon::parse($auxRecord->log_out);

                    // Get the difference as a CarbonInterval
                    $diff = $login_time->diffAsCarbonInterval($logout_time);

                    // Format the interval as a duration
                    $duration = $diff->format('%h hours, %i minutes and %s seconds');

                    $auxRecord->formatted_duration = $duration;
                }

                // Get the day of the week for each record
                $dayOfTheWeek = Carbon::parse($auxRecord->created_at)->englishDayOfWeek;

                // Pass the data to AJAX
                $auxRecord->formatted_login = $auxLogIn;
                $auxRecord->formatted_logout = $auxLogOut;
                $auxRecord->formatted_weekday = $dayOfTheWeek;
                $auxRecord->formatted_created_at = $createdAt;
            }
            // Store on Array Container
            $auxUpdatedRecords[] = $auxRecord;
        }
        // Return the data as JSON
        return response()->json([
            'data' => $auxUpdatedRecords,
        ]);
    }

    public function getTableData()
    {
        // Assuming you have a unique identifier for the user or the time entry, e.g., user_id
        $user_id = auth()->user()->id;

        // Check if the database has a current record of time in for user, if yes remove the disabled on aux in and aux out
        $timeInRecord = Dashboard::where('user_id', $user_id)
            ->where('login_type', 1)
            ->latest('log_in')
            ->first();

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get current weekday name
        $dayOfTheWeek = Carbon::now()->englishDayOfWeek;
        $currentMonthName = Carbon::now()->format('F');

        // Check the records of the user for the current month
        $userAttendanceRecordCurrentMonth = Dashboard::where('user_id', $user_id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereNotIn('login_type', [5, 6])
            ->orderBy('log_in', 'DESC')
            ->paginate(5); // You can change the number 10 to the desired number of records per page

        // Initialize the array to store updated records
        $updatedRecords = [];

        // Loop through the records and calculate total hours for each record
        foreach ($userAttendanceRecordCurrentMonth as $record) {
            if ($record->log_in !== NULL) {
                $logIn = Carbon::parse($record->log_in)->format('g:i:s A');
                $logOut = Carbon::parse($record->log_out)->format('g:i:s A');
                $createdAt = Carbon::parse($record->created_at)->format('F j, Y');

                $record->formatted_login = $logIn;
                $record->formatted_logout = $logOut;
                $record->formatted_created_at = $createdAt;
                $record->formatted_weekdays = $dayOfTheWeek;

                if ($record->log_out !== NULL) {
                    $record->formatted_logout = $logOut;
                    // $totalShiftHours = $login_unformatted->diffInMinutes($logout_unformatted) / 60;
                    // $roundedTotalShiftHours = round($totalShiftHours, 2);
                    // $record->formatted_totalhrs = $roundedTotalShiftHours;
                } else {
                    $record->formatted_logout = "";
                    // $record->total_hours = "No log_out time";
                }

                switch ($record->login_type) {
                    case 1: // Time In
                        $record->formatted_logintype = "Time In";
                        break;

                    case 2: // Time Out
                        $record->formatted_logintype = "Time Out";
                        break;

                    case 3: // Break Out
                        $record->formatted_logintype = "Break Out";
                        break;

                    case 4: // Break In
                        $record->formatted_logintype = "Break In";
                        break;

                        // case 5: // Aux In
                        //     $record->formatted_logintype = "Aux In";
                        //     break;

                        // case 6: // Aux Out
                        //     $record->formatted_logintype = "Aux Out";
                        //     break;

                    case 7: // OT In
                        $record->formatted_logintype = "OT In";
                        break;

                    case 8: // OT Out
                        $record->formatted_logintype = "OT Out";
                        break;

                    default:
                        $record->formatted_logintype = "";
                        break;
                }
            } else {
                $record->total_hours = "No log_out time";
            }

            // Add the record to the updated records array
            $updatedRecords[] = $record;
        }

        $auxRecords = $this->getAuxHistoryData();

        // Return the data as JSON
        return response()->json([
            'data' => $updatedRecords,
            'links' => $userAttendanceRecordCurrentMonth->links(), // Pass the pagination links
            'auxRecords' => $auxRecords,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Assuming you have a unique identifier for the user or the time entry, e.g., user_id
        $user_id = auth()->user()->id;

        // Check if the database has a current record of time in for user, if yes remove the disabled on aux in and aux out
        $timeInRecord = Dashboard::where('user_id', $user_id)
            ->where('login_type', 1)
            ->latest('log_in')
            ->first();

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get current weekday name
        $dayOfTheWeek = Carbon::now()->englishDayOfWeek;
        $currentMonthName = Carbon::now()->format('F');

        // Check the records of the user for the current month
        $userAttendanceRecordCurrentMonth = Dashboard::where('user_id', $user_id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereNotIn('login_type', [5, 6])
            ->orderBy('log_in', 'DESC')
            ->paginate(5); // You can change the number 10 to the desired number of records per page

        // Initialize the array to store updated records
        $updatedRecords = [];

        // Loop through the records and calculate total hours for each record
        foreach ($userAttendanceRecordCurrentMonth as $record) {
            if ($record->log_in !== NULL) {
                $logIn = Carbon::parse($record->log_in)->format('g:i:s A');
                $logOut = Carbon::parse($record->log_out)->format('g:i:s A');
                $createdAt = Carbon::parse($record->created_at)->format('F j, Y');

                $record->formatted_login = $logIn;
                $record->formatted_logout = $logOut;
                $record->formatted_created_at = $createdAt;
                $record->formatted_weekdays = $dayOfTheWeek;

                if ($record->log_out !== NULL) {
                    $record->formatted_logout = $logOut;
                    // $totalShiftHours = $login_unformatted->diffInMinutes($logout_unformatted) / 60;
                    // $roundedTotalShiftHours = round($totalShiftHours, 2);
                    // $record->formatted_totalhrs = $roundedTotalShiftHours;
                } else {
                    $record->formatted_logout = "";
                    // $record->total_hours = "No log_out time";
                }

                switch ($record->login_type) {
                    case 1: // Time In
                        $record->formatted_logintype = "Time In";
                        break;

                    case 2: // Time Out
                        $record->formatted_logintype = "Time Out";
                        break;

                    case 3: // Break Out
                        $record->formatted_logintype = "Break Out";
                        break;

                    case 4: // Break In
                        $record->formatted_logintype = "Break In";
                        break;

                        // case 5: // Aux In
                        //     $record->formatted_logintype = "Aux In";
                        //     break;

                        // case 6: // Aux Out
                        //     $record->formatted_logintype = "Aux Out";
                        //     break;

                    case 7: // OT In
                        $record->formatted_logintype = "OT In";
                        break;

                    case 8: // OT Out
                        $record->formatted_logintype = "OT Out";
                        break;

                    default:
                        $record->formatted_logintype = "";
                        break;
                }
            } else {
                $record->total_hours = "No log_out time";
            }

            // Add the record to the updated records array
            $updatedRecords[] = $record;
        }

        // Get Aux Records in database
        $auxRecords = Dashboard::where('user_id', $user_id)
            ->whereIn('login_type', [5, 6])
            ->whereNotNull('log_in')
            ->get();

        // dd($auxRecords);

        // Initialize the array to store updated aux records
        $auxUpdatedRecords = [];

        // Loop through the records and calculate total hours for each record
        foreach ($auxRecords as $auxRecord) {
            if ($auxRecord->log_in !== NULL) {
                $auxLogIn = Carbon::parse($auxRecord->log_in)->format('g:i:s A');
                $auxLogOut = empty($auxRecord->log_out) ? null : Carbon::parse($auxRecord->log_out)->format('g:i:s A');
                $createdAt = Carbon::parse($auxRecord->created_at)->format('F j, Y');

                // Calculate the duration
                if ($auxLogOut !== null) {
                    // Parse the times into Carbon instances
                    $login_time = Carbon::parse($auxRecord->log_in);
                    $logout_time = Carbon::parse($auxRecord->log_out);

                    // Get the difference as a CarbonInterval
                    $diff = $login_time->diffAsCarbonInterval($logout_time);

                    // Format the interval as a duration
                    $duration = $diff->format('%h hours, %i minutes and %s seconds');

                    $auxRecord->formatted_duration = $duration;
                }

                // Get the day of the week for each record
                $dayOfTheWeek = Carbon::parse($auxRecord->created_at)->englishDayOfWeek;

                $auxRecord->formatted_login = $auxLogIn;
                $auxRecord->formatted_logout = $auxLogOut;
                $auxRecord->formatted_weekday = $dayOfTheWeek;
                $auxRecord->formatted_created_at = $createdAt;
            }

            $auxUpdatedRecords[] = $auxRecord;
        }

        return view('admin.dashboard.index', [
            'result' => $timeInRecord,
            'currentMonth' => $currentMonthName,
            'attendanceRecords' => $updatedRecords,
            'auxRecords' => $auxUpdatedRecords,
            'links' => $userAttendanceRecordCurrentMonth->links(), // Pass the pagination links
        ]);
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
        // loginType
        // 1 = Time In
        // 2 = Time Out
        // 3 = Break Out
        // 4 = Break In
        // 5 = Aux In
        // 6 = Aux Out
        // 7 = OT In
        // 8 = OT Out

        // Collect input data
        $inputData = $request->only([
            'loginType', 'auxDuration', 'dayName', 'month', 'dayNum', 'year', 'hour', 'minutes', 'seconds', 'period'
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
                // Time In
            case 1:
                // Check if the given time is within the OT range
                $isOvertime = !($dateTime->between($startOfDay, $endOfDay) || $dateTime->between($startOfDay->subDay(), $endOfDay->subDay()));

                // If it is overtime, insert an OT In (7) entry
                if ($isOvertime) {
                    Dashboard::create([
                        'user_id' => $user_id,
                        'login_type' => 7,
                        'log_in' => $formattedDateTime,
                    ]);

                    // Create also record on attendance_records_footprint
                    Attendance::create([
                        'user_id' => $user_id,
                        'login_type' => 7,
                        'log_in' => $formattedDateTime,
                    ]);

                    return response()->json(['success' => true, 'responseData' => 'Success on inserting the OT in entry.']);
                }

                // Normal time_in
                // If you are already timed in, you cannot log in again.
                $ifAlreadyLoggedIn = Dashboard::where('user_id', $user_id)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->where(function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereBetween('log_in', [$startOfDay, $endOfDay]) // between 10:00 PM today and 8:00 AM tomorrow
                            ->orWhereBetween('log_in', [$startOfDay->subDay(), $endOfDay->subDay()]); // between 10:00 PM yesterday and 8:00 AM today
                    })
                    ->latest('log_in')
                    ->first();

                // If the user is already timed in, return an error message
                if ($ifAlreadyLoggedIn) {
                    return response()->json(['error' => true, 'responseData' => 'Already Logged In!']);
                }

                // Create a new record
                Dashboard::create([
                    'user_id' => $user_id,
                    'login_type' => 1,
                    'log_in' => $formattedDateTime,
                ]);

                // Create also record on attendance_records_footprint
                Attendance::create([
                    'user_id' => $user_id,
                    'login_type' => 1,
                    'log_in' => $formattedDateTime,
                ]);

                return response()->json(['success' => true, 'responseData' => 'Success on inserting the time in entry.']);
                break;

                // Time Out
            case 2:

                // Time Out
                // Find the latest entry for the user with an 'ot_in'
                $latestOtIn = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 7)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest('log_in')
                    ->first();

                // If there's a latest 'ot_in' entry and it is on the same day
                if ($latestOtIn && Carbon::parse($latestOtIn->log_in)->isSameDay($dateTime)) {

                    // OT Out
                    // Update the entry
                    $latestOtIn->login_type = 8;
                    $latestOtIn->log_out = $formattedDateTime;
                    $latestOtIn->save();

                    // Attendance Records Footprint
                    $afCheckIfTheresTimeIn = Attendance::where('user_id', $user_id)
                        ->where('login_type', 7)
                        ->whereNotNull('log_in')
                        ->whereNull('log_out')
                        ->latest('log_in')
                        ->first();

                    // Update to time out entry
                    if ($afCheckIfTheresTimeIn) {
                        $afCheckIfTheresTimeIn->login_type = 8;
                        $afCheckIfTheresTimeIn->log_out = $formattedDateTime;
                        $afCheckIfTheresTimeIn->save();
                    }

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
                        $timeEntry->login_type = 2;
                        $timeEntry->log_out = $formattedDateTime;
                        $timeEntry->save();

                        // Check if there are existing data within a day
                        $afCheckIfTheresTimeIn = Attendance::where('user_id', $user_id)
                            ->whereNull('log_out')
                            ->orderBy('log_in', 'desc')
                            ->first();

                        // Update to time out entry
                        if ($afCheckIfTheresTimeIn) {
                            $afCheckIfTheresTimeIn->login_type = 2;
                            $afCheckIfTheresTimeIn->log_out = $formattedDateTime;
                            $afCheckIfTheresTimeIn->save();
                        }

                        return response()->json(['success' => true, 'responseData' => 'Success on updating the time out entry.']);
                    } else {
                        return response()->json(['success' => false, 'responseData' => 'Already timed out.']);
                    }
                }
                break;
                // Break Out
            case 3:

                // Check if the user is already on a break and hasn't returned (Break In) yet
                $ifAlreadyBreakOut = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 3) // Add this line to check for Break Out entry
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest('log_in')
                    ->first();

                // If the user is already timed in, return an error message
                if ($ifAlreadyBreakOut) {
                    return response()->json(['error' => true, 'responseData' => 'Already Break Out!']);
                }

                // Create a new record (Break Out)
                Dashboard::create([
                    'user_id' => $user_id,
                    'login_type' => 3,
                    'log_in' => $formattedDateTime,
                ]);

                // Create also record on attendance_records_footprint
                Attendance::create([
                    'user_id' => $user_id,
                    'login_type' => 3,
                    'log_in' => $formattedDateTime,
                ]);

                // Create also record on attendance_records_footprint
                // Attendance::create([
                //     'user_id' => $user_id,
                //     'login_type' => 3,
                //     'log_in' => $formattedDateTime,
                // ]);

                return response()->json(['success' => true, 'responseData' => 'Success on inserting the break out entry.']);
                break;

                // Break In
            case 4:

                // If you are already break out, you cannot break out again.
                $ifAlreadyBreakIn = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 4)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest()
                    ->first();

                // If the user is already timed out, return an error message
                if ($ifAlreadyBreakIn) {
                    return response()->json(['error' => true, 'responseData' => 'Already Break In!']);
                }

                // Find the latest entry for the user that doesn't have a break_in yet
                $timeEntry = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 3)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->orderBy('log_in', 'desc')
                    ->first();

                // If theres a result (Break In)
                if ($timeEntry) {
                    // Update the entry
                    $timeEntry->login_type = 4;
                    $timeEntry->log_out = $formattedDateTime;
                    $timeEntry->save();

                    // Check if there are existing data within a day
                    $afCheckIfTheresBreakIn = Attendance::where('user_id', $user_id)
                        ->where('login_type', 3)
                        ->whereNotNull('log_in')
                        ->whereNull('log_out')
                        ->orderBy('log_in', 'desc')
                        ->first();

                    // Update to time out entry
                    if ($afCheckIfTheresBreakIn) {
                        $afCheckIfTheresBreakIn->login_type = 4;
                        $afCheckIfTheresBreakIn->log_out = $formattedDateTime;
                        $afCheckIfTheresBreakIn->save();
                    }
                    return response()->json(['success' => true, 'responseData' => 'Success on updating the break in entry.']);
                } else {
                    return response()->json(['success' => false, 'responseData' => 'Already break in.']);
                }
                break;

                // Aux In
            case 5:
                // Create a new record (Aux In)
                Dashboard::create([
                    'user_id' => $user_id,
                    'login_type' => 5,
                    'log_in' => $formattedDateTime,
                    'aux_duration' => $inputData['auxDuration'], // Save the aux duration
                ]);

                // Create also record on attendance_records_footprint
                Attendance::create([
                    'user_id' => $user_id,
                    'login_type' => 5,
                    'log_in' => $formattedDateTime,
                ]);

                return response()->json(['success' => true, 'responseData' => 'Success on inserting the aux in entry.']);
                break;
                // Aux Out
            case 6:
                // Find the latest entry for the user that doesn't have an aux out yet
                $timeEntry = Dashboard::where('user_id', $user_id)
                    ->where('login_type', 5)
                    ->whereNotNull('log_in')
                    ->whereNull('log_out')
                    ->latest('log_in')
                    ->first();

                // If there's a result (Aux Out)
                if ($timeEntry) {
                    // Update the entry
                    $timeEntry->login_type = 6;
                    $timeEntry->log_out = $formattedDateTime;
                    // $timeEntry->aux_duration = $inputData['auxDuration'];
                    $timeEntry->update();

                    // Check if there are existing data within a day
                    $afCheckIfTheresAuxIn = Attendance::where('user_id', $user_id)
                        ->where('login_type', 5)
                        ->whereNotNull('log_in')
                        ->whereNull('log_out')
                        ->orderBy('log_in', 'desc')
                        ->first();

                    // Update to time out entry
                    if ($afCheckIfTheresAuxIn) {
                        $afCheckIfTheresAuxIn->login_type = 6;
                        $afCheckIfTheresAuxIn->log_out = $formattedDateTime;
                        $afCheckIfTheresAuxIn->save();
                    }
                    return response()->json(['success' => true, 'responseData' => 'Success on updating the aux out entry.']);
                } else {
                    return response()->json(['success' => false, 'responseData' => 'error on updating the aux out entry.']);
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

    // public function getAuxDuration(Request $request)
    // {
    //     $user_id = auth()->user()->id;

    //     $auxIn = Dashboard::where('user_id', $user_id)
    //         ->where('login_type', 5)
    //         ->latest('log_in')
    //         ->first();

    //     $auxOut = Dashboard::where('user_id', $user_id)
    //         ->where('login_type', 6)
    //         ->latest('log_out')
    //         ->first();

    //     if ($auxIn && $auxOut) {
    //         $auxInTime = new Carbon($auxIn->log_in);
    //         $auxOutTime = new Carbon($auxOut->log_out);
    //         $duration = $auxOutTime->diffInMinutes($auxInTime);
    //         return response()->json(['auxDuration' => $duration]);
    //     } else {
    //         return response()->json(['auxDuration' => 0]);
    //     }
    // }

    public function dashBoardReport()
    {
        $policyDetail = new PolicyDetail();
        $boundInformation = new BoundInformation();
        $quotationProduct = new QuotationProduct();
        $totalSales = $boundInformation->getTotalSales();
        $salesPercentage = $boundInformation->salesPercentageFromPreviousMonth();
        $totalAppointedProduct = $quotationProduct->getAppointedProduct();
        $appointedProductPercentage = $quotationProduct->appointedProductPercentageFromPreviousMonth();
        $totalSalesPerType = $boundInformation->getTotalSalesPartionByType();
        $totalSalesPerType = $boundInformation->getTotalSalesPartionByType();
        return view('admin.dashboard.daily-reports', compact('totalSales', 'salesPercentage', 'totalAppointedProduct', 'appointedProductPercentage', 'totalSalesPerType'));
    }


}
