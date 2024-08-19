<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\BuildersRiskController;
use App\Http\Controllers\API\BusinessOwnersPolicyController;
use App\Http\Controllers\API\ClassCodeDataController;
use App\Http\Controllers\API\CommercialAutoController;
use App\Http\Controllers\API\CustomerServiceController;
use App\Http\Controllers\API\ExcessLiabilityController;
use App\Http\Controllers\API\GeneralInformationData;
use App\Http\Controllers\API\GeneralInformationDataController;
use App\Http\Controllers\API\LeadDetailController;
use App\Http\Controllers\API\RecreationalController;
use App\Http\Controllers\API\StateAddressController;
use App\Http\Controllers\API\GeneralLiabilitiesDataController;
use App\Http\Controllers\API\PoliciesController as APIPoliciesController;
use App\Http\Controllers\API\PoliciesDataController;
use App\Http\Controllers\API\ToolsEquipmentController;
use App\Http\Controllers\API\WorkersCompDataController;
use App\Http\Controllers\AppTakerLeadsController;
use App\Http\Controllers\CallBackController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PoliciesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Models\Callback;
use App\Models\GeneralLiabilities;
use App\Models\Lead;
use App\Models\PolicyDetail;
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
Route::get('get/lead-instance-by-id/{id}', [LeadDetailController::class, 'getLeadInstanceById'])->withoutMiddleware(['auth:sanctum']);
Route::get('get-appointed-sales-per-person', [LeadDetailController::class, 'getAppointedSalesPerPerson'])->withoutMiddleware(['auth:sanctum']);


Route::get('classcode/data', [ClassCodeDataController::class, 'index'])->withoutMiddleware(['auth:sanctum']);
Route::get('states', [StateAddressController::class, 'states'])->withoutMiddleware(['auth:sanctum']);
Route::get('recreational', [RecreationalController::class, 'recreationalFactilies'])->withoutMiddleware(['auth:sanctum']);


Route::post('general-information-data', [GeneralInformationDataController::class, 'getGeneralInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::get('general_information', [GeneralInformationDataController::class, 'generalInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::put('general-information-data/{id}', [GeneralInformationDataController::class, 'updateGenneralInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::get('general-information-data/edit/{id}', [GeneralInformationDataController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);

//route for general liabilities
Route::post('general-liabilities-data', [GeneralLiabilitiesDataController::class, 'saveGeneralLiabilities'])->withoutMiddleware(['auth:sanctum']);
Route::put('general-liabilities-data/{id}', [GeneralLiabilitiesDataController::class, 'updateGeneralLiabilities'])->withoutMiddleware(['auth:sanctum']);
Route::get('general-liabilities-data/edit/{id}', [GeneralLiabilitiesDataController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('general-liabilities-data/get/previousGeneralLiabilities/{id}', [GeneralLiabilitiesDataController::class, 'getPreviousGeneralLiabilities'])->withoutMiddleware(['auth:sanctum']);

//route for workers compensation
Route::post('workers-comp-data/store', [WorkersCompDataController::class, 'saveWorkersComp'])->withoutMiddleware(['auth:sanctum']);
Route::put('workers-comp-data/{id}', [WorkersCompDataController::class, 'updateWorkersComp'])->withoutMiddleware(['auth:sanctum']);
Route::get('workers-comp-data/get/{id}', [WorkersCompDataController::class, 'getWorkersCompData'])->withoutMiddleware(['auth:sanctum']);
Route::get('workers-comp-data/edit/{id}', [WorkersCompDataController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('workers-comp-data/get/previousWorkersComp/{id}', [WorkersCompDataController::class, 'getPreviousWorkersCompensationoInformation'])->withoutMiddleware(['auth:sanctum']);

//route for commercial auto
Route::post('commercial-auto-data/store', [CommercialAutoController::class, 'saveCommercialAuto'])->withoutMiddleware(['auth:sanctum']);
Route::put('commercial-auto-data/update/{id}', [CommercialAutoController::class, 'updateCommercialAuto'])->withoutMiddleware(['auth:sanctum']);
Route::get('commercial-auto-data/edit/{id}', [CommercialAutoController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('commercial-auto-data/get/previousCommercialAutoInformation/{id}', [CommercialAutoController::class, 'getPreviousCommercialAutoInformation'])->withoutMiddleware(['auth:sanctum']);

//route for excess liability
Route::post('excess-liability-data/store', [ExcessLiabilityController::class, 'saveExcessLiability'])->withoutMiddleware(['auth:sanctum']);
Route::put('excess-liability-data/update/{id}', [ExcessLiabilityController::class, 'updateExcessLiability'])->withoutMiddleware(['auth:sanctum']);
Route::get('excess-liability-data/edit/{id}', [ExcessLiabilityController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('excess-liability-data/get/previousExcessLiabilityInformation/{id}', [ExcessLiabilityController::class, 'getPrviousExcessLiabilityInformation'])->withoutMiddleware(['auth:sanctum']);

//route for tools equipment
Route::post('tools-equipment/store', [ToolsEquipmentController::class, 'storeToolsEquipment'])->withoutMiddleware(['auth:sanctum']);
Route::put('tools-equipment/update/{id}', [ToolsEquipmentController::class, 'updateToolsEquipment'])->withoutMiddleware(['auth:sanctum']);
Route::get('tools-equipment-data/edit/{id}', [ToolsEquipmentController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('tools-equipment-data/get/previousToolsEquipmentInformation/{id}', [ToolsEquipmentController::class, 'getPreviousToolsEquipmentInformation'])->withoutMiddleware(['auth:sanctum']);

//route for builders risk
Route::post('builders-risk/store', [BuildersRiskController::class, 'storedBuildersRisk'])->withoutMiddleware(['auth:sanctum']);
Route::put('builders-risk/update/{id}', [BuildersRiskController::class, 'updateBuildersRisk'])->withoutMiddleware(['auth:sanctum']);
Route::get('builders-risk/edit/{id}', [BuildersRiskController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('builders-risk/get/previousBuildersRiskInformation/{id}', [BuildersRiskController::class, 'getPreviousBuildersRiskInformation'])->withoutMiddleware(['auth:sanctum']);

//route for business owners policy
Route::post('business-owners-policy/store', [BusinessOwnersPolicyController::class, 'storeBusinessOwnersPolicy'])->withoutMiddleware(['auth:sanctum']);
Route::put('business-owners-policy/update/{id}', [BusinessOwnersPolicyController::class, 'updateBusinessOwnersPolicy'])->withoutMiddleware(['auth:sanctum']);
Route::get('business-owners-policy/edit/{id}', [BusinessOwnersPolicyController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::get('business-owners-policy/get/previousBusinessOwnersPolicyInformation/{id}', [BusinessOwnersPolicyController::class, 'getPreviousBusinessOwnersPolicyInformation'])->withoutMiddleware(['auth:sanctum']);

//route for callback
Route::post('callback/store', [CallBackController::class, 'store'])->withoutMiddleware(['auth:sanctum']);

//route for application taker leads
Route::post('reload-data', [AppTakerLeadsController::class, 'reloadData'])->middleware(['auth:sanctum']);

Route::post('/generate-auth-token', [ApiAuthController::class, 'generateAuthToken'])->withoutMiddleware(['auth:sanctum']);

Route::get('get-user', [UserController::class, 'getUser'])->withoutMiddleware(['auth:sanctum']);

Route::get('get-policy-detail-instance/{id}', [PoliciesDataController::class, 'getPolicyDetailInstance'])->withoutMiddleware(['auth:sanctum']);

Route::get('get-sample-data', [PoliciesDataController::class, 'getSampleData'])->withoutMiddleware(['auth:sanctum']);
//route for dialpad

Route::get('get-company', [CustomerServiceController::class, 'getCompany'])->withoutMiddleware(['auth:sanctum']);
Route::get('get-user-list', [CustomerServiceController::class, 'getUserList'])->withoutMiddleware(['auth:sanctum']);
Route::post('main-line-customer-service', [CustomerServiceController::class, 'mainLineCustomerService'])->withoutMiddleware(['auth:sanctum']);