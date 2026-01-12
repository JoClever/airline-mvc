<x-layout>
    <h1 class="text-3xl font-bold underline">
        Flight Creation
    </h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div>
        <form method="POST" action="{{ route('planner.flights.store') }}">
            @csrf
            <div>
                <label for="flight_number">Flight Number:</label>
                <input type="text" id="flight_number" name="flight_number" required>
            </div>
            <div>
                <label for="departure_airport_icao">Departure Airport ICAO:</label>
                <input type="text" id="departure_airport_icao" name="departure_airport_icao" required>
            </div>
            <div>
                <label for="arrival_airport_icao">Arrival Airport ICAO:</label>
                <input type="text" id="arrival_airport_icao" name="arrival_airport_icao" required>
            </div>
            <div>
                <label for="departure_time">Departure Time:</label>
                <input type="datetime-local" id="departure_time" name="departure_time" required>
            </div>
            <div>
                <label for="enroute_time">Enroute Time (Hours Decimal):</label>
                <input type="number" step="0.1" id="enroute_time" name="enroute_time" required>
            </div>
            <div>
                <label for="registration_number">Aircraft Registration Number:</label>
                <input type="text" id="registration_number" name="registration_number" value="{{ $selectedAircraft->registration_number ?? '' }}" required>
            </div>
            <button type="submit">Save Flight</button>
        </form>
    </div>
</x-layout>