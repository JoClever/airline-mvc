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

<fieldset class="mt-4">
    <legend class="card-title">Crew Transfers</legend>
    <div class="space-y-3 mt-4">
        <div class="form-control">
            <label class="label" for="transfer_crew_ids">
                <span class="label-text">Transfer Crews</span>
                <span class="label-text-alt text-gray-500">Hold Ctrl (or Cmd) to select multiple</span>
            </label>
            <select name="transfer_crew_ids[]" id="transfer_crew_ids" multiple size="6" class="select select-bordered w-full @error('transfer_crew_ids') input-error @enderror">
                @foreach ($crews as $crew)
                    <option value="{{ $crew->id }}" @selected($flight->crewTransfers->contains($crew->id))>
                        Crew {{ $crew->id }}
                    </option>
                @endforeach
            </select>
            @error('transfer_crew_ids')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>
    </div>
</fieldset>