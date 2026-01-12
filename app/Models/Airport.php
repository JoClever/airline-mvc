<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airport extends Model
{
    protected $fillable = [
        'name',
        'icao_code',
        'iata_code',
        'city',
        'country',
        'latitude',
        'longitude',
    ];

    public function departingFlights() : HasMany
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }

    public function arrivingFlights() : HasMany
    {
        return $this->hasMany(Flight::class, 'arrival_airport_id');
    }
    
    public function diversionFlights() : HasMany
    {
        return $this->hasMany(Flight::class, 'diversion_airport_id');
    }
}
