<!-- Filters Section -->
<form method="GET" action="{{ $route }}" class="card bg-base-200 card-border shadow-lg">
    <div class="card-body">
        <fieldset>
            <legend class="text-xl font-bold px-2">Filter Flights</legend>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                @if ($showAircraft ?? false)
                    <div class="form-control">
                        <label class="label" for="aircraft_id">
                            <span class="label-text">Aircraft</span>
                        </label>
                        <select name="aircraft_id" id="aircraft_id" class="select select-bordered w-full">
                            <option value="">All Aircraft</option>
                            @foreach ($aircrafts as $aircraft)
                                <option value="{{ $aircraft['id'] }}" {{ (request('aircraft_id') ?? '') == $aircraft['id'] ? 'selected' : '' }}>{{ $aircraft['registration_number'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="form-control">
                    <label class="label" for="flight_number">
                        <span class="label-text">Flight Number</span>
                    </label>
                    <input type="text" name="flight_number" id="flight_number" value="{{ request('flight_number') }}" placeholder="e.g., AA123" class="input input-bordered w-full">
                </div>
                <div class="form-control">
                    <label class="label" for="departure_airport_id">
                        <span class="label-text">Departure Airport</span>
                    </label>
                    <select name="departure_airport_id" id="departure_airport_id" class="select select-bordered w-full">
                        <option value="">All Departure Airports</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport['id'] }}" {{ (request('departure_airport_id') ?? '') == $airport['id'] ? 'selected' : '' }}>{{ $airport['icao_code'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label" for="arrival_airport_id">
                        <span class="label-text">Arrival Airport</span>
                    </label>
                    <select name="arrival_airport_id" id="arrival_airport_id" class="select select-bordered w-full">
                        <option value="">All Arrival Airports</option>
                        @foreach ($airports as $airport)
                            <option value="{{ $airport['id'] }}" {{ (request('arrival_airport_id') ?? '') == $airport['id'] ? 'selected' : '' }}>{{ $airport['icao_code'] }}</option>
                        @endforeach
                    </select>
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
                @if ($showCrew ?? false)
                    <div class="form-control">
                        <label class="label" for="crew_id">
                            <span class="label-text">Crew</span>
                        </label>
                        <select name="crew_id" id="crew_id" class="select select-bordered w-full">
                            <option value="">All Crews</option>
                            @foreach ($crews as $crew)
                                <option value="{{ $crew['id'] }}" {{ (request('crew_id') ?? '') == $crew['id'] ? 'selected' : '' }}>{{ $crew['id'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($showUnassignedOnly ?? false)
                    <div class="form-control">
                        <label class="label">
                            <input type="checkbox" class="checkbox" name="no_crew" {{ request('no_crew') ? 'checked' : '' }} />
                            Unassigned Only
                        </label>
                    </div>
                @endif
                <div class="flex gap-2 items-end col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4">
                    <button type="submit" class="btn btn-primary flex-1">Apply Filters</button>
                    <a href="{{ $clearRoute }}" class="btn btn-outline flex-1">Clear Filters</a>
                </div>
            </div>
        </fieldset>
    </div>
</form>