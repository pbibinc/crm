<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Insurer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InsurerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Insurer::all();
            return DataTables($data)
            ->addColumn('action_button', function($data){
                $editButton = '<button class="btn btn-outline-primary waves-effect waves-light btn-sm btnEdit" data-id="'.$data->id.'" name="edit"  type="button " ><i class="mdi mdi-pencil-outline"></i></button>';
                $deleteButton = '<button class="btn btn-outline-danger waves-effect waves-light btn-sm btnDelete" data-id="'.$data->id.'" name="delete"  type="button " ><i class="mdi mdi-trash-can-outline"></i></button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action_button'])
            ->toJson();;
        }
        return view('insurer.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $insurer = new Insurer();
        $insurer->name = $data['name'];
        $insurer->save();
        return response()->json(['success' => 'insurer has been saved'], 200);
    }

    public function edit($id)
    {
        $insurer = Insurer::find($id);
        return response()->json(['data' => $insurer], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $insurer = Insurer::find($id);
        $insurer->name = $data['name'];
        $insurer->save();
        return response()->json(['success' => 'insurer has been updated'], 200);
    }

    public function destroy($id)
    {
        $insurer = Insurer::find($id);
        $insurer->delete();
        return response()->json(['success' => 'insurer has been deleted'], 200);
    }
}
