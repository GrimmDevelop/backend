<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} geändert <a href="{{ route($activity->getRoute(), [$activity->getRouteModel()]) }}" title="Details"><span class="fa fa-link"></span></a>
</p>

<table class="table table-striped collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->after() as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td width="40%">{{ $activity->log['before'][$field] ?? '' }}</td>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>
