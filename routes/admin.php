<?php


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    App::setLocale(session('locale'));
    return view('dashboard');
})->name('dashboard');
