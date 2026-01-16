@props([
    'crew',
    'role' => null,
])

<form class="card bg-base-100 shadow-lg">
    <div class="card-body">
        <fieldset>
            <legend class="card-title">Crew Stats</legend>
            <div class="space-y-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="form-control">
                        <label class="label" for="flights_month">
                            <span class="label-text">Flights This Month</span>
                        </label>
                        <input type="text" id="flights_month" name="flights_month" value="{{ $crew->flights_month_count }}" class="input input-bordered w-full {{ $crew->flights_month_limit ? 'input-error' : '' }}" readonly>
                        @if ($crew->flights_month_limit)
                            <label class="label">
                                <span class="label-text text-error">Exceeded monthly flight count limit!</span>
                            </label>
                        @endif
                    </div>
                    <div class="form-control">
                        <label class="label" for="flight_hours_month">
                            <span class="label-text">Flight Hours This Month</span>
                        </label>
                        <input type="text" id="flight_hours_month" name="flight_hours_month" value="{{ $crew->hours_month }}" class="input input-bordered w-full {{ $crew->hours_month_limit ? 'input-error' : '' }}" readonly>
                        @if ($crew->hours_month_limit)
                            <label class="label">
                                <span class="label-text text-error">Exceeded monthly flight hours limit!</span>
                            </label>
                        @endif
                    </div>
                    <div class="form-control">
                        <label class="label" for="flights_day">
                            <span class="label-text">Flights Today</span>
                        </label>
                        <input type="text" id="flights_day" name="flights_day" value="{{ $crew->flights_day_count }}" class="input input-bordered w-full {{ $crew->flights_day_limit ? 'input-error' : '' }}" readonly>
                        @if ($crew->flights_day_limit)
                            <label class="label">
                                <span class="label-text text-error">Exceeded daily flight count limit!</span>
                            </label>
                        @endif
                    </div>
                    <div class="form-control">
                        <label class="label" for="flight_hours_day">
                            <span class="label-text">Flight Hours Today</span>
                        </label>
                        <input type="text" id="flight_hours_day" name="flight_hours_day" value="{{ $crew->hours_day }}" class="input input-bordered w-full {{ $crew->hours_day_limit ? 'input-error' : '' }}" readonly>
                        @if ($crew->hours_day_limit)
                            <label class="label">
                                <span class="label-text text-error">Exceeded daily flight hours limit!</span>
                            </label>
                        @endif
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</form>