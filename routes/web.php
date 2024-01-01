<?php



use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('website.home');
})->name('website.home');
Route::get('/test', function () {

    return getLineChartForMilkProduction(type: "yearly");
});
Route::prefix('ajax/')->group(function (){
    Route::get('farms',[\App\Http\Controllers\AjaxCartController::class,'farms'])->name('farms');
    Route::get('farm-staff-list',[\App\Http\Controllers\AjaxCartController::class,'farm_staff_list'])->name('farm_staff_list');
    Route::get('cattle-types',[\App\Http\Controllers\AjaxCartController::class,'cattle_types'])->name('cattle_types');
    Route::get('farm-cattle-list',[\App\Http\Controllers\AjaxCartController::class,'farm_cattle_list'])->name('farm_cattle_list');
    Route::get('farm-dairy-cattle-list',[\App\Http\Controllers\AjaxCartController::class,'farm_dairy_cattle_list'])->name('farm_dairy_cattle_list');
    Route::get('farm-medicine-list',[\App\Http\Controllers\AjaxCartController::class,'farm_medicine_list'])->name('farm_medicine_list');
    Route::get('farm-dewormer-list',[\App\Http\Controllers\AjaxCartController::class,'farm_dewormer_list'])->name('farm_dewormer_list');
    Route::get('farm-vaccine-list',[\App\Http\Controllers\AjaxCartController::class,'farm_vaccine_list'])->name('farm_vaccine_list');
    Route::get('cattle-type',[\App\Http\Controllers\AjaxCartController::class,'cattle_type'])->name('cattle_type');
    Route::get('cattle-breed',[\App\Http\Controllers\AjaxCartController::class,'cattle_breed'])->name('cattle_breed');
    Route::get('category',[\App\Http\Controllers\AjaxCartController::class,'category'])->name('category');
    Route::get('get-feeding-farms',[\App\Http\Controllers\AjaxCartController::class,'get_feeding_farms'])->name('get_feeding_farms');
    Route::get('get-feeding-farms-cattle-types',[\App\Http\Controllers\AjaxCartController::class,'get_feeding_farms_cattle_types'])->name('get_feeding_farms_cattle_types');
    Route::get('get-feeding-group-period',[\App\Http\Controllers\AjaxCartController::class,'get_feeding_group_period'])->name('get_feeding_group_period');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
require __DIR__.'/command.php';






