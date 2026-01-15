<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->formatted_title }}</h1>
            <p class="text-gray-600">Edit flight information</p>
        </div>

        <x-alert />

        <x-edit-form 
            :type="'ops'"
            :flight="$flight"
            :updateRoute="route('ops.flights.update', ['flight' => $flight->id])"
            :cancelRoute="route('ops.flights.show', ['flight' => $flight->id])"
        />
    </div>
</x-layout>