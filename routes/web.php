<?php

use Illuminate\Http\Request;
use App\Models\PricingBreakdown;
use Faker\Provider\ar_EG\Payment;
use App\Models\FinancingAgreement;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SICController;
use App\Models\CancellationEndorsement;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\CancelledPolicyForRecall;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoundController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\IntentController;
use App\Http\Controllers\QuotedController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\BindingController;
use App\Http\Controllers\InsurerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\CallBackController;
use App\Http\Controllers\PoliciesController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AppointedController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\FinancingController;
use App\Http\Controllers\HelloSignController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\AssignLeadController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClasscodesController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MarketListController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BindingDocsController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\ScrubbedDncController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\BrokerHandleController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\DashboardControllerNew;
use App\Http\Controllers\RenewalQuoteController;
use App\Http\Controllers\AppTakerLeadsController;
use App\Http\Controllers\RenewalPolicyController;
use App\Http\Controllers\RewritePolicyController;
use App\Http\Controllers\SelectedQuoteController;
use App\Http\Controllers\TecnickcomPdfController;
use App\Http\Controllers\API\LeadDetailController;
use App\Http\Controllers\AppointedProductListController;
use App\Http\Controllers\DepartmentListController;
use App\Http\Controllers\PaymentChargedController;
use App\Http\Controllers\RewriteBindingController;
use App\Http\Controllers\BrokerAssistantController;
use App\Http\Controllers\CancelledPolicyController;
use App\Http\Controllers\CompanyHandbookController;
use App\Http\Controllers\AuditInformationController;
use App\Http\Controllers\FinanceAgreementPolicyList;
use App\Http\Controllers\FinancingCompanyController;
use App\Http\Controllers\PolicyForRenewalController;
use App\Http\Controllers\PricingBreakdownController;
use App\Http\Controllers\AuditRequiredFileController;
use App\Http\Controllers\BrokerForFollowUpController;
use App\Http\Controllers\EmbeddedSignatureController;
use App\Http\Controllers\LeadTaskSchedulerController;
use App\Http\Controllers\MarketingTemplateController;
use App\Http\Controllers\WorkersCompPolicyController;
use App\Http\Controllers\CancellationReportController;
use App\Http\Controllers\GeneralInformationController;
use App\Http\Controllers\AssignAgentToBrokerController;
use App\Http\Controllers\AssignAppointedLeadController;
use App\Http\Controllers\ForRewriteQuotationController;
use App\Http\Controllers\CommercialAutoPolicyController;
use App\Http\Controllers\ToolsEquipmentPolicyController;
use App\Http\Controllers\ForRewriteMakePaymentController;
use App\Http\Controllers\AssignForRewritePolicyController;
use App\Http\Controllers\NonCallBackDispositionController;
use App\Http\Controllers\RequestForCancellationController;
use App\Http\Controllers\CancellationEndorsementController;
use App\Http\Controllers\CancelledPolicyForRecallController;
use App\Http\Controllers\QuotationProductCallbackController;
use App\Http\Controllers\AssignQuotedRenewalPolicyController;
use App\Http\Controllers\BuildersRiskPolicyDetailsController;
use App\Http\Controllers\PaymentInformationArchivedController;
use App\Http\Controllers\BussinessOwnersPolicyDetailsController;
use App\Http\Controllers\ExcessLiabilityInsurancePolicyController;
use App\Http\Controllers\CancelledPolicyForRecall as ControllersCancelledPolicyForRecall;
use App\Http\Controllers\GeneralNotificationController;

Route::get('/', function () {
    return view('welcome');
});

//
// Route::webhooks('webhook-receiving-url');


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});

 // Admin Configuration All Route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});
//end for Admin Configuration


//route for file upload
// Route::post('/upload', [UploadController::class, 'store'])->name('upload');

Route::middleware(['auth'])->group(function (){
    Route::post('/broadcasting/auth', '\Illuminate\Broadcasting\BroadcastController@authenticate');
   // Dashboard
   Route::prefix('dashboard')->group(function () {
     Route::resource('/', DashboardControllerNew::class)->except(['edit', 'update', 'delete', 'create', 'show', 'edit']);
     Route::get('/', [DashboardControllerNew::class, 'index'])->name('dashboard');
     Route::post('/store', [DashboardControllerNew::class, 'store'])->name('dashboard.store');
     Route::get('/aux-duration', [DashboardControllerNew::class, 'getAuxDuration'])->name('dashboard.getAuxDuration');
     Route::get('/table-data', [DashboardControllerNew::class, 'getTableData'])->name('dashboard.table-data');
     Route::get('/aux-history-data', [DashboardControllerNew::class, 'getAuxHistoryData'])->name('dashboard.aux-history-data');
     Route::get('/check-aux-status', [DashboardControllerNew::class, 'checkAuxLogoutStatus'])->name('dashboard.check-aux-status');

     //route for dashboard report
     Route::get('/dashboard-report', [DashboardControllerNew::class, 'dashBoardReport'])->name('dashboard-report');
    });

    //accounting module
    Route::prefix('accounting')->group(function(){
        //route for payment information
        Route::get('/accounting-payable', [PaymentController::class, 'index'])->name('accounting-payable');
        Route::post('/save-payment-information', [PaymentController::class, 'storePaymentInformation'])->name('save-payment-information');
        Route::get('/get-payment-information', [PaymentController::class, 'getPaymentInformation'])->name('get-payment-information');
        Route::post('/declined-payment', [PaymentController::class, 'declinedPayment'])->name('declined-payment');
        Route::post('/resend-payment-information', [PaymentController::class, 'resendPaymentInformation'])->name('resend-payment-information');
        Route::delete('/delete-payment-information/{id}', [PaymentController::class, 'delete'])->name('delete-payment-information');

        //route for payment charged
        Route::post('/store-payment-charged', [PaymentChargedController::class, 'store'])->name('payment-charged.store');
        Route::delete('/delete-payment-charged/{id}', [PaymentChargedController::class, 'delete'])->name('payment-charged.delete');
        Route::get('/payment-for-charged', [PaymentChargedController::class, 'index'])->name('payment-for-charged');
        Route::get('/payment-list', [PaymentChargedController::class, 'paymentList'])->name('payment-list');
        Route::post('/get-invoice-media', [PaymentChargedController::class, 'getInvoiceMedia'])->name('get-invoice-media');
        Route::post('/edit', [PaymentChargedController::class, 'edit'])->name('payment-charged.edit');
        Route::post('/update', [PaymentChargedController::class, 'update'])->name('payment-charged.update');
        Route::post('/upload-invoice', [PaymentChargedController::class, 'uploadFile'])->name('upload-invoice');
        Route::post('/delete-invoice', [PaymentChargedController::class, 'deleteInvoice'])->name('delete-invoice');
        Route::get('/export-payment-list', [PaymentChargedController::class, 'exportPaymentList'])->name('export-payment-list');

        Route::resource('/payment-archive', PaymentInformationArchivedController::class);
        Route::post('/payment-archive/get-payment-information', [PaymentInformationArchivedController::class, 'getPaymentArchivedList'])->name('payment-archive.get-payment-information');
        Route::post('/payment-archive/restore', [PaymentInformationArchivedController::class, 'restore'])->name('payment-archive.restore');
    });

    //general information route module
    route::resource('general-information', GeneralInformationController::class);

    //route for file uploading functionalities
    Route::post('/file-upload', [UploadController::class, 'store'])->name('file-upload');
    Route::post('/delete-quotation-file', [UploadController::class, 'deleteQuotationFile'])->name('delete-quotation-file');


      //route for leads module
      Route::get('leads', [LeadController::class, 'index'])->name('leads');
      Route::get('leads/{leads}/edit', [LeadController::class, 'edit'])->name('leads.edit');
      Route::put('leads/{leads}/update', [LeadController::class, 'update'])->name('leads.update');
      Route::post('leads/{leads}/storeAdditonalCompany', [LeadController::class, 'storeAdditionalCompany'])->name('leads.storeAdditionalCompany');

      Route::get('leads-export', [LeadController::class, 'export'])->name('leads.export');
      Route::get('check-export', [LeadController::class, 'checkExport'])->name('check-export');
      Route::post('leads-import', [LeadController::class, 'import'])->name('leads.import');

      Route::post('add-leads', [LeadController::class, 'store'])->name('leads.store');
      Route::get('get-data-dnc', [LeadController::class, 'getDncData'])->name('get.data.dnc');
      Route::post('dnc-leads-import', [LeadController::class, 'importDnc'])->name('dnc.lead.import');

      Route::get('leads-dnc', [LeadController::class, 'leadsDnc'])->name('leads.dnc');
      Route::get('leads-dnc-view', [LeadController::class, 'viewDnc'])->name('leads-dnc-view');
      Route::get('leads-dnc-export', [LeadController::class, 'exportDnc'])->name('leads-dnc-export');
      Route::get('leads-dnc-request-view', [LeadController::class, 'checkDncExport'])->name('leads-dnc-request-view');
      Route::get('leads-appointed-callback', [LeadController::class, 'getCallBackAppointedLead'])->name('leads-appointed-callback');

      Route::delete('leads/{leads}/delete', [LeadController::class, 'destroy'])->name('leads.destroy');
      Route::post('leads/{leads}/restore', [LeadController::class, 'restore'])->name('leads.restore');
      Route::get('leads/archive', [LeadController::class, 'archive'])->name('leads.archive');
      Route::post('leads/{leads}/restore', [LeadController::class, 'restore'])->name('leads.restore');
      Route::post('leads/add/dnc', [LeadController::class, 'addDnc'])->name('leads.add.dnc');


      Route::prefix('leads')->group(function(){
        Route::resource('/appointed-product-list', AppointedProductListController::class);
      });

      //route for website creation and function
      Route::resource('website', WebsiteController::class);

      //route for market list
      Route::resource('market-list', MarketListController::class);

      //route for pricing breakdown
      Route::resource('pricing-breakdown', PricingBreakdownController::class);

      //route for cancellation report
      Route::prefix('cancellation')->group(function(){
        //cancellation report controller
        Route::resource('cancellation-report', CancellationReportController::class);

        //intent
        Route::resource('intent', IntentController::class);
        Route::post('intent/get-intent-list', [IntentController::class, 'getIntentList'])->name('intent.get-intent-list');

        //cancellation
        Route::resource('primary-cancellation', CancellationController::class);
        Route::post('/get-request-by-customer-cancellation-list', [CancellationController::class, 'getRequestByCustomerCancellationList'])->name('get-request-by-customer-cancellation-list');
        Route::post('/get-request-for-cancellation-list', [CancellationController::class, 'getRequestForCancellationList'])->name('get-request-for-cancellation-list');
        Route::post('/get-request-for-approval-data', [CancellationController::class, 'getRequestForApprovalData'])->name('get-request-for-approval-data');

        //cancellation endorsementphp art
        Route::resource('cancellation-endorsement', CancellationEndorsementController::class);

        //route for cancellation request
        Route::resource('request-cancellation', RequestForCancellationController::class);
        Route::post('request-pending-cancellation', [RequestForCancellationController::class, 'pendingCancellation'])->name('request-pending-cancellation');


        //rewrite policy controller
        Route::resource('rewrite-policy', RewritePolicyController::class);
        Route::post('rewrite-policy/get-subject-for-rewrite-list', [RewritePolicyController::class, 'getSubjectForRewriteList'])->name('rewrite-policy.get-subject-for-rewrite-list');
        Route::post('rewrite-policy/get-for-rewrite-policy', [RewritePolicyController::class, 'getForRewritePolicy'])->name('rewrite-policy.get-for-rewrite-policy');
        Route::post('handled-rewrite-policy', [RewritePolicyController::class, 'handledPolicy'])->name('handled-rewrite-policy');

        //cancelled policy
        Route::resource('cancelled-policy', CancelledPolicyController::class);
        Route::post('cancelled-policy/get-cancelled-policy-list', [CancelledPolicyController::class, 'cancelledPolicyList'])->name('cancelled-policy.get-cancelled-policy-list');
        Route::post('cancelled-policy/get-policy-approved-for-cancellation', [CancelledPolicyController::class, 'getPolicyApprovedForCancellation'])->name('cancelled-policy.get-policy-approved-for-cancellation');
        Route::post('cancellation-policy/save-cancelled-policy', [CancelledPolicyController::class, 'saveCancelledPolicy'])->name('cancellation-policy.save-cancelled-policy');
        Route::post('cancellation-policy/get-cancelled-policy', [CancelledPolicyController::class, 'getCancelledPolicy'])->name('cancellation-policy.get-cancelled-policy');
        Route::post('get-first-touched-policy-data', [CancelledPolicyController::class, 'firstTouchCancelledPolicy'])->name('get-first-touched-policy-data');
        Route::post('get-second-touched-policy-data', [CancelledPolicyController::class, 'secondTouchCancelledPolicy'])->name('get-second-touched-policy-data');
        Route::post('get-touched-policies', [CancelledPolicyController::class, 'getTouchedPolicies'])->name('get-touched-policies');

        //asssign for rewrite policy
        Route::resource('assign-for-rewrite-policy', AssignForRewritePolicyController::class);
        Route::post('get-user-profile-cancelled-policy',[AssignForRewritePolicyController::class, 'getuserProfileAndCancelledPolicy'])->name('get-user-profile-cancelled-policy');

        //for recall cancelled policy
        Route::resource('cancelled-policy-for-recall', CancelledPolicyForRecallController::class);
        Route::post('get-cancelled-policy-for-recall-initial-data', [CancelledPolicyForRecallController::class, 'getCancelledPolicyForRecallIntialData'])->name('get-cancelled-policy-for-recall-initial-data');
        Route::post('change-status-for-cancelled-policy-recall', [CancelledPolicyForRecallController::class, 'changeStatusForCancelledPolicyRecall'])->name('change-status-for-cancelled-policy-recall');


        //quotation for rewrite policy
        Route::resource('for-rewrite-quotation', ForRewriteQuotationController::class);
        Route::post('get-for-rewrite-quotation', [ForRewriteQuotationController::class, 'getForRewriteQuotation'])->name('get-for-rewrite-quotation');
        Route::get('/get-for-rewrite-product-lead-view/{productId}', [ForRewriteQuotationController::class, 'rewriteProfileView'])->name('get-for-rewrite-product-lead-view');


        //rewrite make payment
        Route::resource('for-rewrite-make-payment', ForRewriteMakePaymentController::class);
        Route::post('get-for-rewrite-make-payment', [ForRewriteMakePaymentController::class, 'getForRewriteMakePayment'])->name('get-for-rewrite-make-payment');

        //rewrite binding
        Route::resource('rewrite-binding-policy', RewriteBindingController::class);
        Route::post('get-rewrite-binding-policy', [RewriteBindingController::class, 'getRewriteBindingPolicy'])->name('get-rewrite-binding-policy');
      });

      Route::resource('scrubbed-dnc', ScrubbedDncController::class);
      Route::post('scrubbed-dnc-store-reques-for-dnc', [ScrubbedDncController::class, 'requestForDnc'])->name('scrubbed-dnc-store-request-for-dnc');


        //route for assigning leads
        Route::get('/leads-assigning', [AssignLeadController::class, 'index'])->name('assign');
        Route::get('/getDataTableLeads', [AssignLeadController::class, 'getDataTableLeads'])->name('getDataTableLeads');
        Route::post('/assign-leads', [AssignLeadController::class, 'assign'])->name('assign-leads');
        Route::post('/assign-random-leads', [AssignLeadController::class, 'assignRandomLeads'])->name('assign-random-leads');
        Route::post('/assign-leads-user', [AssignLeadController::class, 'assignLeadsUser'])->name('assign-random-leads-user');
        Route::post('/void-leads-user', [AssignLeadController::class, 'void'])->name('void-leads-user');
        Route::post('/redeploy-leads-user', [AssignLeadController::class, 'redeploy'])->name('redeploy-leads-user');
        Route::get('/{leads}/edit',[AssignLeadController::class, 'edit'])->name('edit-leads-user');
        Route::post('/void-all',[AssignLeadController::class, 'voidAll'])->name('void-all');
        Route::post('/assign-premium-leads',[AssignLeadController::class, 'assignPremiumLead'])->name('assign-premium-leads');
        Route::post('/delete-selected-leads', [AssignLeadController::class, 'deleteSelectedLeads'])->name('delete-selected-leads');
        Route::get('getStates', [AssignLeadController::class, 'getStates'])->name('get-states');

        //routes for apptaker leads
        Route::prefix('list-leads')->group(function  () {
         Route::get('/', [AppTakerLeadsController::class, 'index'])->name('apptaker-leads');
         Route::post('/multi-state-work', [AppTakerLeadsController::class, 'multiStateWork'])->name('mutli.state.work');
         Route::get('/filter-cities', [AppTakerLeadsController::class, 'filterCities'])->name('filter-cities');
         Route::get('/product/pdf', [AppTakerLeadsController::class, 'productPdf'])->name('product.pdf');
         Route::get('/product/forms', [AppTakerLeadsController::class, 'productForms'])->name('product.forms');
         Route::post('/list-lead-id', [AppTakerLeadsController::class, 'listLeadId'])->name('list-lead-id');
         Route::get('/assign-appointed-lead', [AssignAppointedLeadController::class, 'index'])->name('assign-appointed-lead');
         Route::post('/assign-appointed-lead/assign-lead', [AssignAppointedLeadController::class, 'assignAppointedLead'])->name('assign-leads-market-specialist');
         Route::get('/assign-appointed-lead/get-data-table', [AssignAppointedLeadController::class, 'getDataTable'])->name('get-data-table');
         Route::post('/request-to-quoute', [AssignAppointedLeadController::class, 'requestToQuote'])->name('request-to-quote');
         Route::post('/assign-remark-leads', [AppTakerLeadsController::class, 'storeLeadRemarksDisposition'])->name('assign-remark-leads');
         Route::post('/update-remark-leads', [AppTakerLeadsController::class, 'updateLeadRemarksDisposition'])->name('update-remark-leads');
        });

        //route for appointed list
        Route::prefix('appointed-list')->group(function(){
            route::get('/', [AppointedController::class, 'index'])->name('appointed-list');
            route::get('/{leadsId}', [AppointedController::class, 'leadsProfileView'])->name('appointed-list-profile-view');
        });

        //route for quotation leads
        Route::prefix('quoatation')->group(function (){
         //routes for qoutation module
         Route::get('/appointed-leads', [QuotationController::class, 'appointedLeadsView'])->name('appointed-leads');
         Route::post('/lead-profile', [QuotationController::class, 'leadProfile'])->name('lead-profile');
         Route::get('/lead-profile-view/{productId}', [QuotationController::class, 'leadProfileView'])->name('lead-profile-view');

         Route::get('/sync-selected-quote_id', [QuotationController::class, 'syncSelectedQuoteId'])->name('sync-selected-quote_id');
         Route::post('/get-quote-list-table', [QuotationController::class, 'getQuoteListTable'])->name('get-quote-list-table');

         Route::post('/save-quotation-product', [QuotationController::class, 'saveQuotationProduct'])->name('save-quotation-product');
         Route::get('/get-comparison-data', [QuotationController::class, 'getComparisonData'])->name('get-comparison-data');

         //quotation comparison functionalities
         Route::post('/save-quotation-comparison', [QuotationController::class, 'saveQuoteComparison'])->name('save-quotation-comparison');
         Route::post('/edit-quotation-comparison', [QuotationController::class, 'editQuotationComparison'])->name('edit-quotation-comparison');
         Route::post('/update-quotation-comparison', [QuotationController::class, 'updateQuotationComparison'])->name('update-quotation-comparison');
         Route::post('/delete-quotation-comparison', [QuotationController::class, 'deleteQuotationComparison'])->name('delete-quotation-comparison');

         Route::post('/send-quotation-product', [QuotationController::class, 'sendQuotationProduct'])->name('send-quotation-product');
         Route::get('/get-quoted-product', [QuotationController::class, 'getQuotedProduct'])->name('get-quoted-product');
         Route::post('/assign-broker-assistant', [QuotationController::class, 'assignBrokerAssistant'])->name('assign-broker-assistant');
         Route::get('/get-pending-product', [QuotationController::class, 'getPendingProduct'])->name('get-pending-product');
         Route::post('/quoted-product-profile', [QuotationController::class, 'quotedProductProfile'])->name('quoted-product-profile');
         Route::get('/broker-profile-view/{leadId}/{generalInformationId}/{productId}', [QuotationController::class, 'brokerProfileView'])->name('broker-profile-view');
         Route::get('/broker-profile-view/{productId}', [QuotationController::class, 'brokerProfileViewProduct'])->name('broker-profile-view-product');
         Route::get('/get-assign-qouted-lead', [QuotationController::class, 'getAssignQoutedLead'])->name('get-assign-qouted-lead');
         Route::post('/void-qouted-lead', [QuotationController::class, 'voidQoutedLead'])->name('void-qouted-lead');
         Route::post('/redeploy-qouted-lead', [QuotationController::class, 'redeployQoutedLead'])->name('redeploy-qouted-lead');
         Route::post('/change-status', [QuotationController::class, 'changeStatus'])->name('change-quotation-status');
         Route::post('/set-callback-date', [QuotationController::class, 'setCallBackDate'])->name('set-callback-date');
         Route::get('/get-confirmed-product', [QuotationController::class, 'getConfirmedProduct'])->name('get-confirmed-product');
         Route::get('/get-broker-product', [QuotationController::class, 'getBrokerProduct'])->name('get-broker-product');
         //getting table for quotation
         Route::get('/get-general-liabilities-quotation-table', [QuotationController::class, 'getGeneralLiabilitiesTable'])->name('get-general-liabilities-quotation-table');

         //route for notes
         Route::post('/create-notes', [NotesController::class, 'createNotes'])->name('create-notes');
         Route::get('/{note}/get-notes', [NotesController::class, 'getNotes'])->name('get-notes');

         //route for Assigning Appointed Lead Controller
         Route::post('/void-leads', [AssignAppointedLeadController::class, 'voidLeads'])->name('void-appointed-leads');
         Route::post('/redeploy-leads', [AssignAppointedLeadController::class, 'redeployLeads'])->name('redeploy-appointed-leads');

         //selected quote routes
         Route::resource('/selected-quote', SelectedQuoteController::class);
         Route::post('/update-selected-quote', [SelectedQuoteController::class, 'updateSelectedQuote'])->name('update-selected-quote');
         Route::post('/edit-selected-quote', [SelectedQuoteController::class, 'editSelectedQuote'])->name('edit-selected-quote');

         //code for callback
         Route::resource('/quotation-callback', QuotationProductCallbackController::class);
        });

        //route for quoted products
        Route::prefix('quoted')->group(function(){
            Route::resource('/quoted-product', QuotedController::class);
            Route::post('/get-quoted-product', [QuotedController::class, 'getQuotedProduct'])->name('get-product-quoted');
            Route::post('/getBindingProduct', [QuotedController::class, 'getBindingProduct'])->name('get-quoted-binding-product');
        });

        Route::prefix('notification')->group(function(){
            Route::resource('/general-notification', GeneralNotificationController::class);
        });

        Route::prefix('broker-assistant')->group(function(){
            //
            Route::resource('/broker-assistant', BrokerAssistantController::class);
            Route::post('/get-pending-product', [BrokerAssistantController::class, 'getPendingProduct'])->name('get-broker-pending-product');
            Route::post('/get-compliance-product', [BrokerAssistantController::class, 'getComplianceProduct'])->name('get-broker-compliance-product');
            Route::post('/get-complied-product', [BrokerAssistantController::class, 'getCompliedProduct'])->name('get-broker-complied-product');
            Route::post('/get-make-payment-list', [BrokerAssistantController::class, 'makePaymentList'])->name('get-make-payment-list');
            Route::post('/get-request-to-bind', [BrokerAssistantController::class, 'getRequestToBind'])->name('get-broker-request-to-bind');
            Route::post('/get-for-follow-up-product', [BrokerAssistantController::class, 'getForFollowUpProduct'])->name('get-for-follow-up-product');
            Route::post('/get-recent-bound-product', [BrokerAssistantController::class, 'getRecentBoundProduct'])->name('get-recent-bound-product');


            //Leads For Follow Up Broker Assistant
            Route::resource('/leads-for-follow-up', BrokerForFollowUpController::class);
            Route::post('/get-warm-product', [BrokerForFollowUpController::class, 'getWarmProduct'])->name('get-warm-product');
            Route::post('/get-old-product', [BrokerForFollowUpController::class, 'getOldProduct'])->name('get-old-product');

        });

        Route::prefix('broker')->group(function(){
            Route::resource('/product', ComplianceController::class);
            Route::post('/get-pending-product', [ComplianceController::class, 'getPendingProduct'])->name('get-compliance-pending-product');
            Route::post('/get-complied-product', [ComplianceController::class, 'getCompliedBrokerProduct'])->name('get-compliance-complied-product');
            Route::post('/get-make-payment-list', [ComplianceController::class, 'getMakePaymentList'])->name('get-compliance-make-payment-list');
            Route::post('/get-binding-list', [ComplianceController::class, 'getBindingList'])->name('get-compliance-binding-list');
            Route::post('/get-handled-product', [ComplianceController::class, 'getHandledList'])->name('get-compliance-handled-product');
            Route::resource('/broker-handle', BrokerHandleController::class);
            Route::post('/broker-handle/get-broker-list', [BrokerHandleController::class, 'getBrokerList'])->name('get-broker-handle-list');
            Route::resource('/assign-agent-to-broker', AssignAgentToBrokerController::class);
        });

        //route for insurer module
        Route::prefix('insurer')->group(function(){
            Route::get('', [InsurerController::class, 'index'])->name('insurer');
            Route::post('/store', [InsurerController::class, 'store'])->name('insurer.store');
            Route::get('/{id}/edit', [InsurerController::class, 'edit'])->name('insurer.edit');
            Route::put('/{id}', [InsurerController::class, 'update'])->name('insurer.update');
            Route::delete('/{id}', [InsurerController::class, 'destroy'])->name('insurer.destroy');
        });

        //route for messages
        Route::prefix('messages')->group(function(){
            Route::resource('messages', MessageController::class);
            Route::post('/get-messages', [MessageController::class, 'getMessages'])->name('get-messages');
            Route::post('/get-client-emails', [MessageController::class, 'getClientEmails'])->name('get-clients-emails');
        });


        Route::prefix('note')->group(function(){
           Route::get('/{id}/get-general-information', [NotesController::class, 'getGeneralInformation'])->name('get-general-information');
           Route::get('/{id}/get-lead-note', [NotesController::class, 'getNoteUsingLeadid'])->name('get-lead-note');
        });

        //route for customer service
        Route::prefix('customer-service')->group(function(){
            //binding routes
            Route::get('/binding', [BindingController::class, 'index'])->name('binding');
            Route::post('/binding/request-to-bind', [BindingController::class, 'requestToBind'])->name('request-to-bind');
            Route::post('binding/request-to-bind-information', [BindingController::class, 'requestToBindInformation'])->withoutMiddleware(['auth:sanctum'])->name('request-to-bind-information');
            Route::post('/binding/incomplete-binding-list', [BindingController::class, 'incompleteBindingList'])->withoutMiddleware(['auth:sanctum'])->name('incomplete-binding-list');
            Route::post('/binding-view-list', [BindingController::class, 'bindingViewList'])->name('binding-view-list');
            Route::post('/resend-rtb', [BindingController::class, 'resendRtb'])->name('resend-rtb');

            Route::post('/bound/list', [BoundController::class, 'index'])->name('bound-list');
            Route::post('/bound/get-bound-information', [BoundController::class, 'getBoundInformation'])->name('get-bound-information');

            //saving of product policies
            Route::post('binding/save-general-liabilities-policy', [BindingController::class, 'saveGeneralLiabilitiesPolicy'])->name('binding.save-general-liabilities-policy');
            Route::put('binding/update-general-liabilities-policy/{id}', [BindingController::class, 'updateGeneralLiabilitiesPolicy'])->name('binding.update-general-liabilities-policy');


            //route for commercial auto policies
            Route::resource('/commercial-auto-policy', CommercialAutoPolicyController::class);

            //route for workers compensation policies
            Route::resource('/workers-compensation-policy', WorkersCompPolicyController::class);

            //route for tools and equipment policies
            Route::resource('/tools-equipment-policy', ToolsEquipmentPolicyController::class);

            //route for bussiness owner policy
            Route::resource('/business-owner-policy', BussinessOwnersPolicyDetailsController::class);

            //route for builders risk policy
            Route::resource('/builders-risk-policy', BuildersRiskPolicyDetailsController::class);

            //route for excess liability insurance policy
            Route::resource('/excess-insurance-policy', ExcessLiabilityInsurancePolicyController::class);

            //route for assigning quoted policies
            Route::resource('/assign-quoted-policy', AssignQuotedRenewalPolicyController::class);
            Route::post('/void-quoted-policy', [AssignQuotedRenewalPolicyController::class, 'voidQuotedPolicy'])->name('void-quoted-renewal-policy');
            Route::post('/reassign-quoted-renewal-policy', [AssignQuotedRenewalPolicyController::class, 'reassignQuotedRenewalPolicy'])->name('reassign-quoted-renewal-policy');

            //route for policy renewal
            Route::resource('/policy-renewal', PolicyForRenewalController::class);

            //route for main renewal process below of the assign quoted renewal
            Route::resource('/renewal-policy', RenewalPolicyController::class);
            Route::post('/policy-for-renewal-list', [RenewalPolicyController::class, 'policyForRenewalList'])->name('policy-quoted-for-renewal-list');
            Route::post('/process-quoted-policy-renewal', [RenewalPolicyController::class, 'processQuotedPolicyRenewal'])->name('process-quoted-policy-renewal');
            Route::get('/get-renewal-policy-view/{productId}', [RenewalPolicyController::class, 'renewalPolicyView'])->name('get-renewal-policy-view');
            Route::post('/renewal-make-payment', [RenewalPolicyController::class, 'renewalMakePaymentList'])->name('renewal-make-payment-list');
            Route::post('/renewal-request-to-bind', [RenewalPolicyController::class, 'renewalRequestToBind'])->name('renewal-request-to-bind');
            Route::post('/new-renewed-policy', [RenewalPolicyController::class, 'newRenewedPolicy'])->name('new-renewed-policy');

            //routes for policies
            Route::get('/get-policy-list', [PoliciesController::class, 'getPolicyList'])->name('get-policy-list');
            Route::post('/get-policy-details', [PoliciesController::class, 'getPolicyDetails'])->name('get-policy-details');
            Route::get('/policy-list', [PoliciesController::class, 'index'])->name('policy-list');
            Route::post('/new-policy-list', [PoliciesController::class, 'newPolicyList'])->withoutMiddleware(['auth:sanctum'])->name('new-policy-list');
            Route::post('/change-policy-status/{id}', [PoliciesController::class, 'changeStatus'])->name('change-policy-status');
            Route::post('/client-policy-list', [PoliciesController::class, 'getClienPolicyList'])->name('client-policy-list');
            Route::post('/client-active-policy-list', [PoliciesController::class, 'getClientActivePolicyList'])->name('client-active-policy-list');
            Route::post('/get-policy-information', [PoliciesController::class, 'getPolicyInformation'])->name('get-policy-information');
            Route::post('/update-file-policy', [PoliciesController::class, 'updatePolicyFile'])->name('update-file-policy');
            Route::post('/change-policy-status', [PoliciesController::class, 'changePolicyStatus'])->name('change-status-for-policy');

            //routes for bound
            Route::post('/save-bound-information', [BoundController::class, 'saveBoundInformation'])->name('save-bound-information');


            //routes for binding docs
            Route::get('/binding-docs', [BindingDocsController::class, 'index'])->name('binding-docs');
            Route::post('/upload-file-binding-docs', [BindingDocsController::class, 'uploadFile'])->name('upload-file-binding-docs');
            Route::post('/delete-binding-docs', [BindingDocsController::class, 'deleteBindingDocs'])->name('delete-binding-docs');
            Route::post('/get-binding-docs', [BindingDocsController::class, 'getMedia'])->name('get-binding-docs');

            //route financing
            Route::prefix('financing')->group(function(){
                Route::resource('/financing-company', FinancingCompanyController::class);
                Route::resource('/financing-agreement', FinancingController::class);
                Route::resource('/finance-agreement-list', FinanceAgreementPolicyList::class);
                Route::post('/finance-agreement-list/get-data-table', [FinanceAgreementPolicyList::class, 'getDataTable'])->name('finance-agreement-list.get-data-table');
                Route::post('/financing-aggreement/product-for-financing', [FinancingController::class, 'productForFinancing'])->name('financing-aggreement.product-for-financing');
                Route::post('/financing-aggreement/creation-of-pfa', [FinancingController::class, 'pfaCreation'])->name('financing-aggreement.creation-of-pfa');
                Route::post('/financing-aggrement/new-financing-agreement', [FinancingController::class, 'newFinancingAgreement'])->name('financing-aggrement.new-financing-agreement');
                Route::post('/get-customers-financing-agreement', [FinancingController::class, 'getCustomersPfa'])->name('get-customers-financing-agreement');
                Route::post('/get-incomplete-pfa', [FinancingController::class, 'incompletePfa'])->name('get-incomplete-pfa');
            });

            //route for renewal
            Route::prefix('renewal')->group(function(){
                Route::resource('/renewal', RenewalController::class);
                Route::post('/assign-policy-for-renewal', [RenewalController::class, 'assignPolicyForRenewal'])->name('renewal.assign-policy-for-renewal');
                Route::post('/reassign-policy-for-renewal', [RenewalController::class, 'reassignPolicyForRenewal'])->name('renewal.reassign-policy-for-renewal');
                Route::post('/void-policy-for-renewal', [RenewalController::class, 'voidPolicyForRenewal'])->name('renewal.void-policy-for-renewal');

                Route::get('/get-renewal-lead-view/{productId}', [RenewalController::class, 'leadProfileView'])->name('get-renewal-lead-view');

                Route::resource('/for-renewal', PolicyForRenewalController::class);

                Route::resource('/renewal-quote', RenewalQuoteController::class);
                Route::post('/renewal/get-renewal-reminder', [RenewalController::class, 'getRenewalReminder'])->name('renewal.get-renewal-reminder');
                Route::post('/renewal/send-renewal-reminder-email', [RenewalController::class, 'sendRenewalReminderEmail'])->name('renewal.send-renewal-reminder-email');
                Route::post('/renewal/get-renewal-for-quote', [RenewalQuoteController::class, 'getForQuoteRenewal'])->name('renewal.get-renewal-for-quote');
                Route::post('/renewal/get-quoted-renewal', [RenewalQuoteController::class, 'getQuotedRenewal'])->name('renewal.get-quoted-renewal');
                Route::post('/renewal-handled-policy', [RenewalQuoteController::class, 'renewalHandledPolicy'])->name('renewal-handled-policy');
                Route::post('/renewal-quote/edit-renewal-quote', [RenewalQuoteController::class, 'editRenewalQuote'])->name('renewal-quote.edit-renewal-quote');


            });

            //route for audit
            Route::prefix('audit')->group(function(){
                Route::resource('/audit', AuditInformationController::class);
                Route::post('/get-audit-information-table', [AuditInformationController::class, 'getAuditInformationTable'])->name('get-audit-information-table');
                Route::resource('/required-audit-file', AuditRequiredFileController::class);
            });

        });

        Route::prefix('product')->group(function(){
            Route::post('/save-media', [ProductController::class, 'saveMedia'])->name('product-save-media');
            Route::post('/get-media', [ProductController::class, 'getRTBMedia'])->name('product-get-rtb-media');
        });

        //email for quotation leads
        Route::prefix('email')->group(function (){
         Route::post('/send-email', [EmailController::class, 'sendQuotation'])->name('send-quotation');
         Route::post('/send-follow-up-email', [EmailController::class, 'sendFollowUpEmail'])->name('send-follow-up-email');
         Route::post('/send-templated-email', [EmailController::class, 'sendTemplatedEmail'])->name('send-templated-email');
        });

        //storiing for callback
        Route::prefix('call-back')->group(function (){

         //callback routes
         Route::post('/store', [CallBackController::class, 'store'])->name('call-back.store');
         Route::post('/store-appointed-callback', [CallBackController::class, 'storeAppointedCallback'])->name('call-back.store-appointed-callback');
         Route::get('/callback-lead', [CallBackController::class, 'index'])->name('callback-lead');
         Route::put('/update/{id}', [CallBackController::class, 'update'])->name('call-back.update');

         Route::get('/callback-list-today', [CallBackController::class, 'callBackListToday'])->name('callback-list-today');

         Route::put('/update-non-callback-dispositions/{id}', [CallBackController::class, 'updateNonCallbackDispositions'])->name('update-non-callback-dispositions');
         Route::get('/other-dispositions-data', [CallBackController::class, 'otherDispositionsData'])->name('other-dispositions-data');
         Route::post('/delete/{id}', [CallBackController::class, 'deleteNonCallbackDisposition'])->name('non-call-back.destroy');
         Route::post('/delete-callback/{id}', [CallBackController::class, 'deleteCallBackDisposition'])->name('delete-callback-disposition');
        });

        // Leads Routes
        Route::prefix('leads')->group(function () {
         // Disposition
         Route::resource('/disposition', DispositionController::class)->except(['update']);
         Route::post('/disposition/update', [DispositionController::class, 'update'])->name('disposition.update');

         // Classcodes
         Route::resource('/classcodes', ClasscodesController::class)->except(['update']);
         Route::post('/classcodes/update', [ClasscodesController::class, 'update'])->name('classcodes.update');

         // SIC
         Route::resource('/sic', SICController::class)->except(['update']);
         Route::post('/sic/update', [SICController::class, 'update'])->name('sic.update');

         Route::post('/search-lead', [LeadController::class, 'searchLead'])->name('search-lead');
         Route::post('/search-lead-by-search', [LeadController::class, 'getLeadDataBySearch'])->name('get-leads-by-search-data');

         Route::post('/store-request-for-dnc', [LeadController::class, 'requestForDnc'])->name('store-request-for-dnc');
         Route::get('/dnc/{id}/edit', [LeadController::class, 'editDnc'])->name('edit-dnc');
         Route::post('/dnc/update', [LeadController::class, 'updateDnc'])->name('update-dnc');
         Route::post('/dnc/delete', [LeadController::class, 'deleteDnc'])->name('delete-dnc');
        });

        //route for lead task scheduler
        Route::prefix('scheduler')->group(function(){
            route::resource('/task-scheduler', LeadTaskSchedulerController::class);
            Route::post('/get-task-scheduler', [LeadTaskSchedulerController::class, 'getTaskScheduler'])->name('get-task-scheduler');
        });


        Route::prefix('non-callback')->group(function(){
            Route::get('/', [NonCallBackDispositionController::class, 'index'])->name('non-callback-disposition');
        });

        Route::prefix('hrforms')->name('hrforms.')->group(function () {
            // Accountability Form
            Route::get('/accountability-form', [HrController::class, 'showAccountabilityForm'])->name('accountability-form');
            Route::post('/accountability-form-generate', [PdfController::class, 'generateAccountabilityFormPdf'])->name('accountability-form-generate-pdf');

            // Incident Report Form
            Route::get('/incident-report-form', [HrController::class, 'showIncidentReportForm'])->name('incident-report-form');
            Route::post('/incident-report-form-generate', [PdfController::class, 'generateIncidentReportFormPdf'])->name('incident-report-form-generate-pdf');

            // Company Handbook
            Route::get('/company-handbook', [CompanyHandbookController::class, 'showCompanyHandbook'])->name('company-handbook');
            Route::post('/company-handbook-save', [CompanyHandbookController::class, 'saveOrUpdateCompanyHandbookRecord'])->name('company-handbook-save-or-update');

            // Attendance Records
            Route::get('/attendance-records', [AttendanceController::class, 'index'])->name('attendance-records-index');
            Route::get('/attendance-records-filter', [AttendanceController::class, 'selectByFilter'])->name('attendance-records-filter');

            // Birthday Calendar
            Route::get('/birthday-calendar', [BirthdayController::class, 'index'])->name('birthday-calendar-index');
            Route::get('/birthday-calendar-get-birthdays', [BirthdayController::class, 'getAllBirthdayEvents'])->name('birthday-calendar-get-birthdays');

            // Route::get('/attendance-records-filter-by-user', [AttendanceController::class, 'selectUserFilter'])->name('attendance-records-filter-by-user');
            // Route::get('/attendance-records-filter-by-login-type', [AttendanceController::class, 'selectLoginTypeFilter'])->name('attendance-records-filter-by-login-type');
            // Route::get('/attendance-records', [AttendanceController::class, 'filters'])->name('attendance-filters');
        });

        Route::get('/hellosign', [HelloSignController::class, 'initiateSigning']);
        Route::post('/hellosign/callback', [HelloSignController::class, 'handleCallback']);

        //routes for Departments
        Route::prefix('departments')->group(function(){
          Route::get('/it-department', [DepartmentListController::class, 'getItEmployeeList'])->name('it-department');
          Route::get('/csr-department', [DepartmentListController::class, 'getCsrEmployeeList'])->name('csr-department');
        });

            //middleware route for adming
    Route::middleware(['role:admin'])->group(function(){

        //routes for admin security
        Route::prefix('/admin')->name('admin.')->group(function(){
            Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
            Route::resource('/permissions', PermissionController::class)->except(['update']);
            Route::post('/permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
            Route::resource('/roles', RoleController::class);
            Route::resource('/users', UserController::class)->except(['update']);
            Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
            Route::resource('/positions', PositionController::class)->except('update');
            Route::post('/positions/update', [PositionController::class, 'update'])->name('positions.update');
            //  Route::delete('positions/destroy/{$id}/', [PositionController::class, 'destroy'])->name('positions.destroy');
            Route::resource('/departments', DepartmentController::class)->except('update');
            Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
            Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.assignRole');
            Route::resource('/user-profiles', UserProfileController::class)->except('update');
            Route::post('/user-profiles/update', [UserProfileController::class, 'update'])->name('user-profiles.update');
            Route::post('/user-profiles/change-status', [UserProfileController::class, 'changeStatus'])->name('user-profiles.change_status');
            //  Route::put('/permission/{permission}', [PermissionController::class, 'update']);

            Route::prefix('/marketing')->name('marketing')->group(function(){
                Route::resource('/template', MarketingTemplateController::class);
                Route::post('/get-template-list', [MarketingTemplateController::class, 'getListOfTemplates'])->name('get-template-list');
                Route::get('/add-template', [MarketingTemplateController::class, 'addTemplate'])->name('add-template');
            });
        });
    });
    //end middleware route for admin
});


//Route for sending css file into front end
Route::get('/assets/css/{file}', function ($file) {
    return response()->file(public_path('assets/css/' . $file));
})->where('file', '.*');


Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');