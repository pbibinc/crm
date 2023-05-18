<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Department;
use App\Policies\DepartmentPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
      $this->authorize('view', Department::find(1));
        if($request->ajax())
        {
            $data = Department::select('id', 'name', 'created_at', 'updated_at')->get();
            $data->map(function($item){
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('Y-m-d H:i:s');
                return $item;
            });
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $department = Department::find($data->id);
                $policy = resolve(DepartmentPolicy::class);
                $editButton = '';
                $deleteButton = '';
                if($policy->update(auth()->user(), $department)){
                    $editButton = '<button class="edit btn btn-primary btn-sm" id="'.$data->id.'" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                }
                if($policy->delete(auth()->user(), $department)){
                    $deleteButton = '<button class="delete btn btn-danger btn-sm" id="'.$data->id.'" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                }
                return $editButton . ' ' . $deleteButton;
            })
            ->make(true);
        }
        return view('admin.department.index');
    }

    public function store(Request $request)
    {
        $deparments = Department::create($request->validate([
            'name' => ['required', 'min:3']
        ]));
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Department::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $validation = array(
            'name' => 'required',
        );

        $error = Validator::make($request->all(), $validation);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'name' => $request->name
        );

        Department::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        // return to_route('admin.positions.index');
    }

}
