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
        $crews = $this->crewService->getAllCrews();
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
        $crew = $this->crewService->getCrewWithRelations($crew, ['flights']);
        return view('disposition.crews.show', compact('crew'));
    }
}
