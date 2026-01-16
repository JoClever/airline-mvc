@props(['flight'])

<fieldset class="mt-4">
    <legend class="card-title">Operations Control</legend>
    <div class="space-y-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="departure_time_estimated">
                    <span class="label-text">ETD</span>
                </label>
                <input type="datetime-local" id="departure_time_estimated" name="departure_time_estimated" value="{{ $flight->departure_time_estimated }}" class="input input-bordered w-full">
                @error('departure_time_estimated')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label" for="arrival_time_estimated">
                    <span class="label-text">ETA</span>
                </label>
                <input type="datetime-local" id="arrival_time_estimated" name="arrival_time_estimated" value="{{ $flight->arrival_time_estimated }}" class="input input-bordered w-full">
                @error('arrival_time_estimated')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="departure_time_actual">
                    <span class="label-text">ATD</span>
                </label>
                <input type="datetime-local" id="departure_time_actual" name="departure_time_actual" value="{{ $flight->departure_time_actual }}" class="input input-bordered w-full">
                @error('departure_time_actual')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
            <div class="form-control">
                <label class="label" for="arrival_time_actual">
                    <span class="label-text">ATA</span>
                </label>
                <input type="datetime-local" id="arrival_time_actual" name="arrival_time_actual" value="{{ $flight->arrival_time_actual }}" class="input input-bordered w-full">
                @error('arrival_time_actual')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror  
            </div>
        </div>

        <div class="form-control">
            <label class="label" for="diversion_airport_id">
                <span class="label-text">Diversion Airport</span>
            </label>
            <select name="diversion_airport_id" id="diversion_airport_id" class="select select-bordered w-full @error('diversion_airport_id') input-error @enderror">
                <option value="">No Diversion</option>
                @foreach ($airports as $airport)
                    <option value="{{ $airport->id }}" @selected($flight->diversion_airport_id == $airport->id)>{{ $airport->icao_code }}</option>
                @endforeach
            </select>
            @error('diversion_airport_id')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>
    </div>
</fieldset>