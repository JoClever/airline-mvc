<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Flight Records</h1>
            <p class="text-gray-600">Manage and plan your flights</p>
        </div>

        <!-- Create Flight Button -->
        <div class="flex gap-2">
            @if (request('aircraft_id'))
                <a href="{{ route('planner.flights.create') . '?aircraft_id=' . request('aircraft_id') }}" class="btn btn-primary">
                    Create new flight for {{ $aircrafts->firstWhere('id', request('aircraft_id'))['registration_number'] }}
                </a>
            @else
                <a href="{{ route('planner.flights.create') }}" class="btn btn-primary">
                    Create new flight
                </a>
            @endif
        </div>

        <x-filter
            :route="route('planner.flights.index')"
            :clearRoute="route('planner.flights.index')"
            :showAircraft="true"
            :showCrew="false"
            :showUnassignedOnly="false"
        />

        <x-alert />

        <!-- Flight Records Table -->
        <div class="card card-border bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full table-pin-rows table-pin-cols">
                        <thead>
                            <tr>
                                <th>Flight Number</th>
                                <td>Aircraft</td>
                                <td>Departure</td>
                                <td>Arrival</td>
                                <td>STD</td>
                                <td>STA</td>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flights as $flight)
                                <tr class="hover:bg-base-200 whitespace-nowrap">
                                    <th>
                                        <span class="font-bold">{{ $flight['flight_number'] }}</span>
                                    </th>
                                    <td>{{ $flight['aircraft_registration_number'] }}</td>
                                    <td>{{ $flight['departure_airport_icao'] }}</td>
                                    <td>{{ $flight['arrival_airport_icao'] }}</td>
                                    <td>{{ $flight['departure_time_scheduled'] }}</td>
                                    <td>{{ $flight['arrival_time_scheduled'] }}</td>
                                    <th>
                                        <div class="flex gap-2">
                                            <form method="GET" action="{{ route('planner.flights.show', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-info">View</button>
                                            </form>
                                            <form method="GET" action="{{ route('planner.flights.edit', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                            <form method="POST" action="{{ route('planner.flights.destroy', ['flight' => $flight['id']]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Flight Number</th>
                                <td>Aircraft</td>
                                <td>Departure</td>
                                <td>Arrival</td>
                                <td>STD</td>
                                <td>STA</td>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if(count($flights) == 0)
                    <div class="alert alert-info mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>No flights found. Create one to get started!</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>