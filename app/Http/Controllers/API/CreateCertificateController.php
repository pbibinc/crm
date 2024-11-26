<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

class CreateCertificateController extends BaseController
{
    //

    public function generateCertPdf(Request $request)
    {
        $data = $request->all();
        return response()->json($data);
    }
}
