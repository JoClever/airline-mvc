<?php

namespace App\View\Components\EditForm;

use Closure;
use App\Models\Crew;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Disposition extends Component
{
    public $crews;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->crews = Crew::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-form.disposition');
    }
}
