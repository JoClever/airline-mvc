<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Flight Operations</h1>
            <p class="text-gray-600">Manage and monitor your flight operations</p>
        </div>

        <!-- Filters Section -->
        <x-filter 
            :route="route('ops.flights.index')"
            :clearRoute="route('ops.flights.index')"
            :showAircraft="true"
            :showCrew="true"
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
                                <th>No.</th>
                                <td>A/C</td>
                                <td>Orig</td>
                                <td>Dest</td>
                                <td>STD</td>
                                <td>ETD</td>
                                <td>ATD</td>
                                <td>STA</td>
                                <td>ETA</td>
                                <td>ATA</td>
                                <td>Status</td>
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
                                    <td>{{ $flight['departure_time_estimated'] ?? '---' }}</td>
                                    <td>{{ $flight['departure_time_actual'] ?? '---' }}</td>
                                    <td>{{ $flight['arrival_time_scheduled'] }}</td>
                                    <td>{{ $flight['arrival_time_estimated'] ?? '---' }}</td>
                                    <td>{{ $flight['arrival_time_actual'] ?? '---' }}</td>
                                    <td>
                                        @if ($flight['status'] == 'Cancelled')
                                            <span class="badge badge-error badge-md">CANCELLED</span>
                                        @elseif ($flight['diversion_airport_icao'])
                                            <span class="badge badge-info badge-md">DIVERTED</span>
                                        @elseif ($flight['departure_time_actual'])
                                            <span class="badge badge-warning badge-md">DEPARTED</span>
                                        @elseif ($flight['arrival_time_actual'])
                                            <span class="badge badge-warning badge-md">LANDED</span>
                                        @elseif ($flight['departure_time_estimated'] || $flight['arrival_time_estimated'])
                                            <span class="badge badge-warning badge-md">DELAYED</span>
                                        @elseif ($flight['status'] == 'scheduled')
                                            <span class="badge badge-success badge-md">ON TIME</span>
                                        @else
                                            <span class="badge badge-info badge-md">{{ $flight['status'] }}</span>
                                        @endif
                                    <th>
                                        <div class="flex gap-2">
                                            <form method="GET" action="{{ route('ops.flights.show', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-info">View</button>
                                            </form>
                                            <form method="GET" action="{{ route('ops.flights.edit', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <td>A/C</td>
                                <td>Orig</td>
                                <td>Dest</td>
                                <td>STD</td>
                                <td>ETD</td>
                                <td>ATD</td>
                                <td>STA</td>
                                <td>ETA</td>
                                <td>ATA</td>
                                <td>Status</td>
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