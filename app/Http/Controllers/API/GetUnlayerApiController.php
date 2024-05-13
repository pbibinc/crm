<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Http;

class GetUnlayerApiController extends BaseController
{
    public function getUnlayerApi()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic WEF5QXp0dmE0Og==',
        ])->get('https://api.unlayer.com/v1/templates');
        dd($response->json());
    }
}
?>
