<?php

namespace App\Http\Controllers\Ops;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Services\FlightService;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function __construct(
        private FlightService $flightService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::all();
        $this->flightService->enrichFlightsWithCrewInfo($flights);
        
        return view('ops.flights.index', compact('flights'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $flight->load(['departureAirport', 'arrivalAirport', 'aircraft', 'crew']);
        return view('ops.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $flight->load(['departureAirport', 'arrivalAirport', 'aircraft', 'crew']);
        return view('ops.flights.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        // Implementation needed
        return redirect()
            ->route('ops.flights.index')
            ->with('success', 'Flight updated successfully.');
    }
}
