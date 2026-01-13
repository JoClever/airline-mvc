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
        <h2>Filter by Aircraft</h2>
        <form method="GET" action="/planner/flights">
            <select name="aircraft_id" onchange="this.form.submit()">
                <option value="">All Aircraft</option>
        @foreach ($aircrafts as $aircraft)
            <option value="{{ $aircraft['id'] }}" {{ ($selectedAircraft->id ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
        @endforeach
            </select>
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