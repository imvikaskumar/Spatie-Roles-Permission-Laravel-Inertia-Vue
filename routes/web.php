<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RemovePermissionFromRoleController;
use App\Http\Controllers\Backend\RemovePermissionFromUserController;
use App\Http\Controllers\Backend\RemoveRoleFromUserController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin/')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::delete('roles/{role}/permissions/{permission}', RemovePermissionFromRoleController::class)
        ->name('roles.permissions.destroy');
    Route::delete('users/{user}/permissions/{permission}', RemovePermissionFromUserController::class)
        ->name('users.permissions.destroy');
    Route::delete('users/{user}/roles/{role}', RemoveRoleFromUserController::class)
        ->name('users.roles.destroy');
});

Route::resource('posts', PostController::class)->middleware('role:admin|moderator|writer');


require __DIR__.'/auth.php';