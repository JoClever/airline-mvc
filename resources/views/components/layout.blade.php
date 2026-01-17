<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Airline') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <nav class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>
            <ul
                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('planner.flights.index') }}">Planner</a></li>
                <li>
                    <a>Disposition</a>
                    <ul class="p-2">
                        <li><a href="{{ route('disposition.flights.index') }}">Flights</a></li>
                        <li><a href="{{ route('disposition.crews.index') }}">Crews</a></li>
                    </ul>
                </li>
                <li>
                    <a>Operations</a>
                    <ul class="p-2">
                        <li><a href="{{ route('ops.flights.index') }}">Flights</a></li>
                        <li><a href="{{ route('ops.crews.index') }}">Crews</a></li>
                    </ul>
                </li>
            </ul>
            </div>
            <a class="btn btn-ghost text-xl" href="{{ route('home') }}">{{ config('app.name', 'Airline') }}</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('planner.flights.index') }}">Planner</a></li>
            <li>
                <details>
                    <summary>Disposition</summary>
                    <ul class="p-2 bg-base-100 w-40 z-1">
                        <li><a href="{{ route('disposition.flights.index') }}">Flights</a></li>
                        <li><a href="{{ route('disposition.crews.index') }}">Crews</a></li>
                    </ul>
                </details>
            </li>
            <li>
                <details>
                    <summary>Operations</summary>
                    <ul class="p-2 bg-base-100 w-40 z-1">
                        <li><a href="{{ route('ops.flights.index') }}">Flights</a></li>
                        <li><a href="{{ route('ops.crews.index') }}">Crews</a></li>
                    </ul>
                </details>
            </ul>
        </div>
    </nav>

    @if(session('success'))
        <div class="w-max m-auto alert alert-success shadow-lg my-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="w-max m-auto alert alert-error shadow-lg my-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2 2l2 2m0 0l2 2m-2-2l-2 2" /></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <main class="p-4">
        {{ $slot }}
    </main>

    <footer class="footer footer-center p-4 bg-base-200 text-base-content">
        <div>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Airline') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>