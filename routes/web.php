<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlannerFlightController;
use App\Http\Controllers\DispositionCrewController;
use App\Http\Controllers\DispositionFlightController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('planner')
    ->name('planner.')
    ->group(function () {
        Route::resource('flights', PlannerFlightController::class);
    });

Route::prefix('disposition')
    ->name('disposition.')
    ->group(function () {
        Route::resource('flights', DispositionFlightController::class)->only(['index', 'show', 'update', 'edit']);
        Route::resource('crews', DispositionCrewController::class)->only(['index', 'show']);
    });

Route::prefix('ops')
    ->name('ops.')
    ->group(function () {
        Route::resource('flights', DispositionFlightController::class)->only(['index', 'show', 'update', 'edit']);
        Route::resource('crews', DispositionCrewController::class)->only(['index', 'show']);
    });