<div class="col-md-12">
    <h3>{{ trans('librarybooks.relations.' . $name . '.name') }}</h3>

    <div class="button-container">
        <div class="generic">
            <a href="{{ route('librarybooks.relation', [$book, $name]) }}"
               role="button" class="btn btn-default btn-sm"
               @click="checkForChanges">
                <span class="fa fa-plus"></span>
                {{ trans('librarybooks.relations.' . $name . '.name') }} hinzufügen
            </a>
        </div>
    </div>

    <table class="table table-striped">
        <tr>
            <th width="10%">#</th>
            <th width="45%">Name</th>
            <th width="40%">Notizen</th>
            <th width="5%"></th>
        </tr>
        @forelse($book->{str_plural($name)} as $person)
            <tr>
                <td>
                    <a href="{{ route('librarypeople.show', [$person]) }}">
                        {{ $person->id }}
                    </a>
                </td>
                <td>
                    {{ $person->name }}
                </td>
                <td>
                    {{ $person->note }}
                </td>
                <th>
                    <a href @click.prevent="deleteRelation({{ $book->id }}, '{{ $name }}', '{{ $person->id }}')"
                       role="button" class="btn btn-danger"
                       data-toggle="tooltip"
                       title="Verknüpfung aufheben (löscht nicht die Person)">
                        &times;
                    </a>
                </th>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align: center;">
                    <a href="{{ route('librarybooks.relation', [$book, $name]) }}"
                       @çlick="checkForChanges">
                        {{ trans('librarybooks.relations.' . $name . '.empty') }}
                    </a>
                </td>
            </tr>
        @endforelse
    </table>
</div>