@props(['flight'])

<fieldset class="mt-4">
    <legend class="card-title">Crew Assignment</legend>
    <div class="space-y-4 mt-4">
        <div class="form-control">
            <label class="label" for="crew_id">
                <span class="label-text">Assigned Crew</span>
            </label>
            <select name="crew_id" id="crew_id" class="select select-bordered w-full @error('crew_id') input-error @enderror">
                <option value="">Unassigned</option>
                @foreach ($crews as $crew)
                    <option value="{{ $crew->id }}" @selected($flight->crew_id == $crew->id)>{{ $crew->id }}</option>
                @endforeach
            </select>
            @error('crew_id')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>
    </div>
</fieldset>