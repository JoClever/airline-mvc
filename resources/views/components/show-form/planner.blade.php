<fieldset>
    <legend class="card-title">Flight Details</legend>
    <div class="space-y-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="flight_number">
                    <span class="label-text">Flight Number</span>
                </label>
                <input type="text" id="flight_number" name="flight_number" value="{{ $flight->flight_number }}" class="input input-bordered w-full" disabled>
            </div>
            <div class="form-control">
                <label class="label" for="registration_number">
                    <span class="label-text">Aircraft Registration</span>
                </label>
                <input type="text" id="registration_number" name="registration_number" value="{{ $flight->aircraft->registration_number }}" class="input input-bordered w-full" disabled>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
            <div class="form-control">
                <label class="label" for="departure_airport_icao">
                    <span class="label-text">Departure Airport</span>
                </label>
                <input type="text" id="departure_airport_icao" name="departure_airport_icao" value="{{ $flight->departureAirport->icao_code }}" class="input input-bordered w-full" disabled>
            </div>
            <div class="form-control">
                <label class="label" for="departure_time">
                    <span class="label-text">Departure Time (STD)</span>
                </label>
                <input type="datetime-local" id="departure_time" name="departure_time" value="{{ $flight->departure_time_scheduled }}" class="input input-bordered w-full" disabled>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
            <div class="form-control">
                <label class="label" for="arrival_airport_icao">
                    <span class="label-text">Arrival Airport</span>
                </label>
                <input type="text" id="arrival_airport_icao" name="arrival_airport_icao" value="{{ $flight->arrivalAirport->icao_code }}" class="input input-bordered w-full" disabled>
            </div>
            <div class="form-control">
                <label class="label" for="arrival_time">
                    <span class="label-text">Arrival Time (STA)</span>
                </label>
                <input type="datetime-local" id="arrival_time" name="arrival_time" value="{{ $flight->arrival_time_scheduled }}" class="input input-bordered w-full" disabled>
            </div>
        </div>
    </div>
</fieldset>