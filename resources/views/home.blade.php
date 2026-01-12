<x-layout>
    <h1 class="text-3xl font-bold underline">
        Welcome to the Airline Management System
    </h1>
    <table>
        <thead>
            <tr>
                <th class="border px-4 py-2">Flight Number</th>
                <th class="border px-4 py-2">Origin</th>
                <th class="border px-4 py-2">Destination</th>
                <th class="border px-4 py-2">Departure Time</th>
                <th class="border px-4 py-2">Arrival Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($flights as $flight)
                <tr>
                    <td class="border px-4 py-2">{{ $flight['flight_number'] }}</td>
                    <td class="border px-4 py-2">{{ $flight['origin'] }}</td>
                    <td class="border px-4 py-2">{{ $flight['destination'] }}</td>
                    <td class="border px-4 py-2">{{ $flight['departure_time'] }}</td>
                    <td class="border px-4 py-2">{{ $flight['arrival_time'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>