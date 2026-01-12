<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flight extends Model
{

    protected $fillable = [
        'flight_number',
        'status',
        'departure_time_scheduled',
        'departure_time_estimated',
        'departure_time_actual',
        'arrival_time_scheduled',
        'arrival_time_estimated',
        'arrival_time_actual',
        'aircraft_id',
        'departure_airport_id',
        'arrival_airport_id',
        'diversion_airport_id',
        'crew_id',
    ];

    public function aircraft() : BelongsTo
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function departureAirport() : BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport() : BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    public function diversionAirport() : BelongsTo
    {
        return $this->belongsTo(Airport::class, 'diversion_airport_id');
    }

    public function crew() : BelongsTo
    {
        return $this->belongsTo(Crew::class);
    }

    public function transferCrews() : BelongsToMany
    {
        return $this->belongsToMany(Crew::class, 'flight_crew_transfers', 'flight_id', 'crew_id');
    }
    
}