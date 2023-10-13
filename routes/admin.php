<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BreedsController;
use App\Http\Controllers\Admin\CattleController;
use App\Http\Controllers\Admin\CattleTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\FatteningController;
use App\Http\Controllers\Admin\PartyController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SessionYearController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\UnitController;
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

//Party
Route::get('/parties/trashed',[PartyController::class,'trashed_list'])->middleware('permission:party_manage')->name('parties.trashed');
Route::get('/parties/trashed/{party}/restore',[PartyController::class,'restore'])->middleware('permission:party_manage')->name('parties.restore');
Route::get('/parties/trashed/{party}/delete',[PartyController::class,'force_delete'])->middleware('permission:party_manage')->name('parties.force_delete');
Route::resource('/parties',PartyController::class)->middleware('permission:party_manage');


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

//Cattle Listing
Route::get('/cattles/trashed',[CattleController::class,'trashed_list'])->middleware('permission:cattle_manage')->name('cattles.trashed');
Route::get('/cattles/trashed/{cattle}/restore',[CattleController::class,'restore'])->middleware('permission:cattle_manage')->name('cattles.restore');
Route::get('/cattles/trashed/{cattle}/delete',[CattleController::class,'force_delete'])->middleware('permission:cattle_manage')->name('cattles.force_delete');
Route::resource('/cattles',CattleController::class)->middleware('permission:cattle_manage');

//Unit
Route::get('/units/trashed',[UnitController::class,'trashed_list'])->middleware('permission:unit_manage')->name('units.trashed');
Route::get('/units/trashed/{unit}/restore',[UnitController::class,'restore'])->middleware('permission:unit_manage')->name('units.restore');
Route::get('/units/trashed/{unit}/delete',[UnitController::class,'force_delete'])->middleware('permission:unit_manage')->name('units.force_delete');
Route::resource('/units',UnitController::class)->middleware('permission:unit_manage');

//Product
Route::get('/products/trashed',[ProductController::class,'trashed_list'])->middleware('permission:product_manage')->name('products.trashed');
Route::get('/products/trashed/{product}/restore',[ProductController::class,'restore'])->middleware('permission:product_manage')->name('products.restore');
Route::get('/products/trashed/{product}/delete',[ProductController::class,'force_delete'])->middleware('permission:product_manage')->name('products.force_delete');
Route::resource('/products',ProductController::class)->middleware('permission:product_manage');

//Vat
Route::get('/taxes/trashed',[TaxController::class,'trashed_list'])->middleware('permission:tax_manage')->name('taxes.trashed');
Route::get('/taxes/trashed/{tax}/restore',[TaxController::class,'restore'])->middleware('permission:tax_manage')->name('taxes.restore');
Route::get('/taxes/trashed/{tax}/delete',[TaxController::class,'force_delete'])->middleware('permission:tax_manage')->name('taxes.force_delete');
Route::resource('/taxes',TaxController::class)->middleware('permission:tax_manage');

//Fattening
Route::resource('/fattenings',FatteningController::class)->middleware('permission:fattening_manage');


//Purchase
Route::get('/purchases/trashed',[PurchaseController::class,'trashed_list'])->middleware('permission:purchase_manage')->name('purchases.trashed');
Route::get('/purchases/trashed/{purchase}/restore',[PurchaseController::class,'restore'])->middleware('permission:purchase_manage')->name('purchases.restore');
Route::get('/purchases/trashed/{purchase}/delete',[PurchaseController::class,'force_delete'])->middleware('permission:purchase_manage')->name('purchases.force_delete');
Route::post('/purchases/{purchase}/approve',[PurchaseController::class,'approve'])->middleware('permission:purchase_approve')->name('purchases.approve');
Route::resource('/purchases',PurchaseController::class)->middleware('permission:purchase_manage');
Route::get('/stock',[PurchaseController::class,'stock'])->middleware('permission:stock_manage')->name('stock');
