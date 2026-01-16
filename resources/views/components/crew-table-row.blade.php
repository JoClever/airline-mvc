@props([
    'crew',
    'role',
])

<tr class="hover:bg-base-200 whitespace-nowrap">
    <th>
        #{{ $crew->id }}
    </th>
    <td>
        <span class="badge badge-{{ $crew->flights_day_count ? ($crew->flights_day_limit ? 'error' : 'success') : 'neutral' }}">{{ $crew->flights_day_count }}</span>
    </td>
    <td>
        <span class="badge badge-{{ $crew->flights_month_count ? ($crew->flights_month_limit ? 'error' : 'success') : 'neutral' }}">{{ $crew->flights_month_count }}</span>
    </td>
    <td>
        <span class="badge badge-{{ $crew->hours_day ? ($crew->hours_day_limit ? 'error' : 'success') : 'neutral' }}">{{ $crew->hours_day }}</span>
    </td>
    <td>
        <span class="badge badge-{{ $crew->hours_month ? ($crew->hours_month_limit ? 'error' : 'success') : 'neutral' }}">{{ $crew->hours_month }}</span>
    </td>
    <th>
        <form method="GET" action="{{ route($role . '.crews.show', ['crew' => $crew['id']]) }}">
            <button type="submit" class="btn btn-sm btn-info">View Details</button>
        </form>
    </th>
</tr>