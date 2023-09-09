<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::prefix('command')->group(function (){

    Route::get('/clear-cache', function (){
        Artisan::call('cache:clear');
       // toastr()->success(Artisan::output(), 'Cache Cleared');
        return redirect()->back();
    });
    Route::get('/clear-config', function (){
        Artisan::call('config:clear');
        //toastr()->success(Artisan::output(), 'Cache Cleared');
        return redirect()->back();
    });
    Route::get('/clear-route', function (){
        Artisan::call('route:clear');
        //toastr()->success(Artisan::output(), 'Route Cleared');
        return redirect()->back();
    });
    Route::get('/optimize', function (){
        Artisan::call('optimize:clear');
        //toastr()->success(Artisan::output(), 'Optimized');
        return redirect()->back();
    });
    Route::get('/migrate', function (){
        Artisan::call('migrate');
        //toastr()->success(Artisan::output(), 'Migrated');
        return redirect()->back();
    });
    Route::get('/migrate-fresh', function (){
        Artisan::call('migrate:fresh');
        //toastr()->success(Artisan::output(), 'Fresh Migrated');
        return redirect()->back();
    });
    Route::get('/migrate-fresh-seed', function (){
        Artisan::call('migrate:fresh --seed');
        //toastr()->success(Artisan::output(), 'Fresh Migrated with seed');
        return redirect()->back();
    });
});
