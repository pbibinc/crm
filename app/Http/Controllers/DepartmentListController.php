<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class DepartmentListController extends Controller
{
    //
    public function getAdminEmployeeList()
    {
        $userProfiles = UserProfile::where('department_id', 1)->get();
        return view('admin.department.admin.index', compact('userProfiles'));
    }

    public function getCsrEmployeeList()
    {
        $userProfiles = UserProfile::where('department_id', 2)->get();
        return view('admin.department.customer-service.index', compact('userProfiles'));
    }

    public function getSalesDepartment()
    {
        $userProfiles = UserProfile::where('department_id', 5)->get();
        return view('admin.department.sales.index', compact('userProfiles'));
    }

    public function getquoatationDepartment()
    {
        $userProfiles = UserProfile::where('department_id', 8)->get();
        return view('admin.department.sales.index', compact('userProfiles'));
    }

}