<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('/admin')->group(function() {
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
