<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use Illuminate\Http\Request;

class DispositionCrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crews = Crew::all();
        
        return view('crews.disposition.index', compact('crews'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        return view('crews.disposition.show', compact('crew'));
    }
}
