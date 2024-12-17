<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RefreshAirSlateToken extends Command
{
    protected $signature = 'airslate:refresh-token';
    protected $description = 'Refresh AirSlate Access Token';

    public function handle()
    {
        // Check if the access token is already cached
        $accessToken = Cache::get('airslate_access_token');
        $expiresAt = Cache::get('airslate_token_expires_at');

        // If the token is cached and hasn't expired, no need to refresh
        if ($accessToken && $expiresAt && $expiresAt > now()) {
            $this->info('Access token is still valid.');
            return;
        }

        // Otherwise, generate a new token
        $jwtAssertion = env('AIRSLATE_GENERATED_WEBTOKEN'); // Replace this with your JWT token logic

        // Make the request to the AirSlate OAuth endpoint
        $response = Http::asForm()->post('https://oauth.airslate.com/public/oauth/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwtAssertion,
        ]);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'];
            $expiresIn = $response->json()['expires_in']; // Time in seconds until the token expires
            $expiresAt = now()->addSeconds($expiresIn); // Calculate the exact expiration time

            // Store the token and expiration time in the cache
            Cache::put('airslate_access_token', $accessToken, $expiresAt);
            Cache::put('airslate_token_expires_at', $expiresAt, $expiresAt);
            Log::info('Current Cached JWT Access Token: ' . $accessToken);
            Log::info('Current Cached JWT Access Token Expiration: ' . $expiresIn);

            $this->info('Access token refreshed successfully.');
        } else {
            $this->error('Failed to refresh access token: ' . $response->body());
        }
    }
}
