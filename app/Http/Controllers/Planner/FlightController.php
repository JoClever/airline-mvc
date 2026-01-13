<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Aircraft;
use App\Services\FlightService;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Http\Requests\FilterFlightsByAircraftRequest;

class FlightController extends Controller
{
    public function __construct(
        private FlightService $flightService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterFlightsByAircraftRequest $request)
    {
        $aircrafts = Aircraft::all();
        $selectedAircraft = Aircraft::find($request->validated()['aircraft_id'] ?? null);
        
        $flights = $this->flightService->getFlightsByAircraft($selectedAircraft?->id);
        $this->flightService->enrichFlightsWithRelations($flights);
        
        return view('planner.flights.index', compact('flights', 'aircrafts', 'selectedAircraft'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planner.flights.create');
    }

    public function createForAircraft(Aircraft $aircraft)
    {
        return view('planner.flights.create', compact('aircraft'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightRequest $request)
    {
        $this->flightService->createFlight($request->validated());
        
        return redirect()
            ->route('planner.flights.index')
            ->with('success', 'Flight created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $flight->load([
            'aircraft', 
            'departureAirport', 
            'arrivalAirport'
        ]);
        
        return view('planner.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $flight->load([
            'aircraft', 
            'departureAirport', 
            'arrivalAirport'
        ]);
        
        return view('planner.flights.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlightRequest $request, Flight $flight)
    {
        $this->flightService->updateFlight($flight, $request->validated());
        
        return redirect()
            ->route('planner.flights.index')
            ->with('success', 'Flight updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        
        return redirect()
            ->route('planner.flights.index')
            ->with('success', 'Flight deleted successfully.');
    }
}
