<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class DepartmentListController extends Controller
{
    //
    public function getItEmployeeList()
    {
        $userProfiles = UserProfile::where('department_id', 1)->get();
        return view('admin.department.information-tech.index', compact('userProfiles'));
    }

    public function getCsrEmployeeList()
    {
        $userProfiles = UserProfile::where('department_id', 2)->get();
        return view('admin.department.customer-service.index', compact('userProfiles'));
    }

}
