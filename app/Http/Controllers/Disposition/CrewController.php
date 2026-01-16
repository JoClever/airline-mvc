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
        $this->crewService->enrichCrewsWithFlightStats($crews);
        
        return view('disposition.crews.index', compact('crews'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        $crew->load('flights');
        return view('disposition.crews.show', compact('crew'));
    }
}
