<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function  index()
    {
        $positions = Position::all();
        $departments = Department::all();
        $accounts = User::all();
        return view('admin.user-profile.index', compact('positions', 'departments', 'accounts'));
    }
}
