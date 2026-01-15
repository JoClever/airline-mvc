<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->flight_number }} {{ $flight->formatted_departure_date }}</h1>
            <p class="text-gray-600">View and manage crew assignments</p>
        </div>

        <x-show-form :type="'disposition'" :flight="$flight" />
    </div>
</x-layout>