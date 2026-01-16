@props(['flight'])

<fieldset>
    <legend class="card-title">Edit Flight Details</legend>
    <div class="space-y-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="flight_number">
                    <span class="label-text">Flight Number *</span>
                </label>
                <input type="text" id="flight_number" name="flight_number" value="{{ $flight->flight_number }}" class="input input-bordered w-full @error('flight_number') input-error @enderror" required>
                @error('flight_number')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label" for="aircraft_id">
                    <span class="label-text">Aircraft *</span>
                </label>
                <select name="aircraft_id" id="aircraft_id" class="select select-bordered w-full @error('aircraft_id') input-error @enderror">
                    <option value="">Select</option>
                    @foreach ($aircrafts as $aircraft)
                        <option value="{{ $aircraft->id }}" {{ $flight->aircraft->id == $aircraft->id ? 'selected' : '' }}>{{ $aircraft->registration_number }}</option>
                    @endforeach
                </select>
                @error('aircraft_id')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
            <div class="form-control">
                <label class="label" for="departure_airport_id">
                    <span class="label-text">Departure Airport *</span>
                </label>
                <select name="departure_airport_id" id="departure_airport_id" class="select select-bordered w-full @error('departure_airport_id') input-error @enderror">
                    <option value="">Select</option>
                    @foreach ($airports as $airport)
                        <option value="{{ $airport['id'] }}" @selected($flight->departure_airport_id == $airport->id)>{{ $airport->icao_code }}</option>
                    @endforeach
                </select>
                @error('departure_airport_id')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label" for="departure_time_scheduled">
                    <span class="label-text">Departure Time *</span>
                </label>
                <input type="datetime-local" id="departure_time_scheduled" name="departure_time_scheduled" value="{{ $flight->departure_time_scheduled }}" class="input input-bordered w-full @error('departure_time_scheduled') input-error @enderror" required>
                @error('departure_time_scheduled')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
            <div class="form-control">
                <label class="label" for="arrival_airport_id">
                    <span class="label-text">Arrival Airport *</span>
                </label>
                <select name="arrival_airport_id" id="arrival_airport_id" class="select select-bordered w-full @error('arrival_airport_id') input-error @enderror">
                    <option value="">Select</option>
                    @foreach ($airports as $airport)
                        <option value="{{ $airport->id }}" @selected($flight->arrival_airport_id == $airport->id)>{{ $airport->icao_code }}</option>
                    @endforeach
                </select>
                @error('arrival_airport_id')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label" for="arrival_time_scheduled">
                    <span class="label-text">Arrival Time *</span>
                </label>
                <input type="datetime-local" id="arrival_time_scheduled" name="arrival_time_scheduled" value="{{ $flight->arrival_time_scheduled }}" class="input input-bordered w-full @error('arrival_time_scheduled') input-error @enderror" required>
                @error('arrival_time_scheduled')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>
    </div>
</fieldset>