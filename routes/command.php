<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::prefix('command')->group(function (){

    Route::get('/clear-cache', function (){
        Artisan::call('cache:clear');
        toastr()->info(Artisan::output(), 'Cache Cleared');
        return redirect()->back();
    });
    Route::get('/clear-config', function (){
        Artisan::call('config:clear');
        toastr()->success(Artisan::output(), 'Cache Cleared');
        return redirect()->back();
    });
    Route::get('/clear-route', function (){
        Artisan::call('route:clear');
        toastr()->success(Artisan::output(), 'Route Cleared');
        return redirect()->back();
    });
    Route::get('/optimize', function (){
        Artisan::call('optimize:clear');
        toastr()->success(Artisan::output(), 'Optimized');
        return redirect()->back();
    });
    Route::get('/migrate', function (){
        Artisan::call('migrate');
        toastr()->success(Artisan::output(), 'Migrated');
        return redirect()->back();
    });
    Route::get('/migrate-fresh', function (){
        Artisan::call('migrate:fresh');
        toastr()->success(Artisan::output(), 'Fresh Migrated');
        return redirect()->back();
    });
    Route::get('/migrate-fresh-seed', function (){
        Artisan::call('migrate:fresh --seed');
        toastr()->success(Artisan::output(), 'Fresh Migrated with seed');
        return redirect()->back();
    });
    Route::get('lang/{locale?}', function ($locale) {
        App::setLocale($locale);
        \app()->setLocale($locale);
        session()->put('locale', $locale);
        toastr()->success('Language Changed',\app()->getLocale(). App::getLocale());
        return redirect()->back();
    });
});
