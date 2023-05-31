<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Classcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StandardIndustrialClassification;
use App\Http\Requests\StandardIndustrialClasscodeRequest;

class SICController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrive Classcodes from the Classcode table
        $classcodes = Classcode::select('*')->get();

        // If Request incoming is from AJAX
        if ($request->ajax()) {
            $data = StandardIndustrialClassification::withData()->get();

            $data->map(function ($item) {
                $item->sic_classcode =
                    $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
                return $item;
            });

            // Return DT
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button class="edit btn btn-primary btn-sm m-2" id="' . $data->id . '" name="edit" type="button"><i class="ri-edit-box-line"></i></button>';
                    $button .= '<button class="delete btn btn-danger btn-sm m-2" id="' . $data->id . '" name="delete" type="button"><i class="ri-delete-bin-line"></i></button>';
                    return $button;
                })
                ->make(true);
        }

        // Data Passed on Model
        return view('leads.sic.index', ['results' => StandardIndustrialClassification::all(), 'classcodes' => $classcodes]);
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
    public function store(StandardIndustrialClasscodeRequest $request)
    {
        // Get the validated data
        $validatedData = $request->validated();

        // Use the validated data to create a new record in the database
        StandardIndustrialClassification::create([
            'sic_classcode' => $validatedData['sic_classcode'],
            'sic_code' => $validatedData['sic_code'],
            'workers_comp_code' => $validatedData['workers_comp_code'],
            'description' => $validatedData['description'],
        ]);

        // Redirect the user or return a response
        return response()->json(['success' => true]);
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
        if (request()->ajax()) {
            $data = StandardIndustrialClassification::findOrFail($id);
            return response()->json(['result' => $data]);
        }
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
    public function destroy(StandardIndustrialClassification $sic)
    {
        $sic->delete();
    }
}
