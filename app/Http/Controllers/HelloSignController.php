<?php

namespace App\Http\Controllers;

use HelloSign\Client;
use Illuminate\Http\Request;
use HelloSign\SignatureRequest;

class HelloSignController extends Controller
{
    public function initiateSigning()
    {
        $client = new Client(env('HELLOSIGN_API_KEY'));
        $request = new SignatureRequest;
        $request->enableTestMode();

        $request->setTitle('Test Signature Request');
        $request->addSigner('jane.doe@example.com', 'Jane Doe');
        $request->addFile(public_path('hellosignsample.pdf'));

        // set up the signature request parameters
        $response = $client->sendSignatureRequest($request);
        // render the signing page with the embedded signature request


        $signature = $response->getSignatures()[0];
        $embeddedUrl = $signature->getSignUrl();

        return view('hellosign.signing', ['embeddedUrl' => $embeddedUrl]);
    }
    public function handleCallback()
    {
        $client = new HelloSign\Client(env('HELLOSIGN_API_KEY'));
        $signatureId = $_POST['signature_id'];
        $response = $client->getSignatureRequest($signatureId);
        // handle the signed document and any post-signing actions

        return view('hellosign.callback');
    }
}
