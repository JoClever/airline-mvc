<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Aircraft::truncate();

        Aircraft::create(['registration_number' => 'D-ABOB']);
        Aircraft::create(['registration_number' => 'D-ABCE']);
        Aircraft::create(['registration_number' => 'D-ABYT']);
        Aircraft::create(['registration_number' => 'D-ABIB']);
    }
}
