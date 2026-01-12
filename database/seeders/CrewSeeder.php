<?php

namespace Database\Seeders;

use App\Models\Crew;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CrewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Crew::truncate();
        
        Crew::create();
        Crew::create();
        Crew::create();
        Crew::create();
        Crew::create();
    }
}
