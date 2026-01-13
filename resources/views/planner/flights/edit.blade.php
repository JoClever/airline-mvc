<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->flight_number }} {{ $flight->formatted_departure_date }}</h1>
            <p class="text-gray-600">Modify flight details</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2 2l2 2m0 0l2 2m-2-2l-2 2" /></svg>
                    <div>
                        <h3 class="font-bold">Validation Errors</h3>
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('planner.flights.update', ['flight' => $flight->id]) }}" class="card bg-base-100 shadow-lg m-auto">
            @csrf
            @method('PUT')

            <div class="card-body">
                <fieldset>
                    <legend class="card-title">Edit Flight Details</legend>
                    <div class="space-y-4 mt-4">
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

                        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
                            <div class="form-control">
                                <label class="label" for="departure_airport_icao">
                                    <span class="label-text">Departure Airport *</span>
                                </label>
                                <input type="text" id="departure_airport_icao" name="departure_airport_icao" value="{{ $flight->departureAirport->icao_code }}" class="input input-bordered w-full @error('departure_airport_icao') input-error @enderror" required>
                                @error('departure_airport_icao')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label" for="departure_time">
                                    <span class="label-text">Departure Time *</span>
                                </label>
                                <input type="datetime-local" id="departure_time" name="departure_time" value="{{ $flight->departure_time_scheduled }}" class="input input-bordered w-full @error('departure_time') input-error @enderror" required>
                                @error('departure_time')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr] gap-4">
                            <div class="form-control">
                                <label class="label" for="arrival_airport_icao">
                                    <span class="label-text">Arrival Airport *</span>
                                </label>
                                <input type="text" id="arrival_airport_icao" name="arrival_airport_icao" value="{{ $flight->arrivalAirport->icao_code }}" class="input input-bordered w-full @error('arrival_airport_icao') input-error @enderror" required>
                                @error('arrival_airport_icao')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label" for="arrival_time">
                                    <span class="label-text">Arrival Time *</span>
                                </label>
                                <input type="datetime-local" id="arrival_time" name="arrival_time" value="{{ $flight->arrival_time_scheduled }}" class="input input-bordered w-full @error('arrival_time') input-error @enderror" required>
                                @error('arrival_time')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label" for="registration_number">
                                <span class="label-text">Aircraft Registration Number *</span>
                            </label>
                            <input type="text" id="registration_number" name="registration_number" value="{{ $flight->aircraft->registration_number }}" class="input input-bordered w-full @error('registration_number') input-error @enderror" required>
                            @error('registration_number')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                </fieldset>

                <div class="card-actions justify-between pt-4">
                    <a href="{{ route('planner.flights.show', $flight) }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>