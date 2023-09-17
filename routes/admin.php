<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BreedsController;
use App\Http\Controllers\Admin\CattleTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SessionYearController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:role_manage');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permission_manage');

//Admin
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])->middleware('permission:admin_manage')->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])->middleware('permission:admin_manage')->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])->middleware('permission:admin_manage')->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admin_manage');

//Profile
Route::get('/profile',[AdminController::class,'profile'])->name('profile');
Route::post('/profile',[AdminController::class,'profile_update'])->name('profile_update');

//Suppliers
Route::get('/suppliers/trashed',[SupplierController::class,'trashed_list'])->middleware('permission:supplier_manage')->name('suppliers.trashed');
Route::get('/suppliers/trashed/{supplier}/restore',[SupplierController::class,'restore'])->middleware('permission:supplier_manage')->name('suppliers.restore');
Route::get('/suppliers/trashed/{supplier}/delete',[SupplierController::class,'force_delete'])->middleware('permission:supplier_manage')->name('suppliers.force_delete');
Route::resource('/suppliers',SupplierController::class)->middleware('permission:supplier_manage');

//Cattle Type
Route::get('/cattle-types/trashed',[CattleTypeController::class,'trashed_list'])->middleware('permission:cattle_type_manage')->name('cattle-types.trashed');
Route::get('/cattle-types/trashed/{cattle_type}/restore',[CattleTypeController::class,'restore'])->middleware('permission:cattle_type_manage')->name('cattle-types.restore');
Route::get('/cattle-types/trashed/{cattle_type}/delete',[CattleTypeController::class,'force_delete'])->middleware('permission:cattle_type_manage')->name('cattle-types.force_delete');
Route::resource('/cattle-types',CattleTypeController::class)->middleware('permission:cattle_type_manage');

//Session year
Route::get('/session-years/trashed',[SessionYearController::class,'trashed_list'])->middleware('permission:session_year_manage')->name('session-years.trashed');
Route::get('/session-years/trashed/{session_year}/restore',[SessionYearController::class,'restore'])->middleware('permission:session_year_manage')->name('session-years.restore');
Route::get('/session-years/trashed/{session_year}/delete',[SessionYearController::class,'force_delete'])->middleware('permission:session_year_manage')->name('session-years.force_delete');
Route::resource('/session-years',SessionYearController::class)->middleware('permission:session_year_manage');

//Batch
Route::get('/batches/trashed',[BatchController::class,'trashed_list'])->middleware('permission:batch_manage')->name('batches.trashed');
Route::get('/batches/trashed/{batch}/restore',[BatchController::class,'restore'])->middleware('permission:batch_manage')->name('batches.restore');
Route::get('/batches/trashed/{batch}/delete',[BatchController::class,'force_delete'])->middleware('permission:batch_manage')->name('batches.force_delete');
Route::resource('/batches',BatchController::class)->middleware('permission:batch_manage');

//Breed
Route::get('/breeds/trashed',[BreedsController::class,'trashed_list'])->middleware('permission:breed_manage')->name('breeds.trashed');
Route::get('/breeds/trashed/{breed}/restore',[BreedsController::class,'restore'])->middleware('permission:breed_manage')->name('breeds.restore');
Route::get('/breeds/trashed/{breed}/delete',[BreedsController::class,'force_delete'])->middleware('permission:breed_manage')->name('breeds.force_delete');
Route::resource('/breeds',BreedsController::class)->middleware('permission:breed_manage');

//Farm
Route::get('/farms/trashed',[FarmController::class,'trashed_list'])->middleware('permission:farm_manage')->name('farms.trashed');
Route::get('/farms/trashed/{farm}/restore',[FarmController::class,'restore'])->middleware('permission:farm_manage')->name('farms.restore');
Route::get('/farms/trashed/{farm}/delete',[FarmController::class,'force_delete'])->middleware('permission:farm_manage')->name('farms.force_delete');
Route::resource('/farms',FarmController::class)->middleware('permission:farm_manage');
