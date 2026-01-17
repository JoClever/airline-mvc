@props([
    'role',
    'title',
    'subtitle' => null,
    'flights' => [],
    'issues' => [],
])

@php
    $filterShowAircraft = $role === 'ops' || $role === 'planner';
    $filterShowCrew = $role === 'ops' || $role === 'disposition';
    $filterShowUnassignedOnly = $role === 'disposition';
@endphp

<x-layout>
    <div class="{{ $role == 'ops' ? '' : 'max-w-7xl' }} mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>

        @if($role === 'planner')
            <x-flight-create-button />
        @endif

        <x-flight-filter
            :route="route($role . '.flights.index')"
            :clearRoute="route($role . '.flights.index')"
            :showAircraft="$filterShowAircraft"
            :showCrew="$filterShowCrew"
            :showUnassignedOnly="$filterShowUnassignedOnly"
        />

        <x-alert />

        <x-flight-issues :issues="$issues" :role="$role" />

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">
                    Flight Records
                </h2>
                <div class="overflow-x-auto mt-4">
                    <table class="table w-full table-pin-rows table-pin-cols">
                        <thead>
                            <tr>
                                @include('components.flight-table-header.' . $role)
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($flights as $flight)
                                @include('components.flight-table-rows.' . $role, ['flight' => $flight])
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                @include('components.flight-table-header.' . $role)
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if($flights->isEmpty())
                    <p class="text-center py-4 text-gray-600">No flights found.</p>
                @endif
            </div>
        </div>
    </div>
</x-layout>
