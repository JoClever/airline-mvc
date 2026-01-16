<?php

namespace App\View\Components\FlightEditForm;

use Closure;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Crew;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ops extends Component
{
    public $aircrafts;
    public $airports;
    public $crews;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->aircrafts = Aircraft::all();
        $this->airports = Airport::all();
        $this->crews = Crew::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flight-edit-form.ops');
    }
}
