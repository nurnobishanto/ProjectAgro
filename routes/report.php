<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/milk')->group(function () {
    Route::get('/', [\App\Http\Controllers\Report\MilkReportController::class,'index'])->name('milk');
    Route::get('/production', [\App\Http\Controllers\Report\MilkReportController::class,'production'])->name('milk.production');
    Route::get('/sale', [\App\Http\Controllers\Report\MilkReportController::class,'sale'])->name('milk.sale');
    Route::get('/waste', [\App\Http\Controllers\Report\MilkReportController::class,'waste'])->name('milk.waste');
});


