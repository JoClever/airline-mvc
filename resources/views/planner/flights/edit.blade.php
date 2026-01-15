<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->formatted_title }}</h1>
            <p class="text-gray-600">Modify flight details</p>
        </div>

        <x-alert />

        <x-edit-form 
            :type="'planner'"
            :flight="$flight"
            :updateRoute="route('planner.flights.update', ['flight' => $flight->id])"
            :cancelRoute="route('planner.flights.show', ['flight' => $flight->id])"
        />
    </div>
</x-layout>
