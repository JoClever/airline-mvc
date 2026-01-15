<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Flight Disposition</h1>
            <p class="text-gray-600">Manage crew assignments and flight disposition</p>
        </div>

        <!-- Filters Section -->
        <x-filter
            :route="route('disposition.flights.index')"
            :clearRoute="route('disposition.flights.index')"
            :showAircraft="false"
            :showCrew="true"
            :showUnassignedOnly="true"
        />

        <x-alert />

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full table-pin-rows table-pin-cols">
                        <thead>
                            <tr>
                                <th>Flight Number</th>
                                <td>Departure</td>
                                <td>Arrival</td>
                                <td>STD</td>
                                <td>STA</td>
                                <td>Operating Crew</td>
                                <td>Transferring Crews</td>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flights as $flight)
                                <tr class="hover:bg-base-200 whitespace-nowrap">
                                    <th>
                                        <span class="font-bold">{{ $flight['flight_number'] }}</span>
                                    </th>
                                    <td>{{ $flight['departure_airport_icao'] }}</td>
                                    <td>{{ $flight['arrival_airport_icao'] }}</td>
                                    <td>{{ $flight['departure_time_scheduled'] }}</td>
                                    <td>{{ $flight['arrival_time_scheduled'] }}</td>
                                    <td>
                                        @if ($flight['crew_id'])
                                            <span class="badge badge-success">#{{ $flight['crew_id'] }}</span>
                                        @else
                                            <span class="badge badge-warning">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($flight['crewTransfers'] as $transfer)
                                            <div>
                                                <span class="badge">#{{ $transfer['id'] }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <th>
                                        <div class="flex gap-2">
                                            <form method="GET"
                                                action="{{ route('disposition.flights.show', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-info">View</button>
                                            </form>
                                            <form method="GET"
                                                action="{{ route('disposition.flights.edit', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Flight Number</th>
                                <td>Departure</td>
                                <td>Arrival</td>
                                <td>STD</td>
                                <td>STA</td>
                                <td>Operating Crew</td>
                                <td>Transferring Crews</td>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if (count($flights) == 0)
                    <div class="alert alert-info mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No flights available for disposition.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
