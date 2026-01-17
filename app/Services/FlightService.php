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
     * Enrich a single flight with formatted date.
     */
    public function enrichFlightWithDate(Flight $flight): Flight
    {
        $flight->formatted_title = $flight->flight_number . '-' . date('Ymd', strtotime($flight->departure_time_scheduled));
        $flight->formatted_departure_date = date('Y-m-d', strtotime($flight->departure_time_scheduled));
        $flight->formatted_arrival_date = date('Y-m-d', strtotime($flight->arrival_time_scheduled));

        return $flight;
    }

    /**
    * Enrich a single flight with status.
    */
    public function enrichFlightWithStatus(Flight $flight): Flight
    {
        $now = now();

        if ($flight->status === 'Cancelled') {
            // Keep cancelled status
        } elseif ($flight->arrival_time_actual) {
            $flight->status = 'Landed';
        } elseif ($flight->diversionAirport()->exists()) {
            $flight->status = 'Diverted';
        } elseif ($flight->departure_time_actual) {
            $flight->status = 'Departed';
        } elseif (strtotime($flight->departure_time_estimated) >= strtotime($flight->departure_time_scheduled) + 15 * 60) { // 15 minutes delay
            $flight->status = 'Delayed';
        } else {
            $flight->status = 'Scheduled';
        }

        return $flight;
    }

    /**
     * Enrich multiple flights with status.
     */
    public function enrichFlightsWithStatus(Collection $flights): Collection|array
    {
        return $flights->map(fn($flight) => $this->enrichFlightWithStatus($flight));
    }

    /**
     * Get flights filtered by flight number, aircraft, crew, date, month, departure airport, and arrival airport.
     */
    public function getFlightsFiltered(?array $filter): Collection
    {
        $query = Flight::query();

        if ($filter['flight_number'] ?? null)             $query->where('flight_number', 'like', '%' . $filter['flight_number'] . '%');
        if ($filter['no_aircraft'] ?? null)               $query->whereNull('aircraft_id');
        elseif ($filter['aircraft_id'] ?? null)           $query->where('aircraft_id', $filter['aircraft_id']);
        if ($filter['no_crew'] ?? null)                   $query->whereNull('crew_id');
        elseif ($filter['crew_id'] ?? null)               $query->where('crew_id', $filter['crew_id']);     
        if ($filter['departure_time_scheduled'] ?? null)  $query->whereDate('departure_time_scheduled', $filter['departure_time_scheduled']);
        if ($filter['day'] ?? null)                       $query->whereDate('departure_time_scheduled', $filter['day']);
        if ($filter['month'] ?? null)                     $query->whereDate('departure_time_scheduled', 'like', $filter['month'] . '%');
        if ($filter['departure_airport_id'] ?? null)      $query->where('departure_airport_id', $filter['departure_airport_id']);
        if ($filter['arrival_airport_id'] ?? null)        $query->where('arrival_airport_id', $filter['arrival_airport_id']);

        return $query->get();
    }

    /**
     * Create a flight with calculated arrival time.
     */
    public function createFlight(array $data): Flight
    {        
        return Flight::create([
            'flight_number' => $data['flight_number'],
            'departure_time_scheduled' => $data['departure_time_scheduled'],
            'arrival_time_scheduled' => $this->calculateArrivalTime($data['departure_time_scheduled'], $data['enroute_time']),
            'departure_airport_id' => $data['departure_airport_id'],
            'arrival_airport_id' => $data['arrival_airport_id'],
            'aircraft_id' => $data['aircraft_id'],
            'crew_id' => $data['crew_id'] ?? null,
        ]);
    }

    /**
     * Update a flight for planner.
     */
    public function updateFlightPlanner(Flight $flight, array $data): Flight
    {        
        $flight->update([
            'flight_number' => $data['flight_number'],
            'departure_time_scheduled' => $data['departure_time_scheduled'],
            'arrival_time_scheduled' => $data['arrival_time_scheduled'],
            'departure_airport_id' => $data['departure_airport_id'],
            'arrival_airport_id' => $data['arrival_airport_id'],
            'aircraft_id' => $data['aircraft_id'],

        ]);
        
        return $flight;
    }

    /**
     * Update a flight for disposition.
     */
    public function updateFlightDisposition(Flight $flight, array $data): Flight
    {        
        $flight->update([
            'crew_id' => $data['crew_id'] ?? null,
        ]);

        $this->syncCrewTransfers($flight, $data['transfer_crew_ids'] ?? []);
        
        return $flight;
    }

    /**
     * Update a flight for ops.
     */
    public function updateFlightOps(Flight $flight, array $data): Flight
    {        
        $flight->update([
            'diversion_airport_id' => $data['diversion_airport_id'] ?? null,
            'departure_time_estimated' => $data['departure_time_estimated'] ?? null,
            'arrival_time_estimated' => $data['arrival_time_estimated'] ?? null,
            'departure_time_actual' => $data['departure_time_actual'] ?? null,
            'arrival_time_actual' => $data['arrival_time_actual'] ?? null,
            'crew_id' => $data['crew_id'] ?? null,
        ]);

        $this->syncCrewTransfers($flight, $data['transfer_crew_ids'] ?? []);
        
        return $flight;
    }

    /**
     * Sync transfer crews for a flight.
     */
    private function syncCrewTransfers(Flight $flight, array $crewIds): void
    {
        $flight->crewTransfers()->sync($crewIds);
    }

    /**
     * Check for aircraft routing and timing issues.
     * Returns array of issues with type, description, and affected flights.
     */
    public function checkAircraftIssues(bool $includeLiveTimes = false): array
    {
        $issues = [];
        $aircrafts = Aircraft::all();

        foreach ($aircrafts as $aircraft) {
            // Get flights for this aircraft ordered by departure time
            $flights = Flight::where('aircraft_id', $aircraft->id)
                ->orderBy('departure_time_scheduled')
                ->with(['departureAirport', 'arrivalAirport'])
                ->get();

            if ($flights->count() < 2) {
                continue; // Need at least 2 flights to check for issues
            }

            // Check each consecutive pair of flights
            for ($i = 0; $i < $flights->count() - 1; $i++) {
                $currentFlight = $flights[$i];
                $nextFlight = $flights[$i + 1];

                // Check airport consistency (current arrival should match next departure)
                if ($currentFlight->arrival_airport_id !== $nextFlight->departure_airport_id) {
                    $issues[] = [
                        'type' => 'Airport Inconsistency',
                        'description' => "Aircraft {$aircraft->registration_number} arrives at {$currentFlight->arrivalAirport->icao_code} but next flight departs from {$nextFlight->departureAirport->icao_code}",
                        'flight_1' => $currentFlight,
                        'flight_2' => $nextFlight,
                        'aircraft' => $aircraft,
                        'severity' => 'error',
                    ];
                }

                // Check time collision (next departure should be after current arrival)
                $currentArrival = strtotime($currentFlight->arrival_time_scheduled);
                $nextDeparture = strtotime($nextFlight->departure_time_scheduled);

                if ($nextDeparture - $currentArrival <= 60 * 60) { // Less than or equal to 60 minutes turnaround  
                    $issues[] = [
                        'type' => 'Time Collision (Scheduled)',
                        'description' => "Aircraft {$aircraft->registration_number} lands at " . date('H:i', $currentArrival) . " but next flight departs at " . date('H:i', $nextDeparture),
                        'flight_1' => $currentFlight,
                        'flight_2' => $nextFlight,
                        'aircraft' => $aircraft,
                        'severity' => 'error',
                    ];
                }

                if ($includeLiveTimes) {
                    // Check estimated time collision
                    if ($currentFlight->arrival_time_estimated && $nextFlight->departure_time_estimated) {
                        $currentETA = strtotime($currentFlight->arrival_time_estimated);
                        $nextETD = strtotime($nextFlight->departure_time_estimated);

                        if ($nextETD - $currentETA <= 60 * 60) {
                            $issues[] = [
                                'type' => 'Time Collision (Estimated)',
                                'description' => "Aircraft {$aircraft->registration_number} estimated to land at " . date('H:i', $currentETA) . " but next flight estimated to depart at " . date('H:i', $nextETD),
                                'flight_1' => $currentFlight,
                                'flight_2' => $nextFlight,
                                'aircraft' => $aircraft,
                                'severity' => 'warning',
                            ];
                        }
                    } elseif ($currentFlight->arrival_time_estimated && $nextFlight->departure_time_scheduled) {
                        $currentETA = strtotime($currentFlight->arrival_time_estimated);
                        $nextETD = strtotime($nextFlight->departure_time_scheduled);

                        if ($nextETD - $currentETA <= 60 * 60) {
                            $issues[] = [
                                'type' => 'Time Collision (Estimated vs Scheduled)',
                                'description' => "Aircraft {$aircraft->registration_number} estimated to land at " . date('H:i', $currentETA) . " but next flight scheduled to depart at " . date('H:i', $nextETD),
                                'flight_1' => $currentFlight,
                                'flight_2' => $nextFlight,
                                'aircraft' => $aircraft,
                                'severity' => 'warning',
                            ];
                        }
                    }

                    // Check actual time collision
                    if ($currentFlight->arrival_time_actual && $nextFlight->departure_time_actual) {
                        $currentATA = strtotime($currentFlight->arrival_time_actual);
                        $nextATD = strtotime($nextFlight->departure_time_actual);

                        if ($nextATD - $currentATA <= 60 * 60) {
                            $issues[] = [
                                'type' => 'Time Collision (Actual)',
                                'description' => "Aircraft {$aircraft->registration_number} actually landed at " . date('H:i', $currentATA) . " but next flight departed at " . date('H:i', $nextATD),
                                'flight_1' => $currentFlight,
                                'flight_2' => $nextFlight,
                                'aircraft' => $aircraft,
                                'severity' => 'error',
                            ];
                        }
                    }
                }
            }
        }

        return $issues;
    }
}