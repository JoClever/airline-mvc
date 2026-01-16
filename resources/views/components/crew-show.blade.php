@props([
    'role',
    'crew',
    'subtitle' => 'View crew details',
])

<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Crew {{ $crew->id }}</h1>
            <p class="text-gray-600">{{ $subtitle }}</p>
        </div>

        <x-warnings />

        <x-crew-show-form :role="$role" :crew="$crew" />

        <x-crew-show-flights :role="$role" :crew="$crew" />

        <x-crew-show-transfers :role="$role" :crew="$crew" />
    </div>
</x-layout>