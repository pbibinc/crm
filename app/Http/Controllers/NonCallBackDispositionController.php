<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Disposition;
use Illuminate\Http\Request;

class NonCallBackDispositionController extends Controller
{
    //
    public function index()
    {
        $dispositions = Disposition::orderBy('name', 'asc')->get();
        return view('leads.non-callback-leads.index', compact('dispositions'));
    }
}