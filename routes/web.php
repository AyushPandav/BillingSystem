<?php

use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
Route::post('/billing/save', [BillingController::class, 'save'])->name('billing.save');
Route::get('/bills', [BillingController::class, 'history'])->name('billing.history');
