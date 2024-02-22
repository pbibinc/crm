<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinancingCompany;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinancingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            $data = FinancingCompany::all();
            return DataTables($data)
            ->addColumn('action_button', function($data){
                $editButton = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$data->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
                $deleteButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm btnDelete" data-id="'.$data->id.'" name="delete"  type="button " ><i class="mdi mdi-trash-can-outline"></i></button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action_button'])
            ->toJson();}


        return view('customer-service.financing.financing-company.index');
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
        $data = $request->all();
        $financingCompany = new FinancingCompany();
        $financingCompany->name = $data['name'];
        $financingCompany->save();
        return response()->json(['success' => 'Financing Company has been saved'], 200);
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
        $financingCompany = FinancingCompany::find($id);
        return response()->json(['data' => $financingCompany], 200);
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
        $financingCompany = FinancingCompany::find($id);
        $financingCompany->name = $data['name'];
        $financingCompany->save();
        return response()->json(['success' => 'Financing Company has been updated'], 200);
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
        $financingCompany = FinancingCompany::find($id);
        $financingCompany->delete();
        return response()->json(['success' => 'Financing Company has been deleted'], 200);
    }
}
