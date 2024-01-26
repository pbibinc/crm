<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DialpadWebSocketService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    //

    public function getCompany()
    {
        //Create Client object to deal with
        $client = new Client();

        //definition the request parameter
        $response = $client->request('GET', 'https://dialpad.com/api/v2/company?apikey=g2t6CUrE5qMcqMQjzBADEA268uA7ektrWvyuMexdUUdJbb4wtwcEfJbtDEvsWAtaVyb24kKzLheJv86AZCVCGFgYUP7AjdAwT3jH', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
          $jsonData = json_decode($response->getBody()->getContents(), true);

          return response()->json([
            'data' => $jsonData,
            'message' => 'Inbound request received'
        ]);
    }
    public function getUserList()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://dialpad.com/api/v2/users?email=maechael%40pbibinc.com&apikey=g2t6CUrE5qMcqMQjzBADEA268uA7ektrWvyuMexdUUdJbb4wtwcEfJbtDEvsWAtaVyb24kKzLheJv86AZCVCGFgYUP7AjdAwT3jH', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
          $jsonData = json_decode($response->getBody()->getContents(), true);

          return response()->json([
            'data' => $jsonData,
            'message' => 'Inbound request received'
          ]);
    }

    public function mainLineCustomerService(Request $request)
    {
        // return response()->json([
        //     'data' => $request->all(),
        //     'message' => 'Inbound request received'
        // ]);
        $client = DialpadWebSocketService::connectToWebSocket();

    }
}
