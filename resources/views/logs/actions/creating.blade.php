<p>
    {{ trans($activity->getType() . '.' . $activity->getType(false)) }} erstellt <a href="{{ route($activity->getType().'.show', [$activity->model]) }}" title="Details"><span class="fa fa-link"></span></a>
</p>

<table class="table table-striped collapse" id="activity-{{ $activity->id }}">
    @foreach($activity->log['after'] as $field => $value)
        <tr>
            <th width="20%">{{ trans($activity->getType() . '.' . $field) }}</th>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
</table>
