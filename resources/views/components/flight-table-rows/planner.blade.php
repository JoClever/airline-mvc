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
