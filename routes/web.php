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
use App\Http\Controllers\PositionController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\HelloSignController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClasscodesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardControllerNew;
use App\Http\Controllers\TecnickcomPdfController;
use App\Http\Controllers\CompanyHandbookController;
use App\Http\Controllers\EmbeddedSignatureController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});


// Admin All Route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function () {
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::resource('/permissions', PermissionController::class)->except(['update']);
    Route::post('/permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
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

Route::controller(LeadController::class)->group(function () {
    Route::get('leads', 'index')->name('leads');
    Route::get('leads-export', 'export')->name('leads.export');
    Route::post('leads-import', 'import')->name('leads.import');
});

// Dashboard 
Route::prefix('dashboard')->group(function () {
    Route::resource('/', DashboardControllerNew::class)->except(['edit', 'update', 'delete', 'create', 'show', 'edit']);
    Route::get('/', [DashboardControllerNew::class, 'index'])->name('dashboard');
    Route::post('/store', [DashboardControllerNew::class, 'store'])->name('dashboard.store');
    Route::get('/aux-duration', [DashboardControllerNew::class, 'getAuxDuration'])->name('dashboard.getAuxDuration');
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
    // Accountability Forms
    Route::get('/accountability-form', [HrController::class, 'showAccountabilityForm'])->name('accountability-form');
    Route::post('/accountability-form-generate', [PdfController::class, 'generatePdf'])->name('accountability-form-generate-pdf');

    // Company Handbook
    Route::get('/company-handbook', [CompanyHandbookController::class, 'showCompanyHandbook'])->name('company-handbook');
    Route::post('/company-handbook-save', [CompanyHandbookController::class, 'saveOrUpdateCompanyHandbookRecord'])->name('company-handbook-save-or-update');

    // Attendance Calendar
    Route::get('/attendance-records', [AttendanceController::class, 'showAttendanceRecords'])->name('attendance-records');
});

// PDF Example (tecnickcom/tcpdf)
// Route::get('/tecnickcom-pdf', function (Request $request) {
//     return app()->call('App\Http\Controllers\TecnickcomPdfController@generatePdf');
// });


Route::get('/hellosign', [HelloSignController::class, 'initiateSigning']);
Route::post('/hellosign/callback', [HelloSignController::class, 'handleCallback']);


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
