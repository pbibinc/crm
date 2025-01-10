<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BuildersRiskController;
use App\Http\Controllers\API\BusinessOwnersPolicyController;
use App\Http\Controllers\API\ClassCodeDataController;
use App\Http\Controllers\API\CommercialAutoController;
use App\Http\Controllers\API\CreateCertificateController;
use App\Http\Controllers\API\CustomerServiceController;
use App\Http\Controllers\API\ExcessLiabilityController;
use App\Http\Controllers\API\GeneralInformationData;
use App\Http\Controllers\API\GeneralInformationDataController;
use App\Http\Controllers\API\LeadDetailController;
use App\Http\Controllers\API\RecreationalController;
use App\Http\Controllers\API\StateAddressController;
use App\Http\Controllers\API\GeneralLiabilitiesDataController;
use App\Http\Controllers\API\PdfController;
use App\Http\Controllers\API\PoliciesController as APIPoliciesController;
use App\Http\Controllers\API\PoliciesDataController;
use App\Http\Controllers\API\QuoteFormController;
use App\Http\Controllers\API\ToolsEquipmentController;
use App\Http\Controllers\API\WorkersCompDataController;
use App\Http\Controllers\AppTakerLeadsController;
use App\Http\Controllers\CallBackController;
use App\Http\Controllers\InsuranceSurveyInfoController;
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
Route::post('/store-lead-data', [LeadDetailController::class, 'storeLeadData'])->withoutMiddleware(['auth:sanctum']);
Route::post('/lead-db-rolback', [LeadDetailController::class, 'rollback'])->withoutMiddleware(['auth:sanctum']);


Route::get('classcode/data', [ClassCodeDataController::class, 'index'])->withoutMiddleware(['auth:sanctum']);
Route::get('states', [StateAddressController::class, 'states'])->withoutMiddleware(['auth:sanctum']);
Route::get('recreational', [RecreationalController::class, 'recreationalFactilies'])->withoutMiddleware(['auth:sanctum']);

Route::post('general-information-data', [GeneralInformationDataController::class, 'getGeneralInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::get('general_information', [GeneralInformationDataController::class, 'generalInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::put('general-information-data/{id}', [GeneralInformationDataController::class, 'updateGenneralInformationData'])->withoutMiddleware(['auth:sanctum']);
Route::get('general-information-data/edit/{id}', [GeneralInformationDataController::class, 'edit'])->withoutMiddleware(['auth:sanctum']);
Route::post('update-contact-information', [GeneralInformationDataController::class, 'updateContactInformation'])->withoutMiddleware(['auth:sanctum']);
Route::post('/store-general-information-data', [GeneralInformationDataController::class, 'storeGeneralInformationData'])->withoutMiddleware(['auth:sanctum']);

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

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/lead-data/{userId}', [LeadDetailController::class, 'getLeadDataUserId'])->name('get-lead-data-user-id');
    Route::post('/get-policy-information/{policyId}', [PoliciesDataController::class, 'getPolicyInformation'])->name('get-policy-information');
    Route::post('/generate-cert-pdf', [CreateCertificateController::class, 'generateCertPdf'])->name('generate-cert-pdf');
});


// Get a quote form API
Route::post('store-quoteform-data', [QuoteFormController::class, 'storeData'])->withoutMiddleware(['auth:sanctum']);
Route::post('/store-quote-info', [QuoteFormController::class, 'storeQuoteInfo'])->withoutMiddleware(['auth:sanctum']);

// Insurance needs survey form API
Route::post('store-insurance-needs-survey-form-data', [InsuranceSurveyInfoController::class, 'store'])->withoutMiddleware(['auth:sanctum']);

// Airslate Pdf API
Route::post('pdf-connect-to-storage', [PdfController::class, 'connectToStorage'])->withoutMiddleware(['auth:sanctum']);
Route::post('pdf-create-new-storage', [PdfController::class, 'createStorage'])->withoutMiddleware(['auth:sanctum']);
Route::get('pdf-storage-list', [PdfController::class, 'getListOfStorages'])->withoutMiddleware(['auth:sanctum']);
Route::get('pdf-get-storage-providers', [PdfController::class, 'listOfStorageProviders'])->withoutMiddleware(['auth:sanctum']);
Route::get('pdf-get-document-lists', [PdfController::class, 'getDocumentLists'])->name('get-document-lists')->withoutMiddleware(['auth:sanctum']);
Route::post('pdf-upload-document-to-storage', [PdfController::class, 'uploadDocumentToStorage'])->name('upload-pdf-document')->withoutMiddleware(['auth:sanctum']);
Route::post('pdf-create-document-link', [PdfController::class, 'createDocumentLink'])->name('create-pdf-link')->withoutMiddleware(['auth:sanctum']);
Route::post('pdf-webhook-callback-uri', [PdfController::class, 'handleWebhook'])->withoutMiddleware(['auth:sanctum']);
Route::get('pdf-document-redirection-uri', [PdfController::class, 'handleRedirect'])->withoutMiddleware(['auth:sanctum']);
Route::post('ocr-pdf', [PdfController::class, 'extractDataFromPdf'])->withoutMiddleware(['auth:sanctum']);
