<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::controller(DataController::class)->group(function () {
    Route::get('/', 'welcome');
    Route::post('addData', 'addData')->name('add@Data');
});
