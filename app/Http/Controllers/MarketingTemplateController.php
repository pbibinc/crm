<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Templates;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
class MarketingTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic Z3dOUWxQYW82WWl1ME5lSGhINEVlRWhmanlpOEhicElOMzdYOGd6bWNEZXA5aVE2UWdndTF1cExJbVdDdDNrejo=',
        ])->get('https://api.unlayer.com/v2/templates');
       $data = $response->json();
        return view('admin.marketing.template.index', compact('data'));
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
        try{
            DB::beginTransaction();
            $template = new Templates();
            $userId = auth()->user()->id;
            $userProfile = UserProfile::where('user_id', $userId)->first();
            $template->user_profile_id = $userProfile->id;
            $template->name = $request->input('templateName');
            $template->type = $request->input('type');
            $template->design = $request->input('design');
            $template->html = $request->input('html');
            $template->save();
            DB::commit();
            return response()->json(['message' => 'Template added successfully'], 200);
        }catch(ValidationException $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
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
        try {
            $template = Templates::findOrFail($id);
            if (!$template) {
                return response()->json(['message' => 'Template not found'], 404);
            }
            return view('admin.marketing.template.edit-template', compact('template'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
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
        try{
            DB::beginTransaction();
            $template = Templates::findOrFail($id);
            $template->name = $request->input('templateName');
            $template->type = $request->input('type');
            $template->design = $request->input('design');
            $template->html = $request->input('html');
            $template->save();
            DB::commit();
            return response()->json(['message' => 'Template updated successfully'], 200);
        }catch(ValidationException $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
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
    }

    public function getListOfTemplates(Request $request)
    {
        $templates = Templates::all();
        return DataTables($templates)
        ->addIndexColumn()
        ->addColumn('editTemplate', function($templates){
            $editBtn = '<button type="button" class="btn btn-primary btn-sm editButton" id="'.$templates->id.'"><i class="ri ri-edit-box-line"></i></button>';
            $deleteBtn = '<button class="delete btn btn-danger btn-sm" name="delete" type="button"><i class="ri-delete-bin-line"></i></button>';
            return $editBtn . ' ' . $deleteBtn;
        })
        ->addColumn('createdBy', function($templates){
            $userProfile = UserProfile::find($templates->user_profile_id);
            return $userProfile->fullAmericanName();
        })
        ->addColumn('createdDate', function($templates){
            return $templates->created_at->format('Y-m-d');
        })
        ->rawColumns(['editTemplate'])
        ->make(true);
    }

    public function addTemplate()
    {
        return view('admin.marketing.template.add-template');
    }
}
