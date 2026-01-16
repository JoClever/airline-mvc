<?php

namespace App\Http\Controllers\Ops;

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
        
        return view('ops.crews.index', compact('crews'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        return view('ops.crews.show', compact('crew'));
    }
}
