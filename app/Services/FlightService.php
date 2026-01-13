<?php

namespace App\Services;

use App\Models\Flight;
use App\Models\Airport;
use App\Models\Aircraft;
use Illuminate\Support\Collection;

class FlightService
{
    /**
     * Calculate arrival time based on departure time and enroute hours.
     */
    public function calculateArrivalTime(string $departureTime, float $enrouteHours): string
    {
        $enrouteMinutes = round($enrouteHours * 60);
        return date('Y-m-d H:i:s', strtotime($departureTime . " + {$enrouteMinutes} minutes"));
    }

    /**
     * Find airport by ICAO code.
     */
    public function findAirportByIcao(string $icaoCode): ?Airport
    {
        return Airport::where('icao_code', $icaoCode)->first();
    }

    /**
     * Find aircraft by registration number.
     */
    public function findAircraftByRegistration(string $registrationNumber): ?Aircraft
    {
        return Aircraft::where('registration_number', $registrationNumber)->first();
    }

    /**
     * Enrich flights collection with related data.
     */
    public function enrichFlightsWithRelations($flights): Collection|array
    {
        foreach ($flights as $flight) {
            $flight->aircraft_registration_number = $flight->aircraft?->registration_number ?? 'N/A';
            $flight->departure_airport_icao = $flight->departureAirport?->icao_code ?? 'N/A';
            $flight->arrival_airport_icao = $flight->arrivalAirport?->icao_code ?? 'N/A';
        }
        
        return $flights;
    }

    /**
     * Enrich flights with crew assignment info.
     */
    public function enrichFlightsWithCrewInfo($flights): Collection|array
    {
        foreach ($flights as $flight) {
            $flight->departure_airport_icao = $flight->departureAirport?->icao_code ?? 'N/A';
            $flight->arrival_airport_icao = $flight->arrivalAirport?->icao_code ?? 'N/A';
            $flight->crew_id = $flight->crew?->id ?? 'Unassigned';
        }
        
        return $flights;
    }

    /**
     * Get flights filtered by aircraft if provided.
     */
    public function getFlightsByAircraft(?int $aircraftId = null)
    {
        if ($aircraftId) {
            $aircraft = Aircraft::find($aircraftId);
            return $aircraft ? $aircraft->flights : collect();
        }
        
        return Flight::all();
    }

    /**
     * Create a flight with calculated arrival time.
     */
    public function createFlight(array $data): Flight
    {
        $departureAirport = $this->findAirportByIcao($data['departure_airport_icao']);
        $arrivalAirport = $this->findAirportByIcao($data['arrival_airport_icao']);
        $aircraft = $this->findAircraftByRegistration($data['registration_number']);
        
        return Flight::create([
            'flight_number' => $data['flight_number'],
            'departure_time_scheduled' => $data['departure_time'],
            'arrival_time_scheduled' => $this->calculateArrivalTime($data['departure_time'], $data['enroute_time']),
            'departure_airport_id' => $departureAirport->id,
            'arrival_airport_id' => $arrivalAirport->id,
            'aircraft_id' => $aircraft->id,
        ]);
    }

    /**
     * Update a flight.
     */
    public function updateFlight(Flight $flight, array $data): Flight
    {
        $departureAirport = $this->findAirportByIcao($data['departure_airport_icao']);
        $arrivalAirport = $this->findAirportByIcao($data['arrival_airport_icao']);
        $aircraft = $this->findAircraftByRegistration($data['registration_number']);
        
        $flight->update([
            'flight_number' => $data['flight_number'],
            'departure_time_scheduled' => $data['departure_time'],
            'arrival_time_scheduled' => $data['arrival_time'],
            'departure_airport_id' => $departureAirport->id,
            'arrival_airport_id' => $arrivalAirport->id,
            'aircraft_id' => $aircraft->id,
        ]);
        
        return $flight;
    }
}
