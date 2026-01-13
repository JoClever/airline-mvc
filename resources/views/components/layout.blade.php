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
    {{-- <nav>
        <div>
            <div>
                <div>
                    <a href="{{ route('planner.flights.index') }}">
                        Airline
                    </a>
                </div>
                <div>
                    <a href="{{ route('planner.flights.index') }}" {{ request()->routeIs('planner.*') ? 'class="active"' : '' }}>
                        Planner
                    </a>
                    <a href="{{ route('disposition.flights.index') }}" {{ request()->routeIs('disposition.*') ? 'class="active"' : '' }}>
                        Disposition
                    </a>
                </div>
            </div>
        </div>
    </nav> --}}

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div>
            {{ session('error') }}
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    {{-- <footer>
        <div>
            <p>&copy; {{ date('Y') }} Airline MVC. All rights reserved.</p>
        </div>
    </footer> --}}
</body>
</html>