@props([
    'issues' => [],
    'role' => null,
])

@if(count($issues) > 0)
<div class="card bg-base-100 shadow-lg border-2 border-error">
    <div class="card-body">
        <h2 class="card-title text-error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            @if($role === 'planner')
                Aircraft Issues Found ({{ count($issues) }})
            @elseif($role === 'disposition')
                Crew Issues Found ({{ count($issues) }})
            @else
                Aircraft & Crew Issues Found ({{ count($issues) }})
            @endif
        </h2>
        
        <div class="overflow-x-auto mt-4">
            <table class="table table-pin-rows table-pin-cols w-full">
                <thead>
                    <tr>
                        <th>Issue Type</th>
                        @if($role === 'ops')
                            <td>Aircraft/Crew</td>
                        @else
                            <td>{{ $role === 'planner' ? 'Aircraft' : 'Crew' }}</td>
                        @endif
                        <td>Description</td>
                        <td>First Flight</td>
                        <td>Second Flight</td>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($issues as $issue)
                    <tr class="hover:bg-base-200">
                        <th>
                            <span class="badge {{ $issue['severity'] === 'error' ? 'badge-error' : 'badge-warning' }} badge-lg whitespace-nowrap">
                                {{ $issue['type'] }}
                            </span>
                        </th>
                        <td>
                            @if(isset($issue['aircraft']))
                                <span class="font-bold">{{ $issue['aircraft']->registration_number }}</span>
                            @elseif(isset($issue['crew']))
                                <span class="font-bold whitespace-nowrap">Crew #{{ $issue['crew']->id }}</span>
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td>
                            <p class="text-sm">{{ $issue['description'] }}</p>
                        </td>
                        <td>
                            @if(isset($issue['flight_1']) && $issue['flight_1'])
                            <div class="flex flex-col gap-1">
                                <span class="font-bold">{{ $issue['flight_1']->flight_number }}</span>
                                <span class="text-xs text-gray-500">
                                    {{ $issue['flight_1']->departureAirport->icao_code }} → {{ $issue['flight_1']->arrivalAirport->icao_code }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ date('Y-m-d H:i', strtotime($issue['flight_1']->departure_time_scheduled)) }} - 
                                    {{ date('H:i', strtotime($issue['flight_1']->arrival_time_scheduled)) }}
                                </span>
                            </div>
                            @else
                            <span class="text-gray-500 text-sm">—</span>
                            @endif
                        </td>
                        <td>
                            @if(isset($issue['flight_2']) && $issue['flight_2'])
                            <div class="flex flex-col gap-1">
                                <span class="font-bold">{{ $issue['flight_2']->flight_number }}</span>
                                <span class="text-xs text-gray-500">
                                    {{ $issue['flight_2']->departureAirport->icao_code }} → {{ $issue['flight_2']->arrivalAirport->icao_code }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ date('Y-m-d H:i', strtotime($issue['flight_2']->departure_time_scheduled)) }} - 
                                    {{ date('H:i', strtotime($issue['flight_2']->arrival_time_scheduled)) }}
                                </span>
                            </div>
                            @else
                            <span class="text-gray-500 text-sm">—</span>
                            @endif
                        </td>
                        <th>
                            @if(isset($issue['flight_1']) && $issue['flight_1'])
                            <div class="flex gap-2">
                                <a href="{{ route($role . '.flights.edit', $issue['flight_1']->id) }}" class="btn btn-sm btn-warning">
                                    Edit First
                                </a>
                                @if(isset($issue['flight_2']) && $issue['flight_2'])
                                <a href="{{ route($role . '.flights.edit', $issue['flight_2']->id) }}" class="btn btn-sm btn-warning">
                                    Edit Second
                                </a>
                                @endif
                            </div>
                            @else
                            <span class="text-gray-500 text-sm">—</span>
                            @endif
                        </th>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Issue Type</th>
                        @if($role === 'ops')
                            <td>Aircraft/Crew</td>
                        @else
                            <td>{{ $role === 'planner' ? 'Aircraft' : 'Crew' }}</td>
                        @endif
                        <td>Description</td>
                        <td>First Flight</td>
                        <td>Second Flight</td>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endif
