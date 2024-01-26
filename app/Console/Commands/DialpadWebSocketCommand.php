<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use Amp\Websocket\Client;
use Amp\Loop;
use App\Events\CallRinging;
use App\Models\Lead;

use function Ratchet\Client\connect;

class DialpadWebSocketCommand extends Command
{
    protected $signature = 'websocket:client';
    protected $description = 'Connect to an external WebSocket server';

    public function handle()
    {
        $url = "wss://platform-websockets-6kqb5ajsla-uc.a.run.app/events/eyJhbGciOiJFUzI1NiIsInR5cCI6InZuZC5kaWFscGFkLndlYnNvY2tldCtqd3QifQ.eyJpc3MiOiJodHRwczovL2RpYWxwYWQuY29tIiwic3ViIjoiZW5kcG9pbnQ6NTA3MTY3ODE5MTk3NjQ0ODpjYWxsOjY0OTE2MzM1NzE2MTA2MjQiLCJpYXQiOjE3MDU5NDgyMjEsImV4cCI6MTcwNTk1MTgyMX0.4VwJtwYv2b7EeNA95Sf6JkD9bkRPgEzw9nCfZv9ANwhss1z985m2oJahZG-P48ZjF5-8eiLD4xIfgOPJY8U8GA"; // Replace with your WebSocket URL
        $this->info('Connecting to WebSocket server...');

        connect($url)->then(function($conn) {
            $this->info('Connected to WebSocket server.');
            $conn->on('message', function($msg) use ($conn) {
            //    $this->info("Received: {$msg}");
               $data = json_decode($msg, true);
               if (is_array($data) && isset($data['external_number'])) {
                $externalNumber = $data['external_number'];
                $state = $data['state'];
                $this->info("External Number: {$externalNumber}");
                $this->info("State: {$state}");
                $leadId = Lead::where('tel_num', $externalNumber)->first()->id;
                if($leadId){
                    if($state == 'ringing'){
                       broadcast(new CallRinging($leadId));
                    }
                }
                // You can now process the external number as needed
            } else {
                $this->error("Error decoding JSON or 'external_number' not found.");
            }
            });

            $conn->on('close', function($code = null, $reason = null) {
                $this->error("Connection closed ({$code} - {$reason})");
            });

            // Keep the connection open
            $conn->send('Hello World!');
        }, function (\Exception $e) {
            $this->info('Could not connect: ' . $e->getMessage());
            $this->error("Could not connect: {$e->getMessage()}");
            if ($e->getPrevious()) {
                $this->error("Previous exception: " . $e->getPrevious()->getMessage());
            }
        });

        // Keep the command running to maintain the WebSocket connection
        // while (true) {
        //     sleep(10); // Prevent high CPU usage
        // }
    }
}
