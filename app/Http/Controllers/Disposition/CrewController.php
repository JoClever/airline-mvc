<?php

namespace App\Http\Controllers\Disposition;

use App\Http\Controllers\Controller;
use App\Models\Crew;
use App\Services\CrewService;

class CrewController extends Controller
{
    public function __construct(
        private CrewService $crewService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crews = Crew::all();
        $this->crewService->enrichCrewsWithFlightStats(
            crews: $crews,
            day: now(),
            flightsDayLimit: 1,
            flightsMonthLimit: 2,
            flightHoursDayLimit: 4,
            flightHoursMonthLimit: 6,
        );
        
        return view('disposition.crews.index', compact('crews'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        $this->crewService->enrichCrewWithFlightStats(
            crew: $crew,
            day: now(),
            flightsDayLimit: 1,
            flightsMonthLimit: 2,
            flightHoursDayLimit: 4,
            flightHoursMonthLimit: 6,
        );

        $warnings = $this->crewService->getCrewLimitWarnings($crew);
        
        if (!empty($warnings)) {
            session()->flash('warnings', $warnings);
        }

        return view('disposition.crews.show', compact('crew'));
    }
}
