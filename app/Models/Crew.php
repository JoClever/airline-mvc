<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crew extends Model
{

    protected $fillable = [];

    public function flights() : HasMany
    {
        return $this->hasMany(Flight::class);
    }

    public function transferFlights() : BelongsToMany
    {
        return $this->belongsToMany(Flight::class, 'flight_crew_transfers', 'crew_id', 'flight_id');
    }
}
