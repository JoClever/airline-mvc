<fieldset class="mt-4">
    <legend class="card-title">Operations Control</legend>
    <div class="space-y-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="etd">
                    <span class="label-text">ETD</span>
                </label>
                <input type="datetime-local" id="etd" name="etd" value="{{ $flight->etd }}" class="input input-bordered w-full" disabled>
            </div>
            <div class="form-control">
                <label class="label" for="eta">
                    <span class="label-text">ETA</span>
                </label>
                <input type="datetime-local" id="eta" name="eta" value="{{ $flight->eta }}" class="input input-bordered w-full" disabled>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label" for="atd">
                    <span class="label-text">ATD</span>
                </label>
                <input type="datetime-local" id="atd" name="atd" value="{{ $flight->atd }}" class="input input-bordered w-full" disabled>
            </div>
            <div class="form-control">
                <label class="label" for="ata">
                    <span class="label-text">ATA</span>
                </label>
                <input type="datetime-local" id="ata" name="ata" value="{{ $flight->ata }}" class="input input-bordered w-full" disabled>
            </div>
        </div>

        <div class="form-control">
            <label class="label" for="diversion_airport_icao">
                <span class="label-text">Diversion Airport</span>
            </label>
            <input type="text" id="diversion_airport_id" name="diversion_airport_id" placeholder="Diversion airport" class="input input-bordered w-full" value="{{ $flight->diversionAirport->icao_code ?? 'No Diversion' }}" disabled>
        </div>
    </div>
</fieldset>