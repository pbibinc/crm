<?php

namespace App\Http\Controllers;

use App\DataTables\PositionDataTable;
use App\Models\Position;
use App\Policies\PositionPolicy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

// use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index(PositionDataTable $dataTable, Request $request)
    {
        // $positions = Position::all();
        $this->authorize('view', Position::find(1));
        if ($request->ajax()) {
            $data = Position::select('id', 'name', 'created_at', 'updated_at')->get();
            $data->map(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
                return $item;
            });

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $position = Position::find($data->id);
                    $policy = resolve(PositionPolicy::class);
                    $editButton = '';
                    $deleteButton = '';
                    if ($policy->update(auth()->user(), $position)) {
                        $editButton = '<button class="edit btn btn-primary btn-sm" id="' . $data->id . '" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                    }
                    if ($policy->delete(auth()->user(), $position)) {
                        $deleteButton = '<button class="delete btn btn-danger btn-sm" id="' . $data->id . '" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                    }
                    return $editButton . ' ' . $deleteButton;
                })
                ->make(true);
        }
        return view('admin.position.index');
    }

    public function store(Request $request)
    {
        $positions = Position::create($request->validate([
            'name' => ['required', 'min:3'],
        ]));
    }

    public function destroy(Position $position)
    {
        $position->delete();
        // return to_route('admin.positions.index');
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Position::findOrFail($id);
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

        Position::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }
}
