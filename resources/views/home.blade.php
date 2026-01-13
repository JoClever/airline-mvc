<x-layout>
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Welcome to the Airline Management System</h1>
            <p class="text-gray-600 text-lg">Manage flights, crews, and operations efficiently</p>
        </div>
    </div>

    <div class="card w-sm bg-base-200 card-lg shadow-sm m-auto">
        <div class="card-body items-center text-center">
            <h2 class="card-title">Login</h2>
            <p class="mb-4">Log into one of the following roles:</p>
            <div class="card-actions justify-end flex-col items-center">
                <a href="{{ route('planner.dashboard') }}" class="btn btn-primary">Planner</a>
                <a href="{{ route('disposition.dashboard') }}" class="btn btn-secondary">Disposition</a>
                <a href="{{ route('ops.dashboard') }}" class="btn btn-accent">Operations</a>
            </div>
        </div>
    </div>
</x-layout>
