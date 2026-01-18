<?php

namespace App\Http\Controllers\Ops;

use App\Models\Crew;
use App\Models\Flight;
use App\Models\Airport;
use App\Models\Aircraft;
use App\Services\FlightService;
use App\Services\CrewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterFlightsRequest;
use App\Http\Requests\UpdateOpsFlightRequest;

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
        $aircrafts = Aircraft::all();
        $airports = Airport::all();
        $crews = Crew::all();

        $validated = $request->validated();
        $flights = $this->flightService->getFlightsFiltered(filter: $validated);
        $flights = $this->flightService->enrichFlightsWithStatus($flights);
        
        // Check for aircraft and crew routing, timing, and limit issues
        $aircraftIssues = $this->flightService->checkAircraftIssues(includeLiveTimes: true, includeDiversions: true);
        $crewIssues = $this->crewService->checkCrewIssues(includeLiveTimes: true, includeDiversions: true);
        $issues = array_merge($aircraftIssues, $crewIssues);
        
        return view('ops.flights.index', compact(
            'flights',
            'aircrafts',
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

        return view('ops.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $aircrafts = Aircraft::all();
        $airports = Airport::all();
        $crews = Crew::all();

        $this->flightService->enrichFlightWithDate($flight);

        $flight->load([
            'departureAirport',
            'arrivalAirport',
            'aircraft',
            'crew'
        ]);

        return view('ops.flights.edit', compact(
            'flight',
            'aircrafts',
            'airports',
            'crews',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOpsFlightRequest $request, Flight $flight)
    {
        $this->flightService->updateFlightOps($flight, $request->validated());

        return redirect()
            ->route('ops.flights.show', $flight)
            ->with('success', 'Flight updated successfully.' . $request->diversion_airport_id);
    }
}
