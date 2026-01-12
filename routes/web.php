<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('planner')
    ->name('planner.')
    ->group(function () {
        Route::resource('flights', FlightController::class);
    });