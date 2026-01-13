<?php

namespace App\Http\Controllers\Disposition;

use App\Models\Flight;
use Illuminate\Http\Request;
use App\Services\FlightService;
use App\Http\Controllers\Controller;
use SebastianBergmann\CodeCoverage\Filter;
use App\Http\Requests\FilterFlightsRequest;

class FlightController extends Controller
{
    public function __construct(
        private FlightService $flightService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterFlightsRequest $request)
    {
        $flights = Flight::all();
        $this->flightService->enrichFlightsWithCrewInfo($flights);
        
        return view('disposition.flights.index', compact('flights'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $flight->load(['departureAirport', 'arrivalAirport', 'aircraft', 'crew']);
        return view('disposition.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $flight->load(['departureAirport', 'arrivalAirport', 'aircraft', 'crew']);
        return view('disposition.flights.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        // Implementation needed
        return redirect()
            ->route('disposition.flights.index')
            ->with('success', 'Flight updated successfully.');
    }
}
