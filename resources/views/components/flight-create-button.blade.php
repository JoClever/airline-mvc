@php
    $createHref = request('aircraft_id')
        ? route('planner.flights.create') . '?aircraft_id=' . request('aircraft_id')
        : route('planner.flights.create');
    $createLabel = request('aircraft_id')
        ? 'Create new flight for ' . $aircrafts->firstWhere('id', request('aircraft_id'))['registration_number']
        : 'Create new flight';
@endphp

<div class="flex gap-2">
    <a href="{{ $createHref }}" class="btn btn-primary">
        {{ $createLabel }}
    </a>
</div>