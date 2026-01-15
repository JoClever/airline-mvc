@props(['flight', 'type' => null, 'updateRoute', 'cancelRoute'])

<form method="POST" action="{{ $updateRoute }}" class="card bg-base-100 shadow-lg m-auto">
    @csrf
    @method('PUT')
    <div class="card-body">
        @if ($type == 'planner')

        <x-edit-form.planner :flight="$flight" />

        @else
        
        <x-show-form.planner :flight="$flight" />

        @endif

        @if ($type == 'disposition' || $type == 'ops')

        <x-edit-form.disposition :flight="$flight" />

        @endif

        @if ($type == 'ops')

        <x-edit-form.ops :flight="$flight" />

        @endif

        <div class="card-actions justify-between pt-4">
            <a href="{{ $cancelRoute }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-warning">Save Changes</button>
        </div>
    </div>
</form>