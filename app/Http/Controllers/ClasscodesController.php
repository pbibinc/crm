<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasscodeFormRequest;
use Carbon\Carbon;
use App\Models\Classcode;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClasscodesController extends Controller
{
    public function index(Request $request)
    {
        // If Request incoming is from AJAX
        if ($request->ajax()) {
            $data = Classcode::select('id', 'classcode_name', 'classcode', 'classcode_descriptions', 'created_at', 'updated_at')->get();
            $data->map(function ($item) {
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
        return view('leads.classcodes.index', ['results' => Classcode::all()]);
    }

    public function store(Classcode $classcode, ClasscodeFormRequest $request)
    {
        // The request is automatically validated by ClasscodeFormRequest

        // Get the validated data
        $incomingFields = $request->validated();

        // Sanitize the data
        $incomingFields['classcode_name'] = strip_tags($incomingFields['classcode_name']);
        $incomingFields['classcode'] = strip_tags($incomingFields['classcode']);
        $incomingFields['classcode_descriptions'] = strip_tags($incomingFields['classcode_descriptions']);

        // Update the model instance
        $classcode->create($incomingFields);

        // Return a JSON response
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Classcode::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Classcode $classcode, Request $request)
    {
        $incomingFields = $request->validate([
            'classcode_name' => 'required',
            'classcode' => 'nullable',
            'classcode_descriptions' => 'nullable'
        ]);

        $incomingFields['classcode_name'] = strip_tags($incomingFields['classcode_name']);
        $incomingFields['classcode'] = strip_tags($incomingFields['classcode']);
        $incomingFields['classcode_descriptions'] = strip_tags($incomingFields['classcode_descriptions']);

        $classcode->whereId($request->hidden_id)->update($incomingFields);

        // Classcode::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy(Classcode $classcode)
    {
        $classcode->delete();
    }
}
