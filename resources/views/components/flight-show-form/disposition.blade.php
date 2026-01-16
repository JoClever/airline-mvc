<fieldset class="mt-4">
    <legend class="card-title">Crew Assignment</legend>
    <div class="space-y-4 mt-4">
        <div class="form-control">
            <label class="label" for="crew_id">
                <span class="label-text">Assigned Crew</span>
            </label>
            <input type="text" id="crew_id" name="crew_id" placeholder="Enter crew ID" class="input input-bordered w-full @error('crew_id') input-error @enderror" value="{{ $flight->crew_id ?? 'Unassigned' }}" disabled>
        </div>
    </div>
</fieldset>

<fieldset class="mt-4">
    <legend class="card-title">Crew Transfers</legend>
    <div class="space-y-3 mt-4">
        <div class="form-control">
            <label class="label" for="transfer_crew_ids">
                <span class="label-text">Transfer Crews</span>
            </label>
            <select name="transfer_crew_ids[]" id="transfer_crew_ids" multiple class="select select-bordered w-full @error('transfer_crew_ids') input-error @enderror" disabled>
                @foreach ($flight->crewTransfers as $crew)
                    <option value="{{ $crew->id }}">
                        Crew {{ $crew->id }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>