<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\DispositionController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('planner')
    ->name('planner.')
    ->group(function () {
        Route::resource('flights', PlannerController::class);
    });

Route::prefix('disposition')
    ->name('disposition.')
    ->group(function () {
        Route::resource('flights', DispositionController::class);
    });