<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->formatted_title }}</h1>
            <p class="text-gray-600">Update crew assignments</p>
        </div>

        <x-alert />

        <x-edit-form 
            :type="'disposition'"
            :flight="$flight"
            :updateRoute="route('disposition.flights.update', ['flight' => $flight->id])"
            :cancelRoute="route('disposition.flights.show', ['flight' => $flight->id])"
        />
    </div>
</x-layout>