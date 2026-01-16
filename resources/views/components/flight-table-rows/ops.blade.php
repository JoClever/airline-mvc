<tr class="hover:bg-base-200 whitespace-nowrap">
    <th>
        <span class="font-bold">{{ $flight->flight_number }}</span>
    </th>
    <td>{{ $flight->aircraft->registration_number }}</td>
    <td>{{ $flight->departureAirport->icao_code }}</td>
    <td>{{ $flight->arrivalAirport->icao_code }}</td>
    <td>{{ $flight->diversionAirport->icao_code ?? '---' }}</td>
    <td>{{ $flight->departure_time_scheduled }}</td>
    <td>{{ $flight->departure_time_estimated ?? '---' }}</td>
    <td>{{ $flight->departure_time_actual ?? '---' }}</td>
    <td>{{ $flight->arrival_time_scheduled }}</td>
    <td>{{ $flight->arrival_time_estimated ?? '---' }}</td>
    <td>{{ $flight->arrival_time_actual ?? '---' }}</td>
    <td>
        @switch($flight->status)
            @case('Cancelled')
                <span class="badge badge-error badge-md">CANCELLED</span>
                @break
            @case('Diverted')
                <span class="badge badge-error badge-md">DIVERTED</span>
                @break
            @case('Scheduled')
                <span class="badge badge-success badge-md">SCHEDULED</span>
                @break
            @case('Delayed')
                <span class="badge badge-warning badge-md">DELAYED</span>
                @break
            @case('Departed')
                <span class="badge badge-info badge-md">DEPARTED</span>
                @break
            @case('Landed')
                <span class="badge badge-success badge-md">LANDED</span>
                @break
            @default
                <span class="badge badge-info badge-md">{{ $flight->status }}</span>
        @endswitch
    </td>
    <th>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('ops.flights.show', ['flight' => $flight->id]) }}">
                <button type="submit" class="btn btn-sm btn-info">View</button>
            </form>
            <form method="GET" action="{{ route('ops.flights.edit', ['flight' => $flight->id]) }}">
                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
            </form>
        </div>
    </th>
</tr>
