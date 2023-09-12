<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SICController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\LeadDetailController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\HelloSignController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClasscodesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\GeneralInformationController;
use App\Http\Controllers\AssignLeadController;
use App\Http\Controllers\AppTakerLeadsController;
use App\Http\Controllers\CallBackController;
use App\Http\Controllers\DepartmentListController;
use App\Http\Controllers\DashboardControllerNew;
use App\Http\Controllers\TecnickcomPdfController;
use App\Http\Controllers\CompanyHandbookController;
use App\Http\Controllers\EmbeddedSignatureController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('welcome');
});


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


//Routes For Admin Module
Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function () {
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
});
//end Routes For admin module


//Routes for Leads Modules

Route::get('leads', [LeadController::class, 'index'])->name('leads');
Route::get('leads-export', [LeadController::class, 'export'])->name('leads.export');
Route::post('leads-import', [LeadController::class, 'import'])->name('leads.import');
Route::post('add-leads', [LeadController::class, 'store'])->name('leads.store');
Route::get('get-data-dnc', [LeadController::class, 'getDncData'])->name('get.data.dnc');
Route::post('dnc-leads-import', [LeadController::class, 'importDnc'])->name('dnc.lead.import');
Route::get('leads-dnc', [LeadController::class, 'leadsDnc'])->name('leads.dnc');
Route::delete('leads/{leads}/delete', [LeadController::class, 'destroy'])->name('leads.destroy');
Route::post('leads/{leads}/restore', [LeadController::class, 'restore'])->name('leads.restore');
Route::get('leads/archive', [LeadController::class, 'archive'])->name('leads.archive');
Route::post('leads/{leads}/restore', [LeadController::class, 'restore'])->name('leads.restore');
Route::post('leads/add/dnc', [LeadController::class, 'addDnc'])->name('leads.add.dnc');


Route::prefix('assign')->group(function () {
    Route::get('/', [AssignLeadController::class, 'index'])->name('assign');
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
});


Route::prefix('list-leads')->group(function  () {
    Route::get('/', [AppTakerLeadsController::class, 'index'])->name('apptaker-leads');
    Route::post('/multi-state-work', [AppTakerLeadsController::class, 'multiStateWork'])->name('mutli.state.work');
    Route::get('/filter-cities', [AppTakerLeadsController::class, 'filterCities'])->name('filter-cities');
    Route::get('/product/pdf', [AppTakerLeadsController::class, 'productPdf'])->name('product.pdf');
    Route::get('/product/forms', [AppTakerLeadsController::class, 'productForms'])->name('product.forms');
    Route::post('/list-lead-id', [AppTakerLeadsController::class, 'listLeadId'])->name('list-lead-id');

});

Route::prefix('quoataion')->group(function (){
    Route::get('/appointed-leads', [QuotationController::class, 'appointedLeadsView'])->name('appointed-leads');
    Route::post('/lead-profile', [QuotationController::class, 'leadProfile'])->name('lead-profile');
    Route::get('/lead-profile-view', [QuotationController::class, 'leadProfileView'])->name('lead-profile-view');
});

Route::prefix('call-back')->group(function (){
    Route::post('/store', [CallBackController::class, 'store'])->name('call-back.store');
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::resource('/', DashboardControllerNew::class)->except(['edit', 'update', 'delete', 'create', 'show', 'edit']);
    Route::get('/', [DashboardControllerNew::class, 'index'])->name('dashboard');
    Route::post('/store', [DashboardControllerNew::class, 'store'])->name('dashboard.store');
    Route::get('/aux-duration', [DashboardControllerNew::class, 'getAuxDuration'])->name('dashboard.getAuxDuration');
    Route::get('/table-data', [DashboardControllerNew::class, 'getTableData'])->name('dashboard.table-data');
    Route::get('/aux-history-data', [DashboardControllerNew::class, 'getAuxHistoryData'])->name('dashboard.aux-history-data');
    Route::get('/check-aux-status', [DashboardControllerNew::class, 'checkAuxLogoutStatus'])->name('dashboard.check-aux-status');
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


//Ending Routes for leads modules

Route::get('/hellosign', [HelloSignController::class, 'initiateSigning']);
Route::post('/hellosign/callback', [HelloSignController::class, 'handleCallback']);

//routes for Departments
Route::prefix('departments')->group(function(){
    Route::get('/it-department', [DepartmentListController::class, 'getItEmployeeList'])->name('it-department');
    Route::get('/csr-department', [DepartmentListController::class, 'getCsrEmployeeList'])->name('csr-department');
});
//end Routes for departments

//routes for Departments
Route::prefix('departments')->group(function(){
    Route::get('/it-department', [DepartmentListController::class, 'getItEmployeeList'])->name('it-department');
    Route::get('/csr-department', [DepartmentListController::class, 'getCsrEmployeeList'])->name('csr-department');
});
//end Routes for departments

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
