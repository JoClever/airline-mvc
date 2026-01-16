@props([
    'flight',
    'type' => null
])

<form class="card bg-base-100 shadow-lg m-auto">
    <div class="card-body">
        
        <x-flight-show-form.planner :flight="$flight" />

        @if (($type) === 'ops' || ($type) === 'disposition')

        <x-flight-show-form.disposition :flight="$flight" />

        @endif

        @if (($type ?? null) === 'ops')

        <x-flight-show-form.ops :flight="$flight" />

        @endif

        <div class="card-actions justify-between pt-4">
            <a href="{{ route($type . '.flights.index') }}" class="btn btn-outline">Back to List</a>
            <div class="flex gap-2">
                <a href="{{ route($type . '.flights.edit', $flight) }}" class="btn btn-warning">Edit Flight</a>
            </div>
        </div>
    </div>
</form>