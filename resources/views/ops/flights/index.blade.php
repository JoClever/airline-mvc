<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Flight Operations</h1>
            <p class="text-gray-600">Manage and monitor your flight operations</p>
        </div>

        <!-- Filters Section -->
        <form method="GET" action="{{ route('ops.flights.index') }}" class="card bg-base-200 card-border shadow-lg">
            <div class="card-body">
                <fieldset>
                    <legend class="text-xl font-bold px-2">Filter Flights</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        <div class="form-control">
                            <label class="label" for="aircraft_id">
                                <span class="label-text">Aircraft</span>
                            </label>
                            <select name="aircraft_id" id="aircraft_id" class="select select-bordered w-full">
                                <option value="">All Aircraft</option>
                                @foreach ($aircrafts ?? [] as $aircraft)
                                    <option value="{{ $aircraft['id'] }}" {{ ($selectedAircraft->id ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label" for="flight_number">
                                <span class="label-text">Flight Number</span>
                            </label>
                            <input type="text" name="flight_number" id="flight_number" value="{{ request('flight_number') }}" placeholder="e.g., AA123" class="input input-bordered w-full">
                        </div>
                        <div class="form-control">
                            <label class="label" for="departure_airport">
                                <span class="label-text">Departure Airport</span>
                            </label>
                            <input type="text" name="departure_airport" id="departure_airport" value="{{ request('departure_airport') }}" placeholder="e.g., KJFK" class="input input-bordered w-full">
                        </div>
                        <div class="form-control">
                            <label class="label" for="arrival_airport">
                                <span class="label-text">Arrival Airport</span>
                            </label>
                            <input type="text" name="arrival_airport" id="arrival_airport" value="{{ request('arrival_airport') }}" placeholder="e.g., EGLL" class="input input-bordered w-full">
                        </div>
                        <div class="form-control">
                            <label class="label" for="day">
                                <span class="label-text">Day</span>
                            </label>
                            <input type="date" name="day" id="day" value="{{ request('day') }}" class="input input-bordered w-full">
                        </div>
                        <div class="form-control">
                            <label class="label" for="month">
                                <span class="label-text">Month</span>
                            </label>
                            <input type="text" name="month" id="month" value="{{ request('month') }}" placeholder="e.g., 2026-01" class="input input-bordered w-full">
                        </div>
                        <div class="flex gap-2 items-end col-span-1 sm:col-span-2 md:col-span-3">
                            <button type="submit" class="btn btn-primary flex-1">Apply Filters</button>
                            <a href="{{ route('planner.flights.index') }}" class="btn btn-outline flex-1">Clear Filters</a>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>


        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="font-bold">Validation Errors</h3>
                    <ul class="text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

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