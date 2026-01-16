@props([
    'role',
    'flight',
    'subtitle' => '',
])

<x-layout>
    <div class="max-w-xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Flight {{ $flight->formatted_title }}</h1>
            <p class="text-gray-600">{{ $subtitle }}</p>
        </div>

        <x-alert />

        <x-edit-form 
            :type="$role"
            :flight="$flight"
        />
    </div>
</x-layout>
