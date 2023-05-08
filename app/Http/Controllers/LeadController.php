<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\LeadsImport;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::get();

        // dd($leads);

        if ($request->ajax()) {
            $data = Lead::select(
                'id',
                'company_name',
                'tel_num',
                'state_abbr',
                'website_originated',
                'disposition_name',
                'created_at',
                'updated_at'
            )->get();
            $data->map(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d');
                return $item;
            });
            return DataTables::of($data)->make(true);
        }
        return view('leads.generate_leads.index', compact('leads'));
        // return response()->json(['success' => true, 'responseData' => 'Success on inserting the OT in entry.']);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new LeadsImport, request()->file('file'));
        return back();
        // dd(request()->file('file'));
    }
}
