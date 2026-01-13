<x-layout>
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight Operations</h1>
            <p class="text-gray-600 text-lg">Manage flight operations</p>
        </div>
    </div>

    <div class="card w-sm bg-base-200 card-lg shadow-sm m-auto">
        <div class="card-body items-center text-center">
            <h2 class="card-title">Index</h2>
            <p class="mb-4">Manage one of the following ressources:</p>
            <div class="card-actions justify-end flex-col items-center">
                <a href="{{ route('ops.flights.index') }}" class="btn btn-primary">Flights</a>
                <a href="{{ route('ops.crews.index') }}" class="btn btn-secondary">Crews</a>
            </div>
        </div>
    </div>
</x-layout>
