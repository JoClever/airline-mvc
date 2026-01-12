<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airport::truncate();

        Airport::create([
            'icao_code' => 'LSZH',
            'iata_code' => 'ZRH',
            'name' => 'Flughafen Zürich',
            'city' => 'Zurich',
            'country' => 'Switzerland',
            'latitude' => 47.464722,
            'longitude' => 8.549167
        ]);

        Airport::create([
            'icao_code' => 'EDDP',
            'iata_code' => 'LEJ',
            'name' => 'Leipzig/Halle Airport',
            'city' => 'Leipzig-Halle',
            'country' => 'Germany',
            'latitude' => 51.423992,
            'longitude' => 12.236383
        ]);

        Airport::create([
            'icao_code' => 'KJFK',
            'iata_code' => 'JFK',
            'name' => 'John F. Kennedy International Airport',
            'city' => 'New York',
            'country' => 'United States',
            'latitude' => 40.6413111,
            'longitude' => -73.7781391
        ]);

        Airport::create([
            'icao_code' => 'EGLL',
            'iata_code' => 'LHR',
            'name' => 'London Heathrow Airport',
            'city' => 'London',
            'country' => 'United Kingdom',
            'latitude' => 51.470020,
            'longitude' => -0.454295
        ]);

        Airport::create([
            'icao_code' => 'LMML',
            'iata_code' => 'MLA',
            'name' => 'Malta International Airport',
            'city' => 'Luqa',
            'country' => 'Malta',
            'latitude' => 35.857497,
            'longitude' => 14.477501
        ]);
    }
}
