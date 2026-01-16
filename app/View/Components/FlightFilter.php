<?php

namespace App\View\Components;

use Closure;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Crew;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlightFilter extends Component
{
    public $aircrafts;
    public $airports;
    public $crews;
    public $route;
    public $clearRoute;
    public $showAircraft;
    public $showCrew;
    public $showUnassignedOnly;

    /**
     * Create a new component instance.
     */
    public function __construct($route = null, $clearRoute = null, $showAircraft = false, $showCrew = false, $showUnassignedOnly = false)
    {
        $this->aircrafts = Aircraft::all();
        $this->airports = Airport::all();
        $this->crews = Crew::all();
        $this->route = $route;
        $this->clearRoute = $clearRoute;
        $this->showAircraft = $showAircraft;
        $this->showCrew = $showCrew;
        $this->showUnassignedOnly = $showUnassignedOnly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flight-filter');
    }
};