<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ClassCodeLead;
use Illuminate\Support\Str;

class ApiAuthController extends BaseController
{
    public function generateAuthToken()
    {
        $token = Str::random(64);

        return response()->json([
            'token' => $token,
        ]);
    }

}

?>