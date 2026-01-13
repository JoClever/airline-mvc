<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Flight Disposition</h1>
            <p class="text-gray-600">Manage crew assignments and flight disposition</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2 2l2 2m0 0l2 2m-2-2l-2 2" /></svg>
                    <div>
                        <h3 class="font-bold">Validation Errors</h3>
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Flight Number</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>STD</th>
                                <th>STA</th>
                                <th>Operating Crew</th>
                                <th>Transferring Crews</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flights as $flight)
                                <tr class="hover">
                                    <td>
                                        <span class="font-bold">{{ $flight['flight_number'] }}</span>
                                    </td>
                                    <td>{{ $flight['departure_airport_icao'] }}</td>
                                    <td>{{ $flight['arrival_airport_icao'] }}</td>
                                    <td>{{ $flight['departure_time_scheduled'] }}</td>
                                    <td>{{ $flight['arrival_time_scheduled'] }}</td>
                                    <td>
                                        @if($flight['crew_id'])
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
                                    <td>
                                        <div class="flex gap-2">
                                            <form method="GET" action="{{ route('disposition.flights.show', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-info">View</button>
                                            </form>
                                            <form method="GET" action="{{ route('disposition.flights.edit', ['flight' => $flight['id']]) }}">
                                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($flights) == 0)
                    <div class="alert alert-info mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>No flights available for disposition.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>