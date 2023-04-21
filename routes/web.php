<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PositionController;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\ClasscodesController;
use App\Http\Controllers\DashboardControllerNew;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\UserProfileController;

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
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::resource('/permissions', PermissionController::class)->except(['update']);
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/positions', PositionController::class)->except('update');
    Route::post('/positions/update', [PositionController::class, 'update'])->name('positions.update');
    Route::resource('/departments', DepartmentController::class);
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.assignRole');
    //  Route::put('/permission/{permission}', [PermissionController::class, 'update']);
});

// // Dashboard 
// // Time In / Out
// Route::resource('/dashboard', DashboardControllerNew::class)->except(['update']);
// Route::get('/dashboard', [DashboardControllerNew::class, 'index'])->name('dashboard');
// Route::post('/dashboard/store', [DashboardControllerNew::class, 'store'])->name('dashboard.store');


// Dashboard 
// Time In / Out
Route::resource('/dashboard', DashboardControllerNew::class)->except(['edit', 'update', 'delete', 'create', 'show', 'edit']);
Route::get('/dashboard', [DashboardControllerNew::class, 'index'])->name('dashboard');
Route::post('/dashboard/store', [DashboardControllerNew::class, 'store'])->name('dashboard.store');

// Leads Routes
// Disposition
Route::resource('/leads/disposition', DispositionController::class)->except(['update']);
Route::post('/leads/disposition/update', [DispositionController::class, 'update'])->name('disposition.update');
// Classcodes
Route::resource('/leads/classcodes', ClasscodesController::class)->except(['update']);
Route::post('/leads/classcodes/update', [ClasscodesController::class, 'update'])->name('classcodes.update');

// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
