<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Crew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DispositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        
        $date = $validated['date'] ?? now()->format('Y-m-d');

        $crews = Crew::all();

        foreach ($crews as $crew) {
            $crew->flights_on_date = $crew->flights()
                ->whereDate('departure_time_scheduled', $date)
                ->orWhereDate('arrival_time_scheduled', $date)
                ->get();
            $crew->flights_on_month = $crew->flights()
                ->whereYear('departure_time_scheduled', substr($date, 0, 4))
                ->whereMonth('departure_time_scheduled', substr($date, 5, 2))
                ->get();
        }
        return view('crews.index', compact('crews', 'date'));
    }
}
