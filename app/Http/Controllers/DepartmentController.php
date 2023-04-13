<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Department;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
      
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
                $button = '<button class="edit btn btn-primary btn-sm" id="'.$data->id.'" name="edit"  type="button"><i class="ri-edit-box-line"></i></button>';
                $button .= '<button class="delete btn btn-danger btn-sm" id="'.$data->id.'" name="delete"  type="button"><i class="ri-delete-bin-line"></i></button>';
                return $button;
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
}
