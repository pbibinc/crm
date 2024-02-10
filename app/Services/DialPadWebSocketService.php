<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Ratchet\Client\WebSocket;
use Ratchet\Client\connect;

class DialpadWebSocketService
{
    public function connectToWebSocket()
    {
        // Your WebSocket connection code here

        $url = "wss://platform-websockets-6kqb5ajsla-uc.a.run.app/events/eyJhbGciOiJFUzI1NiIsInR5cCI6InZuZC5kaWFscGFkLndlYnNvY2tldCtqd3QifQ.eyJpc3MiOiJodHRwczovL2RpYWxwYWQuY29tIiwic3ViIjoiZW5kcG9pbnQ6NTA3MTY3ODE5MTk3NjQ0ODpjYWxsOjY0OTE2MzM1NzE2MTA2MjQiLCJpYXQiOjE3MDU3MDEyMzIsImV4cCI6MTcwNTcwNDgzMn0.3d7WJTABqn6vtd2bmwhyAqA5Giu725UnebSkFXn5aaCM-TM1OhQmE-AllLOX9U62PWw5HW26k9L7m-m9Xtz1ug";
        connect($url)->then(function (Websocket $conn) {
            $conn->on('message', function ($msg) use ($conn) {
                Log::info("Received: {$msg}\n");
                $conn->close();
            });

            $conn->send('Hello World!');
        }, function ($e) {
            Log::info("Could not connect: {$e->getMessage()}\n");
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}