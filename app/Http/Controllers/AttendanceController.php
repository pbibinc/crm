<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AttendanceController extends Controller
{
    public function index()
    {
        // For Filtering Options
        $key = 'attendance_index';
        $expirationInSeconds = 1800;

        // Select all users
        $usersProfile = Cache::remember($key, $expirationInSeconds, function () {
            return UserProfile::select('firstname', 'lastname', 'user_id')->get();
        });

        // Login type
        $loginTypes = Cache::remember('login_types', $expirationInSeconds, function () {
            return [
                1 => "Time In",
                2 => "Time Out",
                3 => "Break Out",
                4 => "Break In",
                5 => "Aux In",
                6 => "Aux Out",
                7 => "OT In",
                8 => "OT Out"
            ];
        });

        // Carbon parse current date
        // $filterDateDefaultValue = Carbon::now()->format('Y-m-d');
        $filterDateDefaultValue = Cache::remember('filter_date_default_value', $expirationInSeconds, function () {
            return Carbon::now()->format('Y-m-d');
        });
        // End Filtering Options

        // Initialize the array to store updated records
        $footPrintsArray = [];

        // Get records from the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get all records on attendance records table
        $attendanceFootprintsDisplay = Attendance::select('attendance_records_footprints.user_id', 'login_type', 'log_in', 'log_out', 'attendance_records_footprints.created_at', 'firstname', 'lastname')
            ->join('user_profiles', 'attendance_records_footprints.user_id', '=', 'user_profiles.user_id')
            ->whereMonth('attendance_records_footprints.created_at', $currentMonth) // Filtering by month
            ->whereYear('attendance_records_footprints.created_at', $currentYear) // Filtering by year
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach($attendanceFootprintsDisplay as $footprintRecords) {

            $logIn = Carbon::parse($footprintRecords->log_in)->format('g:i:s A');
            $logOut = Carbon::parse($footprintRecords->log_out)->format('g:i:s A');
            $createdAt = Carbon::parse($footprintRecords->created_at)->format('F j, Y');

            $footprintRecords->formatted_login = $logIn;
            $footprintRecords->formatted_logout = $logOut;
            $footprintRecords->formatted_created_at = $createdAt;
            $footprintRecords->formatted_fullname = $footprintRecords->firstname . ' ' . $footprintRecords->lastname;

            switch($footprintRecords->login_type) {
                case 1: // Time In
                    $footprintRecords->formatted_logintype = "Time In";
                    break;

                case 2: // Time Out
                    $footprintRecords->formatted_logintype = "Time Out";
                    break;

                case 3: // Break Out
                    $footprintRecords->formatted_logintype = "Break Out";
                    break;

                case 4: // Break In
                    $footprintRecords->formatted_logintype = "Break In";
                    break;

                case 5: // Aux In
                    $footprintRecords->formatted_logintype = "Aux In";
                    break;

                case 6: // Aux Out
                    $footprintRecords->formatted_logintype = "Aux Out";
                    break;

                case 7: // OT In
                    $footprintRecords->formatted_logintype = "OT In";
                    break;

                case 8: // OT Out
                    $footprintRecords->formatted_logintype = "OT Out";
                    break;

                default:
                    $footprintRecords->formatted_logintype = "";
                    break;
            }



            // Add the record to the updated records array
            $footPrintsArray[] = $footprintRecords;
        }

        return view('hr.other-forms.attendance-records.index', [
            'users' => $usersProfile, 
            'loginTypes' => $loginTypes, 
            'filterDateDefaultValue' => $filterDateDefaultValue,
            'attendanceFootprintsDisplay' => $footPrintsArray,
        ]);
    }

    public function selectByFilter(Request $request) {

        $datas = $request->all();

        // Start a query on the Attendance model
        $query = Attendance::join('user_profiles', 'attendance_records_footprints.user_id', '=', 'user_profiles.user_id')
                ->select('attendance_records_footprints.*', 'user_profiles.firstname', 'user_profiles.lastname');

        $columnMap = [
            'userFilter' => 'user_id',
            'loginFilter' => 'login_type',
            'filterDate' => 'created_at',
            // Add more mappings as needed
        ];

        // Loop through each incoming data and add where clauses as needed
        foreach ($datas as $key => $value) {
            if (!empty($value) && $value !== "0" && !empty($key)) {  // check if filter is not empty and not "0"
                // Check if there is a mapping for this key, if not use the key as is
                $column = isset($columnMap[$key]) ? $columnMap[$key] : $key;
                if ($column === 'created_at') {
                    // Log the value to debug
                    // Log::info('Date string: ' . $value);
                    try {
                        $created_at = Carbon::createFromFormat('Y-m-d', $value);
                        $query->whereDate('attendance_records_footprints.' . $column, $created_at->format('Y-m-d'));
                    } catch (\Exception $e) {
                        Log::error('Date parsing error: ' . $e->getMessage());
                    }

                } else {
                    $query->where('attendance_records_footprints.' . $column, $value);
                }
            }
        }

        // Execute the query
        $results = $query->get();

        $formattedResults = $results->map(function ($result) {
            $result->formatted_login = $result->log_in ? Carbon::parse($result->log_in)->format('g:i:s A') : null;
            $result->formatted_logout = $result->log_out ? Carbon::parse($result->log_out)->format('g:i:s A') : null;
            $result->formatted_created_at = $result->created_at ? Carbon::parse($result->created_at)->format('F j, Y') : null;
            $result->formatted_fullname = $result->firstname . ' ' . $result->lastname;
    
            switch ($result->login_type) {
                case 1: // Time In
                    $result->formatted_logintype = "Time In";
                    break;
                case 2: // Time Out
                    $result->formatted_logintype = "Time Out";
                    break;
                case 3: // Break Out
                    $result->formatted_logintype = "Break Out";
                    break;
                case 4: // Break In
                    $result->formatted_logintype = "Break In";
                    break;
                case 5: // Aux In
                    $result->formatted_logintype = "Aux In";
                    break;
                case 6: // Aux Out
                    $result->formatted_logintype = "Aux Out";
                    break;
                case 7: // OT In
                    $result->formatted_logintype = "OT In";
                    break;
                case 8: // OT Out
                    $result->formatted_logintype = "OT Out";
                    break;
                default:
                    $result->formatted_logintype = "";
                    break;
            }
    
            return $result;
        });

        // Check if there are no results
        if ($formattedResults->isEmpty()) {
            return response()->json(['message' => 'No record found']);
        }

        return response()->json(['results' => $formattedResults, 'count' => $formattedResults->count()]);
    }
}
