<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Create New Flight</h1>
            <p class="text-gray-600">Add a new flight to your schedule</p>
        </div>

        <x-alert />

        <form method="POST" action="{{ route('planner.flights.store') }}" class="card bg-base-100 shadow-lg m-auto">
            @csrf
            <div class="card-body">
                <fieldset >
                    <legend class="card-title">Flight Information</legend>
                    <div class="space-y-4 mt-4">
                        <div class="form-control">
                            <label class="label" for="flight_number">
                                <span class="label-text">Flight Number *</span>
                            </label>
                            <input type="text" id="flight_number" name="flight_number" placeholder="e.g., AA123" class="input input-bordered w-full @error('flight_number') input-error @enderror" value="{{ old('flight_number') }}">
                            @error('flight_number')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label" for="departure_airport_id">
                                    <span class="label-text">Departure Airport *</span>
                                </label>
                                <select name="departure_airport_id" id="departure_airport_id" class="select select-bordered w-full @error('departure_airport_id') input-error @enderror">
                                    <option value="">Select</option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport['id'] }}">{{ $airport->icao_code }}</option>
                                    @endforeach
                                </select>
                                @error('departure_airport_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                            <div class="form-control">
                                <label class="label" for="arrival_airport_id">
                                    <span class="label-text">Arrival Airport *</span>
                                </label>
                                <select name="arrival_airport_id" id="arrival_airport_id" class="select select-bordered w-full @error('arrival_airport_id') input-error @enderror">
                                    <option value="">Select</option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport['id'] }}">{{ $airport->icao_code }}</option>
                                    @endforeach
                                </select>
                                @error('arrival_airport_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-4">
                            <div class="form-control">
                                <label class="label" for="departure_time_scheduled">
                                    <span class="label-text">Departure Time *</span>
                                </label>
                                <input type="datetime-local" id="departure_time_scheduled" name="departure_time_scheduled" class="input input-bordered w-full @error('departure_time_scheduled') input-error @enderror" value="{{ old('departure_time_scheduled') }}">
                                @error('departure_time_scheduled')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                            <div class="form-control">
                                <label class="label" for="enroute_time">
                                    <span class="label-text">ETE (Hours) *</span>
                                </label>
                                <input type="number" step="0.1" id="enroute_time" name="enroute_time" placeholder="e.g., 7.5" class="input input-bordered w-full @error('enroute_time') input-error @enderror" value="{{ old('enroute_time') }}">
                                @error('enroute_time')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label" for="aircraft_id">
                                <span class="label-text">Aircraft *</span>
                            </label>
                            <select name="aircraft_id" id="aircraft_id" class="select select-bordered w-full @error('aircraft_id') input-error @enderror">
                                <option value="">Select</option>
                                @foreach ($aircrafts as $aircraft)
                                    <option value="{{ $aircraft->id }}" @selected(request('aircraft_id') == $aircraft->id)>{{ $aircraft->registration_number }}</option>
                                @endforeach
                            </select>
                            @error('aircraft_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                </fieldset>

                <div class="card-actions justify-between pt-4">
                    <a href="{{ route('planner.flights.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Flight</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>