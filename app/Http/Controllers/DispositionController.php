<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Disposition;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DispositionController extends Controller
{
    public function index(Request $request)
    {
        // If Request incoming is from AJAX
        if ($request->ajax()) {
            $data = Disposition::select('id', 'name', 'created_at', 'updated_at')->get();
            $data->map(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
                return $item;
            });

            // Return DT
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button class="edit btn btn-primary btn-sm m-2" id="' . $data->id . '" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                    $button .= '<button class="delete btn btn-danger btn-sm m-2" id="' . $data->id . '" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                    return $button;
                })
                ->make(true);
        }

        // Data Passed on Model
        return view('leads.disposition.index', ['results' => Disposition::all()]);
    }

    public function store(Request $request)
    {
        $positions = Disposition::create($request->validate([
            'name' => ['required', 'min:3'],
        ]));
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Disposition::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {

        $validation = array(
            'name' => 'required',
        );

        $error = Validator::make($request->all(), $validation);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'name' => $request->name
        );

        Disposition::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy(Disposition $disposition)
    {
        $disposition->delete();
        // return to_route('admin.positions.index');
    }
}
