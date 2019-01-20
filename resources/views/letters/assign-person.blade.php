@extends('layouts.app')

@section('content')
    <div class="container" id="associations">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1 data-toggle="tooltip"
                    data-placement="bottom"
                    title="{{ addslashes($letter->title()) }}">
                    <a class="prev-link" href="{{ route('letters.show', [$letter]) }}"><i
                                class="fa fa-caret-left"></i></a> Personen
                    in {{ str_limit($letter->title(), 60) }}
                </h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="bookTitle" class="col-sm-2 control-label">Person:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                {{ $association->assignment_source ?? '?' }}
                            </p>
                        </div>
                    </div>

                    @include('partials.form.field', ['field' => 'inc', 'model' => $letter, 'disabled' => true])

                    <div class="form-group">
                        <label for="searchPerson" class="col-sm-2 control-label">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('people/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       empty="Es wurde keine Person gefunden!">
                                <template slot="list-item" slot-scope="props">
                                    @{{ props.item.last_name }}, @{{ props.item.first_name }} <em
                                            class='pull-right'>@{{ props.item.bio_data }}</em>
                                </template>
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form action="{{ route('letters.assign-person', [$association]) }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('person') ? ' has-error' : '' }}">
                        <input type="hidden" name="person" :value="person.id">
                        <label class="col-sm-2 control-label">Person</label>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.last_name">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.first_name">
                        </div>
                    </div>

                    <div class="form-group" v-if="person">
                        <div class="col-sm-offset-2 col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.bio_data">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.source">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('person') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-2 col-sm-10">
                            @if ($errors->has('person'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('person') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Alle Vorkommen verknüpfen?</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="associate_all" id="associate_all1"
                                       value="0" {{ checked(old('associate_all', 0), 0) }}>
                                Nein
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="associate_all" id="associate_all2"
                                       value="1" {{ checked(old('associate_all', 0), 1) }}>
                                Ja
                            </label>
                        </div>
                    </div>

                    <div class="button-bar row">
                        <div class="col-sm-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="{{ route('letters.show', [$letter]) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

                <table class="table table-striped" id="associations">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Vorkommen</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($people as $person)
                        <tr>
                            <td>{{ $person->last_name }}, {{ $person->first_name }}</td>
                            <td>
                                <p data-toggle="collapse" data-target="#associations-{{ $person->id }}"
                                   aria-expanded="false"
                                   class="collapsed collapse-head">
                                    {{ $person->letterAssociations->count() }} Briefe
                                </p>
                                <table class="table collapse" id="associations-{{ $person->id }}">
                                    <tbody>
                                    @foreach($person->letterAssociations->take(15) as $association)
                                        <tr>
                                            <td>
                                                {{ $association->letter->title() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($person->letterAssociations->count() > 15)
                                        <tr>
                                            <td>
                                                ...
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <button @click="fillOccurrenceForm({{ $person }})" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.BASE_URL = "{{ route('letters.show', [$letter]) }}";
    </script>
    <script src="{{ url('js/associations.js') }}"></script>
    <script>

        // Tab auto selection
        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        }

        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    </script>
@endsection
