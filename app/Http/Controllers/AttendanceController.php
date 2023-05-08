<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;

class AttendanceController extends Controller
{
    public function showAttendanceRecords()
    {
        $data = Dashboard::select();
        return view('hr.other-forms.attendance-records.index');
    }
}
