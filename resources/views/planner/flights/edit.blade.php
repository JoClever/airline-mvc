<x-layout>
    <h1 class="text-3xl font-bold underline">
        Flight Editing
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
        <form method="POST" action="{{ route('planner.flights.update', ['flight' => $flight->id]) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="flight_number">Flight Number:</label>
                <input type="text" id="flight_number" name="flight_number" value="{{ $flight->flight_number }}" required>
            </div>
            <div>
                <label for="departure_airport_icao">Departure Airport ICAO:</label>
                <input type="text" id="departure_airport_icao" name="departure_airport_icao" value="{{ $flight->departureAirport->icao_code }}" required>
            </div>
            <div>
                <label for="arrival_airport_icao">Arrival Airport ICAO:</label>
                <input type="text" id="arrival_airport_icao" name="arrival_airport_icao" value="{{ $flight->arrivalAirport->icao_code }}" required>
            </div>
            <div>
                <label for="departure_time">Departure Time:</label>
                <input type="datetime-local" id="departure_time" name="departure_time" value="{{ $flight->departure_time_scheduled }}" required>
            </div>
            <div>
                <label for="arrival_time">Arrival Time:</label>
                <input type="datetime-local" id="arrival_time" name="arrival_time" value="{{ $flight->arrival_time_scheduled }}" required>
            </div>
            <div>
                <label for="registration_number">Aircraft Registration Number:</label>
                <input type="text" id="registration_number" name="registration_number" value="{{ $flight->aircraft->registration_number }}" required>
            </div>
            <button type="submit">Save Flight</button>
        </form>
    </div>
</x-layout>