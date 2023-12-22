<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $website = Website::all();
        if($request->ajax()){
            return DataTables::of($website)
            ->addColumn('action_button', function ($website){
                $editButton = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$website->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
                $deleteButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm btnDelete" data-id="'.$website->id.'" name="delete"  type="button " ><i class="mdi mdi-trash-can-outline"></i></button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->addColumn('created_at_formatted', function ($website){
                return date('M d, Y', strtotime($website->created_at));
            })
            ->addColumn('updated_at_formatted', function ($website){
                return date('M d, Y', strtotime($website->updated_at));
            })
            ->rawColumns(['action_button', 'created_at_formatted', 'updated_at_formatted'])
            ->toJson();
        }
        return view('leads.website.index', compact('website'));

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
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $website = new Website();
        $website->name = $data['name'];
        $website->save();
        return response()->json(['success' => 'Website has been added successfully.']);
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
        $website = Website::find($id);
        return response()->json(['success' => 'Website has been added successfully.', 'data' => $website]);
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
        $data = $request->all();
        $website = Website::find($id);
        $website->name = $data['name'];
        $website->save();
        return response()->json(['success' => 'website has been saved'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $website = Website::find($id);
        $website->delete();
        return response()->json(['success' => 'Website has been deleted successfully.']);
    }
}