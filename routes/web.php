<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Planner\FlightController as PlannerFlightController;
use App\Http\Controllers\Disposition\FlightController as DispositionFlightController;
use App\Http\Controllers\Disposition\CrewController as DispositionCrewController;
use App\Http\Controllers\Ops\FlightController as OpsFlightController;
use App\Http\Controllers\Ops\CrewController as OpsCrewController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('planner')
    ->name('planner.')
    ->group(function () {
        Route::get('/flights/create/{aircraft}', [PlannerFlightController::class, 'createForAircraft'])->name('flights.create.forAircraft');
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
        Route::resource('flights', OpsFlightController::class)->only(['index', 'show', 'update', 'edit']);
        Route::resource('crews', OpsCrewController::class)->only(['index', 'show']);
    });