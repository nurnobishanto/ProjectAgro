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

    return view('welcome');
});

Route::get('cattle-types',[\App\Http\Controllers\AjaxCartController::class,'cattle_types'])->name('cattle_types');
Route::get('cattle-type',[\App\Http\Controllers\AjaxCartController::class,'cattle_type'])->name('cattle_type');
Route::get('cattle-breed',[\App\Http\Controllers\AjaxCartController::class,'cattle_breed'])->name('cattle_breed');
Route::get('category',[\App\Http\Controllers\AjaxCartController::class,'category'])->name('category');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
require __DIR__.'/command.php';






