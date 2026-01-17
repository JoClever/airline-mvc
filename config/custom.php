<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing custom configuration values for your application.
    | You can access these values using the config() helper function.
    |
    */

    'crew_max_flights_day' => env('CREW_MAX_FLIGHTS_DAY', 4),
    'crew_max_flights_month' => env('CREW_MAX_FLIGHTS_MONTH', 20),
    'crew_max_flight_hours_day' => env('CREW_MAX_FLIGHT_HOURS_DAY', 8),
    'crew_max_flight_hours_month' => env('CREW_MAX_FLIGHT_HOURS_MONTH', 60),

];