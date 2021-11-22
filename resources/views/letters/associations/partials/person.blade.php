@if($association->person)
    @if($association->person->stdName() != $association->assignment_source)
        {{ $association->assignment_source }}

        <a href="{{ route('people.show', [$association->person]) }}"
           data-toggle="tooltip"
           title="Person öffnen"
           style="margin-left: 2em;">
            <span>{{ $association->person->stdName() }}</span>
        </a>
    @else
        <a href="{{ route('people.show', [$association->person]) }}"
           data-toggle="tooltip"
           title="Person öffnen">
            <span>{{ $association->person->stdName() }}</span>
        </a>
    @endif

    <a href="{{ route('letters.index') }}?correspondence={{ $association->person->id }}"
       class="btn btn-secondary" data-toggle="tooltip"
       title="Korrespondenz"
       style="margin-left: 2em;">
        <span class="fa fa-envelope"></span>
    </a>
@else
    <a href="{{ route('letters.assign-person', [$association]) }}"
       data-toggle="tooltip"
       title="Person zuordnen"
       style="margin-right: 2em;">
        {{ $association->assignment_source ?? '[unbekannt]' }}
    </a>
@endif

<a href="{{ route('letters.associations.edit', [$letter, $association]) }}"
   class="btn btn-secondary" data-toggle="tooltip" title="Verknüpfung bearbeiten">
    <span class="fa fa-pencil"></span>
</a>

<button @click.prevent="deletePersonAssociation({{ $association->id }})"
   class="btn btn-link" data-toggle="tooltip" title="Verknüpfung löschen">
    <span class="fa fa-trash"></span>
</button>
