<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyHandbook;
use Illuminate\Support\Facades\Validator;


class CompanyHandbookController extends Controller
{
    public function showCompanyHandbook()
    {
        $data = CompanyHandbook::select('description')->first();

        return view('hr.other-forms.company-handbook.index', ['result' => $data]);
    }

    public function saveOrUpdateCompanyHandbookRecord(Request $request)
    {
        $validation = array(
            'description' => 'required',
        );
        $error = Validator::make($request->all(), $validation);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'description' => $request->description,
            'user_profile_id' => auth()->user()->id
        );

        CompanyHandbook::updateOrInsert(
            ['id' => 1],
            $form_data
        );

        return response()->json(['status' => 'success']);
    }
}
