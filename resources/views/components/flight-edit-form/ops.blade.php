@props(['flight'])

<fieldset class="mt-4">
    <legend class="card-title">Operations Control</legend>
    <div class="space-y-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="etd">
                    <span class="label-text">ETD</span>
                </label>
                <input type="datetime-local" id="etd" name="etd" value="{{ $flight->departure_time_estimated }}" class="input input-bordered w-full">
            </div>
            <div class="form-control">
                <label class="label" for="eta">
                    <span class="label-text">ETA</span>
                </label>
                <input type="datetime-local" id="eta" name="eta" value="{{ $flight->arrival_time_estimated }}" class="input input-bordered w-full">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="atd">
                    <span class="label-text">ATD</span>
                </label>
                <input type="datetime-local" id="atd" name="atd" value="{{ $flight->departure_time_actual }}" class="input input-bordered w-full">
            </div>
            <div class="form-control">
                <label class="label" for="ata">
                    <span class="label-text">ATA</span>
                </label>
                <input type="datetime-local" id="ata" name="ata" value="{{ $flight->arrival_time_actual }}" class="input input-bordered w-full">
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