<x-layout>
    <h1 class="text-3xl font-bold underline">
        Flights List
    </h1>

    {{-- <div>
        <h2>Filter by Aircraft</h2>
        <form method="GET" action="/planner/flights">
            <select name="aircraft_id" onchange="this.form.submit()">
                <option value="">All Aircraft</option>
        @foreach ($aircrafts as $aircraft)
            <option value="{{ $aircraft['id'] }}" {{ ($selectedAircraft->id ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
        @endforeach
            </select>
        </form>
    </div> --}}

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
                    <th class="border px-4 py-2">Departure</th>
                    <th class="border px-4 py-2">Arrival</th>
                    <th class="border px-4 py-2">STD</th>
                    <th class="border px-4 py-2">STA</th>
                    <th class="border px-4 py-2">Crew</th>
                    <th class="border px-4 py-2">Crew Transfers</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flights as $flight)
                    <tr>
                        <td class="border px-4 py-2">{{ $flight['flight_number'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['departure_airport_icao'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['arrival_airport_icao'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['departure_time_scheduled'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['arrival_time_scheduled'] }}</td>
                        <td class="border px-4 py-2">{{ $flight['crew_id'] }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($flight['crewTransfers'] as $transfer)
                                <div>
                                    {{ $transfer['id'] }}
                                </div>
                            @endforeach
                        <td class="border px-4 py-2">
                            <form method="GET" action="{{ route('disposition.flights.show', ['flight' => $flight['id']]) }}" style="display:inline;">
                                <button type="submit" class="text-green-500 underline">View</button>
                            </form>
                            <form method="GET" action="{{ route('disposition.flights.edit', ['flight' => $flight['id']]) }}" style="display:inline;">
                                <button type="submit" class="text-blue-500 underline">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>