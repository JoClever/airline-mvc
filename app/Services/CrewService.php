<?php

namespace App\Services;

use App\Models\Crew;
use Illuminate\Support\Collection;

class CrewService
{
    public function countHours(Collection $flights): int
    {
        $totalDuration = 0; // in seconds

        foreach ($flights as $flight) {
            $departure = strtotime($flight->departure_time_scheduled); // Convert to timestamp
            $arrival = strtotime($flight->arrival_time_scheduled); // Convert to timestamp

            if ($departure && $arrival) {
                $duration = ($arrival - $departure);
                $totalDuration += $duration;
            }
        }

        return intdiv($totalDuration, 3600); // Convert seconds to hours
        
    }

    /**
     * Enrich crews with flight statistics.
     */
    public function enrichCrewWithFlightStats(
        Crew $crew,
        $day,
        $flightsDayLimit = null,
        $flightsMonthLimit = null,
        $flightHoursDayLimit = null,
        $flightHoursMonthLimit = null
    ): Crew
    {
        $flightsDayLimit ??= (int) env('CREW_MAX_FLIGHTS_DAY') ?? 4;
        $flightsMonthLimit ??= (int) env('CREW_MAX_FLIGHTS_MONTH') ?? 20;
        $flightHoursDayLimit ??= (int) env('CREW_MAX_FLIGHT_HOURS_DAY') ?? 8;
        $flightHoursMonthLimit ??= (int) env('CREW_MAX_FLIGHT_HOURS_MONTH') ?? 60;

        $crew->flights_day = $crew->flights()
            ->whereDate('departure_time_scheduled', $day->toDateString())
            ->get();
        
        $crew->flights_month = $crew->flights()
            ->whereMonth('departure_time_scheduled', $day->month)
            ->whereYear('departure_time_scheduled', $day->year)
            ->get();
        
        $crew->flights_day_count = $crew->flights_day->count();
        $crew->flights_month_count = $crew->flights_month->count();

        $crew->flights_day_limit = $crew->flights_day_count > $flightsDayLimit;
        $crew->flights_month_limit = $crew->flights_month_count > $flightsMonthLimit;

        $crew->hours_day = $this->countHours($crew->flights_day);
        $crew->hours_month = $this->countHours($crew->flights_month);

        $crew->hours_day_limit = $crew->hours_day > $flightHoursDayLimit;
        $crew->hours_month_limit = $crew->hours_month > $flightHoursMonthLimit;
        
        return $crew;
    }

    /**
     * Enrich crews with flight statistics.
     */
    public function enrichCrewsWithFlightStats(
        Collection $crews,
        $day,
        $flightsDayLimit = null,
        $flightsMonthLimit = null,
        $flightHoursDayLimit = null,
        $flightHoursMonthLimit = null
    ): Collection
    {
        return $crews->map(fn (Crew $crew) => $this->enrichCrewWithFlightStats(
            $crew,
            $day,
            $flightsDayLimit,
            $flightsMonthLimit,
            $flightHoursDayLimit,
            $flightHoursMonthLimit
        ));
    }

    /**
     * Get crew with relations loaded.
     */
    public function getCrewWithRelations(Crew $crew, array $relations = []): Crew
    {
        return $crew->load($relations);
    }

    /**
     * Get warning messages for crew that exceeded limits.
     */
    public function getCrewLimitWarnings(Crew $crew): array
    {
        $warnings = [];
        
        if ($crew->flights_day_limit) {
            $warnings[] = 'This crew has exceeded the flights per day limit.';
        }
        if ($crew->flights_month_limit) {
            $warnings[] = 'This crew has exceeded the flights per month limit.';
        }
        if ($crew->hours_day_limit) {
            $warnings[] = 'This crew has exceeded the flight hours per day limit.';
        }
        if ($crew->hours_month_limit) {
            $warnings[] = 'This crew has exceeded the flight hours per month limit.';
        }
        
        return $warnings;
    }

    /**
     * Check for crew routing, timing issues, and limit violations.
     * Returns array of issues with type, description, and affected crew/flights.
     */
    public function checkCrewIssues(bool $includeLiveTimes = false, bool $includeDiversions = false): array
    {
        $issues = [];
        $crews = Crew::all();

        // Limits for checking
        $flightsDayLimit = (int) config('custom.crew_max_flights_day') ?? 4;
        $flightsMonthLimit = (int) config('custom.crew_max_flights_month') ?? 20;
        $flightHoursDayLimit = (int) config('custom.crew_max_flight_hours_day') ?? 8;
        $flightHoursMonthLimit = (int) config('custom.crew_max_flight_hours_month') ?? 60;

        foreach ($crews as $crew) {
            // Get all flights for this crew: both assigned flights and transfer flights
            $assignedFlights = $crew->flights()
                ->orderBy('departure_time_scheduled')
                ->with(['departureAirport', 'arrivalAirport'])
                ->get();
            
            $transferFlights = $crew->transferFlights()
                ->orderBy('departure_time_scheduled')
                ->with(['departureAirport', 'arrivalAirport'])
                ->get();

            // Merge and sort all flights by departure time
            $allFlights = $assignedFlights->merge($transferFlights)
                ->sortBy('departure_time_scheduled')
                ->values();

            if ($allFlights->count() < 2) {
                // Still check limit violations
                $this->checkCrewLimitViolations($crew, $allFlights, $issues, $flightsDayLimit, $flightsMonthLimit, $flightHoursDayLimit, $flightHoursMonthLimit);
                continue;
            }

            // Check each consecutive pair of flights for routing and timing issues
            for ($i = 0; $i < $allFlights->count() - 1; $i++) {
                $currentFlight = $allFlights[$i];
                $nextFlight = $allFlights[$i + 1];

                // Check airport consistency (current arrival should match next departure)
                if ($currentFlight->arrival_airport_id !== $nextFlight->departure_airport_id) {
                    $issues[] = [
                        'type' => 'Airport Inconsistency',
                        'description' => "Crew #{$crew->id} arrives at {$currentFlight->arrivalAirport->icao_code} but next flight departs from {$nextFlight->departureAirport->icao_code}",
                        'flight_1' => $currentFlight,
                        'flight_2' => $nextFlight,
                        'crew' => $crew,
                        'severity' => 'error',
                    ];
                }

                // Check diversion consistency if required
                if ($includeDiversions && $currentFlight->diversion_airport_id && $currentFlight->diversion_airport_id !== $nextFlight->departure_airport_id) {
                    $issues[] = [
                        'type' => 'Diversion Inconsistency',
                        'description' => "Crew #{$crew->id} diverts to {$currentFlight->diversion_airport_id} but next flight departs from {$nextFlight->departureAirport->icao_code}",
                        'flight_1' => $currentFlight,
                        'flight_2' => $nextFlight,
                        'crew' => $crew,
                        'severity' => 'error',
                    ];
                }

                // Check time collision (next departure should be after current arrival)
                $currentArrival = strtotime($currentFlight->arrival_time_scheduled);
                $nextDeparture = strtotime($nextFlight->departure_time_scheduled);

                if ($nextDeparture <= $currentArrival) {
                    $issues[] = [
                        'type' => 'Time Collision (Scheduled)',
                        'description' => "Crew #{$crew->id} lands at " . date('H:i', $currentArrival) . " but next flight departs at " . date('H:i', $nextDeparture),
                        'flight_1' => $currentFlight,
                        'flight_2' => $nextFlight,
                        'crew' => $crew,
                        'severity' => 'error',
                    ];
                }

                if ($includeLiveTimes) {
                    // Check estimated time collision
                    if ($currentFlight->arrival_time_estimated && $nextFlight->departure_time_estimated) {
                        $currentETA = strtotime($currentFlight->arrival_time_estimated);
                        $nextETD = strtotime($nextFlight->departure_time_estimated);

                        if ($nextETD <= $currentETA) {
                            $issues[] = [
                                'type' => 'Time Collision (Estimated)',
                                'description' => "Crew #{$crew->id} estimated to land at " . date('H:i', $currentETA) . " but next flight estimated to depart at " . date('H:i', $nextETD),
                                'flight_1' => $currentFlight,
                                'flight_2' => $nextFlight,
                                'crew' => $crew,
                                'severity' => 'warning',
                            ];
                        }
                    }

                    // Check actual time collision
                    if ($currentFlight->arrival_time_actual && $nextFlight->departure_time_actual) {
                        $currentATA = strtotime($currentFlight->arrival_time_actual);
                        $nextATD = strtotime($nextFlight->departure_time_actual);

                        if ($nextATD <= $currentATA) {
                            $issues[] = [
                                'type' => 'Time Collision (Actual)',
                                'description' => "Crew #{$crew->id} actually landed at " . date('H:i', $currentATA) . " but next flight departed at " . date('H:i', $nextATD),
                                'flight_1' => $currentFlight,
                                'flight_2' => $nextFlight,
                                'crew' => $crew,
                                'severity' => 'error',
                            ];
                        }
                    }
                }
            }

            // Check crew limit violations
            $this->checkCrewLimitViolations($crew, $allFlights, $issues, $flightsDayLimit, $flightsMonthLimit, $flightHoursDayLimit, $flightHoursMonthLimit);
        }

        return $issues;
    }

    /**
     * Check crew limit violations for flights per day/month and hours per day/month.
     */
    private function checkCrewLimitViolations(Crew $crew, Collection $allFlights, array &$issues, int $flightsDayLimit, int $flightsMonthLimit, int $flightHoursDayLimit, int $flightHoursMonthLimit): void
    {
        // Group flights by day and month
        $flightsByDay = $allFlights->groupBy(function($flight) {
            return date('Y-m-d', strtotime($flight->departure_time_scheduled));
        });

        $flightsByMonth = $allFlights->groupBy(function($flight) {
            return date('Y-m', strtotime($flight->departure_time_scheduled));
        });

        // Check daily flight count limit
        foreach ($flightsByDay as $day => $dayFlights) {
            if ($dayFlights->count() > $flightsDayLimit) {
                $issues[] = [
                    'type' => 'Daily Flight Limit',
                    'description' => "Crew #{$crew->id} exceeds daily flight limit on {$day} with {$dayFlights->count()} flights (limit: {$flightsDayLimit})",
                    'crew' => $crew,
                    'severity' => 'warning',
                ];
            }
        }

        // Check daily flight hours limit
        foreach ($flightsByDay as $day => $dayFlights) {
            $hours = $this->countHours($dayFlights);
            if ($hours > $flightHoursDayLimit) {
                $issues[] = [
                    'type' => 'Daily Hours Limit',
                    'description' => "Crew #{$crew->id} exceeds daily flight hours on {$day} with {$hours}h (limit: {$flightHoursDayLimit}h)",
                    'crew' => $crew,
                    'severity' => 'warning',
                ];
            }
        }

        // Check monthly flight count limit
        foreach ($flightsByMonth as $month => $monthFlights) {
            if ($monthFlights->count() > $flightsMonthLimit) {
                $issues[] = [
                    'type' => 'Monthly Flight Limit',
                    'description' => "Crew #{$crew->id} exceeds monthly flight limit in {$month} with {$monthFlights->count()} flights (limit: {$flightsMonthLimit})",
                    'crew' => $crew,
                    'severity' => 'warning',
                ];
            }
        }

        // Check monthly flight hours limit
        foreach ($flightsByMonth as $month => $monthFlights) {
            $hours = $this->countHours($monthFlights);
            if ($hours > $flightHoursMonthLimit) {
                $issues[] = [
                    'type' => 'Monthly Hours Limit',
                    'description' => "Crew #{$crew->id} exceeds monthly flight hours in {$month} with {$hours}h (limit: {$flightHoursMonthLimit}h)",
                    'crew' => $crew,
                    'severity' => 'warning',
                ];
            }
        }
    }
}
