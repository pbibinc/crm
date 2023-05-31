<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\GeneralInformationController;
use App\Http\Controllers\AssignLeadController;
use App\Http\Controllers\AppTakerLeadsController;
use App\Http\Controllers\DepartmentListController;

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
Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function() {
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
});


Route::prefix('list-leads')->group(function (){
    Route::get('/', [AppTakerLeadsController::class, 'index'])->name('apptaker-leads');
});


//Ending Routes for leads modules


//routes for Departments
Route::prefix('departments')->group(function(){
    Route::get('/it-department', [DepartmentListController::class, 'getItEmployeeList'])->name('it-department');
    Route::get('/csr-department', [DepartmentListController::class, 'getCsrEmployeeList'])->name('csr-department');
});
//end Routes for departments


Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
