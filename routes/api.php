<?php

use App\Http\Controllers\API\LeadDetailController;
use App\Http\Controllers\LeadController;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('leads', [LeadDetailController::class, 'index'])->withoutMiddleware(['auth:sanctum']);
Route::get('leads/lead-details', [LeadDetailController::class, 'show'])->withoutMiddleware(['auth:sanctum']);
Route::get('leads/lead-details/lead-address', [LeadDetailController::class, 'leadAddress'])->withoutMiddleware(['auth:sanctum']);