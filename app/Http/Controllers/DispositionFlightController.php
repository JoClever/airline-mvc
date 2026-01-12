<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class DispositionFlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::all();

        foreach ($flights as $flight) {
            $flight->departure_airport_icao = $flight->departureAirport ? $flight->departureAirport->icao_code : 'N/A';
            $flight->arrival_airport_icao = $flight->arrivalAirport ? $flight->arrivalAirport->icao_code : 'N/A';
            $flight->crew_id = $flight->crew ? $flight->crew->id : 'Unassigned';
        }
        
        return view('flights.disposition.index', compact('flights'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $flight->load(['departureAirport', 'arrivalAirport', 'aircraft', 'crew']);
        return view('flights.disposition.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        //
    }
}
