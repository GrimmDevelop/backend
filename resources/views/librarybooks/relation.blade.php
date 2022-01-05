@extends('layouts.app')

@section('title', $book->catalog_id . ': ' . $book->title . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ trans('librarybooks.relations.' . $name . '.name') }} hinzufügen: {{ $book->title }}</h1>
            </div>

            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="searchPerson" class="col-sm-2 col-form-label text-right">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('librarypeople/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       empty="Es wurde keine Person gefunden!"
                            >
                                <template slot="list-item" slot-scope="props">
                                    @{{ props.item.name }}
                                </template>
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form id="book-editor" action="{{ route('librarybooks.relation', [$book, $name]) }}"
                      class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="form-group row {{ $errors->has('person') ? ' has-error' : '' }}">
                        <input type="hidden" name="person" :value="person.id">
                        <label class="col-sm-2 col-form-label text-right">Person</label>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.name">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" readonly
                                   :value="person.note">
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

                    <div class="button-bar row">
                        <div class="col-sm-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">Verknüpfung speichern</button>
                            <a href="{{ route('librarybooks.show', [$book]) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>

                <hr>

                <form action="{{ route('librarypeople.store') }}"
                      class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-10 offset-md-2">
                            <p>Person noch nicht vorhanden? Neue anlegen...</p>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('book') ? ' has-error' : '' }}">
                        <div class="offset-sm-2 col-sm-10">
                            @if ($errors->has('book'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('book') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('relation') ? ' has-error' : '' }}">
                        <div class="offset-sm-2 col-sm-10">
                            @if ($errors->has('relation'))
                                <span class="form-text">
                                    <strong>{{ $errors->first('relation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="book" value="{{ $book->id }}">
                    <input type="hidden" name="relation" value="{{ $name }}">

                    @include('partials.form.field', ['field' => 'name', 'model' => 'librarypeople'])
                    @include('partials.form.field', ['field' => 'note', 'model' => 'librarypeople'])

                    <div class="button-bar row">
                        <div class="col-sm-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">Person speichern</button>
                            <a href="{{ route('librarybooks.show', [$book]) }}"
                               class="btn btn-link">Abbrechen</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/library-relation.js') }}"></script>
@endsection
