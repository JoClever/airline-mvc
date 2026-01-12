<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\DispositionCrewController;
use App\Http\Controllers\DispositionFlightsController;


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
        Route::resource('flights', DispositionFlightsController::class)->only(['index', 'show', 'update', 'edit']);
        Route::resource('crews', DispositionCrewController::class)->only(['index', 'show']);
    });