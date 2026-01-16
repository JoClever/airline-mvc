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
    public function enrichCrewWithFlightStats($crew, $day, $flightsDayLimit, $flightsMonthLimit, $flightHoursDayLimit, $flightHoursMonthLimit): Crew
    {
        $crew->flights_day = $crew->flights()
            ->whereDate('departure_time_scheduled', $day->toDateString())
            ->get();
        
        $crew->flights_month = $crew->flights()
            ->whereMonth('departure_time_scheduled', $day->month)
            ->whereYear('departure_time_scheduled', $day->year)
            ->get();
        
        $crew->flights_day_count = $crew->flights_day->count();
        $crew->flights_month_count = $crew->flights_month->count();

        $crew->flights_day_limit = $crew->flights_day_count >= $flightsDayLimit;
        $crew->flights_month_limit = $crew->flights_month_count >= $flightsMonthLimit;

        $crew->hours_day = $this->countHours($crew->flights_day);
        $crew->hours_month = $this->countHours($crew->flights_month);

        $crew->hours_day_limit = $crew->hours_day >= $flightHoursDayLimit;
        $crew->hours_month_limit = $crew->hours_month >= $flightHoursMonthLimit;
        
        return $crew;
    }

    /**
     * Enrich crews with flight statistics.
     */
    public function enrichCrewsWithFlightStats($crews, $day, $flightsDayLimit, $flightsMonthLimit, $flightHoursDayLimit, $flightHoursMonthLimit): Collection|array
    {
        foreach ($crews as $crew) {
            $this->enrichCrewWithFlightStats(
                crew: $crew,
                day: $day,
                flightsDayLimit: $flightsDayLimit,
                flightsMonthLimit: $flightsMonthLimit,
                flightHoursDayLimit: $flightHoursDayLimit,
                flightHoursMonthLimit: $flightHoursMonthLimit,
            );
        }
        
        return $crews;
    }

    /**
     * Get crew with relations loaded.
     */
    public function getCrewWithRelations(Crew $crew, array $relations = []): Crew
    {
        return $crew->load($relations);
    }

    /**
     * Get warning messages for crew members that exceeded limits.
     */
    public function getCrewLimitWarnings(Crew $crew): array
    {
        $warnings = [];
        
        if ($crew->flights_day_limit) {
            $warnings[] = 'This crew member has exceeded the flights per day limit.';
        }
        if ($crew->flights_month_limit) {
            $warnings[] = 'This crew member has exceeded the flights per month limit.';
        }
        if ($crew->hours_day_limit) {
            $warnings[] = 'This crew member has exceeded the flight hours per day limit.';
        }
        if ($crew->hours_month_limit) {
            $warnings[] = 'This crew member has exceeded the flight hours per month limit.';
        }
        
        return $warnings;
    }
}
