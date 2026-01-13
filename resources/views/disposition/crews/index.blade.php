<x-layout>
    <h1 class="text-3xl font-bold underline">
        Crews List
    </h1>

    {{-- <div>
        <h2>Filter by Date</h2>
        <form method="GET" action="/planner/flights">
            <select name="aircraft_id" onchange="this.form.submit()">
                <option value="">All Aircraft</option>
        @foreach ($aircrafts as $aircraft)
            <option value="{{ $aircraft['id'] }}" {{ ($selectedAircraft->id ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
        @endforeach
            </select>
        </form>
    </div> --}}

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <div>
        <h2>Crew Records</h2>
        <table>
            <thead>
                <tr>
                    <th class="border px-4 py-2">Crew ID</th>
                    <th class="border px-4 py-2">Flights (day)</th>
                    <th class="border px-4 py-2">Flights (month)</th>
                    <th class="border px-4 py-2">Hours (day)</th>
                    <th class="border px-4 py-2">Hours (month)</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crews as $crew)
                    <tr>
                        <td class="border px-4 py-2">{{ $crew['id'] }}</td>
                        <td class="border px-4 py-2">{{ $crew->flights_day_count }}</td>
                        <td class="border px-4 py-2">{{ $crew->flights_month_count }}</td>
                        <td class="border px-4 py-2">
                            <form method="GET" action="{{ route('disposition.crews.show', ['crew' => $crew['id']]) }}" style="display:inline;">
                                <button type="submit" class="text-green-500 underline">View</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>