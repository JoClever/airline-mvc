@props([
    'crew',
    'role' => null,
])

<div class="card bg-base-100 shadow-lg">
    <div class="card-body">
        <h2 class="card-title mb-4">Transfer Flights</h2>

        <div class="overflow-x-auto">
            <table class="table w-full table-pin-rows table-pin-cols">
                <thead>
                    <tr>
                        @include('components.flight-table-header.' . $role)
                    </tr>
                </thead>
                <tbody>
                    @foreach ($crew->transferFlights as $flight)
                        @include('components.flight-table-rows.' . $role, ['flight' => $flight])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        @include('components.flight-table-header.' . $role)
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($crew->transferFlights->isEmpty())

        <div class="alert alert-info mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>No transfer flights.</span>
        </div>

        @endif

    </div>
</div>