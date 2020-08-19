@extends('layouts.app')

@section('content')
    <div class="container" id="associations">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ route('books.show', [$book]) }}"><i
                                class="fa fa-caret-left"></i></a> Personen
                    in {{ \Illuminate\Support\Str::limit($book->short_title, 60) }} {{-- isset($book->year) ? '(' . $book->year . ')' : '' --}}
                </h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    @include('partials.form.field', ['field' => 'short_title', 'model' => $book, 'disabled' => true])
                    @include('partials.form.field', ['field' => 'title', 'model' => $book, 'disabled' => true])
                    <div class="form-group row">
                        <label for="bookTitle" class="col-sm-2 col-form-label text-right">Band:</label>
                        <div class="col-sm-10">
                            <p class="form-control-plaintext">
                                {{ $book->volume or '?' }}
                                @if ($book->volume_irregular !== null)
                                    .{{ $book->volume_irregular }}
                                @endif
                                @if ($book->edition !== null)
                                    , {{ $book->edition }}. Auflage
                                @endif</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="searchPerson" class="col-sm-2 col-form-label text-right">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('people/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       empty="Es wurde keine Person gefunden!">
                                <template slot="list-item" slot-scope="props">
                                    @{{ props.item.last_name }}, @{{ props.item.first_name }} <em
                                            class='float-right'>@{{ props.item.bio_data }}</em>
                                </template>
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form action="{{ route('books.associations.store', [$book->id]) }}" class="form-horizontal"
                      method="POST" ref="associationsForm">
                    {{ csrf_field() }}

                    <div class="form-group row {{ $errors->has('person') ? ' has-error' : '' }}">
                        <input type="hidden" name="person" :value="person.id">
                        <label class="col-sm-2 col-form-label text-right">Person</label>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.last_name">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.first_name">
                        </div>
                    </div>

                    <div class="form-group row" v-if="person">
                        <div class="offset-sm-2 col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.bio_data">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.source">
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('person') ? ' has-error' : '' }}">
                        <div class="offset-sm-2 col-sm-10">
                            @if ($errors->has('person'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('person') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('page') || $errors->has('page_to') || $errors->has('line') ? ' has-error' : '' }}">
                        <label class="col-sm-2 col-form-label text-right">Seite</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page"
                                   ref="pageField"
                                   value="{{ old('page') }}">
                        </div>
                        <label class="col-sm-1 col-form-label" style="text-align: center;">bis</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="page_to"
                                   value="{{ old('page_to') }}">
                        </div>
                        <label class="col-sm-2 col-form-label text-right">Zeile</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="line"
                                   value="{{ old('line') }}">
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('page') || $errors->has('page_to') || $errors->has('line') ? ' has-error' : '' }}">
                        <div class="offset-sm-2 col-sm-10">
                            @if ($errors->has('page'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('page') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('page_to'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('page_to') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('line'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('line') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('page_description') ? ' has-error' : '' }}">
                        <label class="col-sm-2 col-form-label text-right">Notiz</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="page_description"
                                   value="{{ old('page_description') }}">

                            @if ($errors->has('page_description'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('page_description') }}</strong>
                                </span>
                            @endif
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
                    @foreach($persons as $person)
                        <tr>
                            <td>{{ $person->last_name }}, {{ $person->first_name }}</td>
                            <td>
                                <p data-toggle="collapse" data-target="#associations-{{ $person->id }}"
                                   aria-expanded="false"
                                   class="collapsed collapse-head">
                                    {{ $person->bookAssociations->count() }} Vorkommen, erstes auf
                                    Seite {{ $person->bookAssociations[0]->page }}
                                </p>
                                <table class="table collapse" id="associations-{{ $person->id }}">
                                    <tbody>
                                    @foreach($person->bookAssociations as $association)
                                        <tr>
                                            <td>
                                                Seite {{ $association->page }}
                                                @if($association->page_to)
                                                    - {{ $association->page_to }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($association->line)
                                                    Zeile {{ $association->line }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <button @click="fillOccurrenceForm({{ $person }})" class="btn btn-sm btn-primary">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <portal to="help-modal-body"></portal>

    <portal to="status-bar-right">
        @can('books.update')
            @unless($book->trashed())
                <button type="button" class="btn btn-primary" @click="form.submit()">
                    <span class="fa fa-floppy-o"></span>
                    Speichern
                </button>
                <button type="button" class="btn btn-secondary" @click="form.reset()">
                    Änderungen verwerfen
                </button>
                <a href="{{ route('books.show', [$book->id]) }}#books"
                   class="btn btn-secondary">Abbrechen</a>
            @endunless
        @endcan
    </portal>
@endsection

@section('scripts')
    <script>
        window.BASE_URL = "{{ route('books.show', [$book->id]) }}";
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
