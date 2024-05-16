<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::controller(DataController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store')->name('data.store');
});
