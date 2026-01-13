<?php

namespace App\Services;

use App\Models\Crew;
use Illuminate\Support\Collection;

class CrewService
{
    /**
     * Enrich crews with flight statistics.
     */
    public function enrichCrewsWithFlightStats($crews): Collection|array
    {
        foreach ($crews as $crew) {
            $crew->flights_day = $crew->flights()
                ->whereDate('departure_time_scheduled', now()->toDateString())
                ->get();
            
            $crew->flights_day_count = $crew->flights()
                ->whereDate('departure_time_scheduled', now()->toDateString())
                ->count();
            
            $crew->flights_month = $crew->flights()
                ->whereMonth('departure_time_scheduled', now()->month)
                ->whereYear('departure_time_scheduled', now()->year)
                ->get();
            
            $crew->flights_month_count = $crew->flights()
                ->whereMonth('departure_time_scheduled', now()->month)
                ->whereYear('departure_time_scheduled', now()->year)
                ->count();
        }
        
        return $crews;
    }

    /**
     * Get all crews.
     */
    public function getAllCrews(): Collection
    {
        return Crew::all();
    }

    /**
     * Get crew with relations loaded.
     */
    public function getCrewWithRelations(Crew $crew, array $relations = []): Crew
    {
        return $crew->load($relations);
    }
}
