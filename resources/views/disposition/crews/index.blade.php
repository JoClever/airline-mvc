<x-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-4xl font-bold mb-2">Crew Management</h1>
            <p class="text-gray-600">Track crew assignments, flight hours, and utilization</p>
        </div>

        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full table-pin-rows table-pin-cols">
                        <thead>
                            <tr>
                                <th>Crew ID</th>
                                <td>Flights (Today)</td>
                                <td>Flights (This Month)</td>
                                <td>Hours (Today)</td>
                                <td>Hours (This Month)</td>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crews as $crew)
                                <tr class="hover:bg-base-200 whitespace-nowrap">
                                    <th>
                                        #{{ $crew['id'] }}
                                    </th>
                                    <td>
                                        <span class="badge badge-info">{{ $crew->flights_day_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $crew->flights_month_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge">{{ $crew->hours_day ?? '0' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge">{{ $crew->hours_month ?? '0' }}</span>
                                    </td>
                                    <th>
                                        <form method="GET" action="{{ route('disposition.crews.show', ['crew' => $crew['id']]) }}">
                                            <button type="submit" class="btn btn-sm btn-info">View Details</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Crew ID</th>
                                <td>Flights (Today)</td>
                                <td>Flights (This Month)</td>
                                <td>Hours (Today)</td>
                                <td>Hours (This Month)</td>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if(count($crews) == 0)
                    <div class="alert alert-info mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>No crews available.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>