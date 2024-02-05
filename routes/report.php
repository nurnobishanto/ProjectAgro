<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/milk')->group(function () {
    Route::get('/', [\App\Http\Controllers\Report\MilkReportController::class,'index'])->name('milk');
    Route::get('/production', [\App\Http\Controllers\Report\MilkReportController::class,'production'])->name('milk.production');
    Route::get('/sale', [\App\Http\Controllers\Report\MilkReportController::class,'sale'])->name('milk.sale');
    Route::get('/waste', [\App\Http\Controllers\Report\MilkReportController::class,'waste'])->name('milk.waste');
});

Route::prefix('/cattle')->group(function () {
    Route::get('/expense-report', [\App\Http\Controllers\Report\CattleReportController::class,'expense_report'])->name('cattle.expense_report');
    Route::get('/sale-report', [\App\Http\Controllers\Report\CattleReportController::class,'sale_report'])->name('cattle.sale_report');
    Route::get('/bulk-sale-report', [\App\Http\Controllers\Report\CattleReportController::class,'bulk_sale_report'])->name('cattle.bulk_sale_report');
});
Route::prefix('/account')->group(function () {
    Route::get('/assets', [\App\Http\Controllers\Report\AccountReportController::class,'assets'])->name('account.assets');
    Route::get('/accounts', [\App\Http\Controllers\Report\AccountReportController::class,'accounts'])->name('account.accounts');
    Route::get('/opening-balances', [\App\Http\Controllers\Report\AccountReportController::class,'opening_balances'])->name('account.opening_balances');
    Route::get('/balance-transfers', [\App\Http\Controllers\Report\AccountReportController::class,'balance_transfers'])->name('account.balance_transfers');
    Route::get('/expenses', [\App\Http\Controllers\Report\AccountReportController::class,'expenses'])->name('account.expenses');
    Route::get('/staff-salary', [\App\Http\Controllers\Report\AccountReportController::class,'staff_salary'])->name('account.staff_salary');

    Route::get('/party-receive', [\App\Http\Controllers\Report\AccountReportController::class,'party_receive'])->name('account.party_receive');
    Route::get('/supplier-payment', [\App\Http\Controllers\Report\AccountReportController::class,'supplier_payment'])->name('account.supplier_payment');

});
