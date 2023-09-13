<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:role_manage');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permission_manage');
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])->middleware('permission:admin_manage')->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])->middleware('permission:admin_manage')->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])->middleware('permission:admin_manage')->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admin_manage');
Route::get('/profile',[AdminController::class,'profile'])->name('profile');
Route::post('/profile',[AdminController::class,'profile_update'])->name('profile_update');
