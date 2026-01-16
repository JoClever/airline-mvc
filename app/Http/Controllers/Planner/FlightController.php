<?php

namespace App\Http\Controllers\Planner;

use App\Models\Crew;
use App\Models\Flight;
use App\Models\Airport;
use App\Models\Aircraft;
use App\Services\FlightService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterFlightsRequest;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdatePlannerFlightRequest;

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
        $aircrafts = Aircraft::all();
        $airports = Airport::all();

        $validated = $request->validated();
        $flights = $this->flightService->getFlightsFiltered(filter: $validated);
        
        return view('planner.flights.index', compact(
            'flights',
            'aircrafts',
            'airports',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aircrafts = Aircraft::all();
        $airports = Airport::all();

        // If an aircraft_id is provided in the query string, load that aircraft
        $aircraft = (request()->has('aircraft_id')) ? Aircraft::find(request()->query('aircraft_id')) : null;
        
        return view('planner.flights.create', compact(
            'aircrafts',
            'airports',
            'aircraft',
        ));
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
        $this->flightService->enrichFlightWithDate($flight);

        $flight->load([
            'aircraft',
            'departureAirport',
            'arrivalAirport',
        ]);
        
        return view('planner.flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $aircrafts = Aircraft::all();
        $airports = Airport::all();

        $this->flightService->enrichFlightWithDate($flight);

        $flight->load([
            'aircraft', 
            'departureAirport', 
            'arrivalAirport'
        ]);
        
        return view('planner.flights.edit', compact(
            'flight',
            'aircrafts',
            'airports',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlannerFlightRequest $request, Flight $flight)
    {
        $this->flightService->updateFlightPlanner($flight, $request->validated());
        
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
