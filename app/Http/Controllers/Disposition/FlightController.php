<?php

namespace App\Http\Controllers\Disposition;

use App\Models\Crew;
use App\Models\Flight;
use App\Models\Airport;
use App\Services\FlightService;
use App\Services\CrewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterFlightsRequest;
use App\Http\Requests\UpdateDispositionFlightRequest;

class FlightController extends Controller
{
    public function __construct(
        private FlightService $flightService,
        private CrewService $crewService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterFlightsRequest $request)
    {
        $airports = Airport::all();
        $crews = Crew::all();

        $validated = $request->validated();
        $flights = $this->flightService->getFlightsFiltered(filter: $validated);
        
        // Check for crew routing, timing, and limit issues
        $issues = $this->crewService->checkCrewIssues();
        
        return view('disposition.flights.index', compact(
            'flights',
            'airports',
            'crews',
            'issues',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $this->flightService->enrichFlightWithDate($flight);

        $flight->load([
            'departureAirport',
            'arrivalAirport',
            'aircraft',
            'crew',
            'crewTransfers',
        ]);

        return view('disposition.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $airports = Airport::all();
        $crews = Crew::all();

        $this->flightService->enrichFlightWithDate($flight);

        $flight->load([
            'departureAirport',
            'arrivalAirport',
            'aircraft',
            'crew'
        ]);

        return view('disposition.flights.edit', compact(
            'flight',
            'airports',
            'crews',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDispositionFlightRequest $request, Flight $flight)
    {
        $this->flightService->updateFlightDisposition($flight, $request->validated());

        return redirect()
            ->route('disposition.flights.index')
            ->with('success', 'Flight updated successfully.');
    }
}
