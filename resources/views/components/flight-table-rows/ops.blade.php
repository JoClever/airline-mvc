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
    </td>
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
