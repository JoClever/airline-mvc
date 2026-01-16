<tr class="hover:bg-base-200 whitespace-nowrap">
    <th>
        <span class="font-bold">{{ $flight->flight_number }}</span>
    </th>
    <td>{{ $flight->departureAirport->icao_code }}</td>
    <td>{{ $flight->arrivalAirport->icao_code }}</td>
    <td>{{ $flight->departure_time_scheduled }}</td>
    <td>{{ $flight->arrival_time_scheduled }}</td>
    <td>
        @if ($flight->crew_id)
            <span class="badge badge-success">#{{ $flight->crew_id }}</span>
        @else
            <span class="badge badge-warning">Unassigned</span>
        @endif
    </td>
    <td>
        @foreach ($flight->crewTransfers as $transfer)
            <div>
                <span class="badge">#{{ $transfer->id }}</span>
            </div>
        @endforeach
    </td>
    <th>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('disposition.flights.show', ['flight' => $flight->id]) }}">
                <button type="submit" class="btn btn-sm btn-info">View</button>
            </form>
            <form method="GET" action="{{ route('disposition.flights.edit', ['flight' => $flight->id]) }}">
                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
            </form>
        </div>
    </th>
</tr>
