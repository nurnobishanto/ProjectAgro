<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::prefix('command')->middleware( ['admin', 'web'])->group(function (){

    Route::get('/clear-cache', function (){
        App::setLocale(session('locale'));
        Artisan::call('cache:clear');
        toastr()->info(__('notification.cache_cleared'),__('notification.cache_cleared'));
        return redirect()->back();
    });
    Route::get('/clear-config', function (){
        App::setLocale(session('locale'));
        Artisan::call('config:clear');
        toastr()->success(Artisan::output(), __('notification.config_cleared'));
        return redirect()->back();
    });
    Route::get('/clear-route', function (){
        App::setLocale(session('locale'));
        Artisan::call('route:clear');
        toastr()->success(Artisan::output(), __('notification.route_cleared'));
        return redirect()->back();
    });
    Route::get('/optimize', function (){
        App::setLocale(session('locale'));
        Artisan::call('optimize:clear');
        toastr()->success(Artisan::output(), __('notification.optimized'));
        return redirect()->back();
    });
    Route::get('/migrate', function (){
        App::setLocale(session('locale'));
        Artisan::call('migrate');
        toastr()->success(Artisan::output(), __('notification.migrated'));
        return redirect()->back();
    });
    Route::get('/migrate-fresh', function (){
        App::setLocale(session('locale'));
        Artisan::call('migrate:fresh');
        toastr()->success(Artisan::output(), __('notification.fresh_migrated'));
        return redirect()->back();
    });
    Route::get('/migrate-fresh-seed', function (){
        App::setLocale(session('locale'));
        Artisan::call('migrate:fresh --seed');
        toastr()->success(Artisan::output(), __('notification.fresh_migrated_seed'));
        return redirect()->back();
    });
    Route::get('/seed', function (){
        App::setLocale(session('locale'));
        $seeder = new \Database\Seeders\RoleSeeder();
        $seeder->run();
        toastr()->info('Seed done');
        return redirect()->route('admin.dashboard');
    });
    Route::get('lang/{locale?}', function ($locale) {
        App::setLocale($locale);
        \app()->setLocale($locale);
        session()->put('locale', $locale);
        toastr()->success(__('notification.language').__('notification.changed_success'),__('notification.language').__('notification.changed'));
        return redirect()->back();
    });
});
