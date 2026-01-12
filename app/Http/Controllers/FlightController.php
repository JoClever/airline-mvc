<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $aircrafts = Aircraft::all();

        $validator = Validator::make($request->all(), [
            'aircraft_id' => 'nullable|exists:aircraft,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $selectedAircraftId = $validator->validated()['aircraft_id'] ?? null;

        $selectedAircraft = Aircraft::find($selectedAircraftId);

        if ($selectedAircraft) {
            $flights = $selectedAircraft->flights;
        } else {
            $flights = Flight::all();
        }

        foreach ($flights as $flight) {
            $flight->aircraft_registration_number = $flight->aircraft ? $flight->aircraft->registration_number : 'N/A';
            $flight->departure_airport_icao = $flight->departureAirport ? $flight->departureAirport->icao_code : 'N/A';
            $flight->arrival_airport_icao = $flight->arrivalAirport ? $flight->arrivalAirport->icao_code : 'N/A';
        }
        
        return view('flights.index', compact('flights', 'aircrafts', 'selectedAircraft'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $selectedAircraftId = request()->query('aircraft_id');
        $selectedAircraft = Aircraft::find($selectedAircraftId);
        return view('flights.create', compact('selectedAircraft'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'flight_number' => 'required|string|max:10',
            'departure_time' => 'required|date',
            'enroute_time' => 'required|decimal:0,2', //hours decimal
            'departure_airport_icao' => 'required|string|size:4',
            'arrival_airport_icao' => 'required|string|size:4',
            'registration_number' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $incomingData = $validator->validated();

        $departureAirport = Airport::where('icao_code', $incomingData['departure_airport_icao'])->first();
        $arrivalAirport = Airport::where('icao_code', $incomingData['arrival_airport_icao'])->first();
        $aircraft = Aircraft::where('registration_number', $incomingData['registration_number'])->first();
        $enrouteTimeMinutes = round($incomingData['enroute_time'] * 60);
        $arrivalTime = date('Y-m-d H:i:s', strtotime($incomingData['departure_time'] . " + " . ($enrouteTimeMinutes) . " minutes"));

        $flight = Flight::create([
            'flight_number' => $incomingData['flight_number'],
            'departure_time_scheduled' => $incomingData['departure_time'],
            'arrival_time_scheduled' => $arrivalTime,
            'departure_airport_id' => $departureAirport->id,
            'arrival_airport_id' => $arrivalAirport->id,
            'aircraft_id' => $aircraft->id,
        ]);

        return redirect()->route('flights.index')->with('success', 'Flight created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $flight->load('aircraft', 'departureAirport', 'arrivalAirport', 'diversionAirport', 'crew', 'transferCrews');
        return view('flights.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        $validator = Validator::make($request->all(), [
            'flight_number' => 'required|string|max:10',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'departure_airport_icao' => 'required|string|size:4',
            'arrival_airport_icao' => 'required|string|size:4',
            'registration_number' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $incomingData = $validator->validated();

        $departureAirport = Airport::where('icao_code', $incomingData['departure_airport_icao'])->first();
        $arrivalAirport = Airport::where('icao_code', $incomingData['arrival_airport_icao'])->first();
        $aircraft = Aircraft::where('registration_number', $incomingData['registration_number'])->first();

        $flight->update([
            'flight_number' => $incomingData['flight_number'],
            'departure_time_scheduled' => $incomingData['departure_time'],
            'arrival_time_scheduled' => $incomingData['arrival_time'],
            'departure_airport_id' => $departureAirport->id,
            'arrival_airport_id' => $arrivalAirport->id,
            'aircraft_id' => $aircraft->id,
        ]);

        return redirect()->route('flights.index')->with('success', 'Flight updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('flights.index')->with('success', 'Flight deleted successfully.');
    }
}
