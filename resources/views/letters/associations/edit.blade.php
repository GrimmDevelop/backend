@extends('layouts.app')

@section('content')
    <div class="container" id="associations">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link" href="{{ route('letters.show', [$letter]) }}"><i
                                class="fa fa-caret-left"></i></a> Personen
                    in {{ \Illuminate\Support\Str::limit($letter->title(), 60) }}
                </h1>
            </div>
            <div class="col-md-12 page-content">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="bookTitle" class="col-sm-2 control-label">Brief:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                {{ $letter->title() }}
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="searchPerson" class="col-sm-2 control-label">Person suchen:</label>
                        <div class="col-sm-10">
                            <typeahead id="searchPerson"
                                       placeholder="Person suchen"
                                       src="{{ url('people/search') }}?name="
                                       :prepare-response="prepareResponse"
                                       :on-hit="personSelected"
                                       empty="Es wurde keine Person gefunden!"
                                       ref="searchPerson">
                                <template slot="list-item" slot-scope="props">
                                    @{{ props.item.last_name }}, @{{ props.item.first_name }} <em
                                            class='pull-right'>@{{ props.item.bio_data }}</em>
                                </template>
                            </typeahead>
                        </div>
                    </div>
                </form>

                <form action="{{ route('letters.associations.update', [$letter, $association]) }}" class="form-horizontal"
                      method="POST">
                    {{ csrf_field() }}
                    {{ method_field('put') }}

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

                    <div class="form-group{{ $errors->has('assignment_source') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label"
                               for="inputAssignmentSource">{{ trans('letters.assignment_source') }}</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="inputAssignmentSource"
                                   name="{{ 'assignment_source' }}"
                                   :placeholder="placeholder"
                                   value="{{ old('assignment_source', $association->assignment_source) }}">
                            @if ($errors->has('assignment_source'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('assignment_source') }}</strong>
                                </span>
                            @endif
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.PERSON_MODEL = {!! json_encode($association->person) !!};
    </script>
    <script src="{{ url('js/letters/associations.js') }}"></script>
@endsection
