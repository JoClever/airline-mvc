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