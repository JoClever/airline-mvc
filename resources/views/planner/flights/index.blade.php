<x-layout>
    <h1 class="text-3xl font-bold underline">
        Flights List
    </h1>

    <div>
        <h2>Create Flight</h2>
        @if ($selectedAircraft)
            <a href="{{ route('planner.flights.create') . '?aircraft_id=' . $selectedAircraft->id }}" class="text-blue-500 underline">Create a new flight for {{ $selectedAircraft->registration_number }}</a>
        @else
            <a href="{{ route('planner.flights.create') }}" class="text-blue-500 underline">Create a new flight</a>
        @endif
    </div>

    <div>
        <h2>Filter Flights</h2>
        <form method="GET" action="/planner/flights">
            <div>
                <label for="aircraft_id">Aircraft</label>
                <select name="aircraft_id" id="aircraft_id">
                    <option value="">All Aircraft</option>
                    @foreach ($aircrafts as $aircraft)
                        <option value="{{ $aircraft['id'] }}" {{ ($selectedAircraft->id ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="flightnumber">Flight Number</label>
                <input type="text" name="flightnumber" id="flightnumber" value="{{ request('flightnumber') }}" placeholder="Flight Number">
            </div>
            <div>
                <label for="departure_airport">Departure Airport</label>
                <input type="text" name="departure_airport" id="departure_airport" value="{{ request('departure_airport') }}" placeholder="Departure Airport">
            </div>
            <div>
                <label for="arrival_airport">Arrival Airport</label>
                <input type="text" name="arrival_airport" id="arrival_airport" value="{{ request('arrival_airport') }}" placeholder="Arrival Airport">
            </div>
            <div>
                <label for="day">Day</label>
                <input type="date" name="day" id="day" value="{{ request('day') }}">
            </div>
            <div>
                <label for="month">Month</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}">
            </div>
            <div>
                <button type="submit">Apply Filters</button>
                <a href="{{ route('planner.flights.index') }}">Clear Filters</a>
            </div>
        </form>
    </div>

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
        <h2>Flight Records</h2>
        <table>
            <thead>
                <tr>
                    <th class="border px-4 py-2">Flight Number</th>
                    <th class="border px-4 py-2">Aircraft</th>
                    <th class="border px-4 py-2">Departure</th>
                    <th class="border px-4 py-2">Arrival</th>
                    <th class="border px-4 py-2">STD</th>
                    <th class="border px-4 py-2">STA</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flights as $flight)
                    <tr>
                        <td class="border px-4 py-2">{{ $flight['flight_number'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['aircraft_registration_number'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['departure_airport_icao'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['arrival_airport_icao'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['departure_time_scheduled'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['arrival_time_scheduled'] }}</td>
                        <td class="border px-4 py-2">
                            <form method="GET" action="{{ route('planner.flights.show', ['flight' => $flight['id']]) }}" style="display:inline;">
                                <button type="submit" class="text-green-500 underline">View</button>
                            </form>
                            <form method="GET" action="{{ route('planner.flights.edit', ['flight' => $flight['id']]) }}" style="display:inline;">
                                <button type="submit" class="text-blue-500 underline">Edit</button>
                            </form>
                            <form method="POST" action="{{ route('planner.flights.destroy', ['flight' => $flight['id']]) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>