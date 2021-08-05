@extends('layouts.app')

@section('title', $person->fullName() . ' | ')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                @if($person->hasCorrespondence())
                    <div class="button-container">
                        <div class="generic">
                            <a href="{{ route('letters.index') }}?correspondence={{ $person->id }}" role="button"
                               class="btn btn-default btn-sm">
                                <span class="fa fa-envelope"></span>
                                {{ trans('people.correspondence') }}
                            </a>
                        </div>
                    </div>
                @endif
                <h1><a class="prev-link"
                       href="{{ referrer_url('last_person_index', route('people.index'), '#person-' . $person->id) }}"><i
                                class="fa fa-caret-left"></i></a> Personendaten: {{ $person->fullName() }}</h1>
            </div>
            @if($person->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Die Person wurde gelöscht</h4>
                                    <p>Das bedeutet, dass sie nicht mehr für die Veröffentlichung berücksichtigt wird
                                        und nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{ route('people.restore', [$person->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12 page-content">
                <form id="person-editor" action="{{ route('people.update', ['people' => $person->id]) }}"
                      class="form-horizontal" ref="personForm"
                      method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="prev_last_name" value="{{ $person->last_name }}">
                    <input type="hidden" name="prev_first_name" value="{{ $person->first_name }}">
                    @include('partials.form.field', ['field' => 'ddb_id', 'model' => $person])
                    @include('partials.form.field', ['field' => 'full_name', 'model' => $person, 'placeholder' => $person->fullName()])
                    @include('partials.form.field', ['field' => 'last_name', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'first_name', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'birth_date', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'death_date', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'bio_data', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'bio_data_source', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'add_bio_data', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.field', ['field' => 'source', 'model' => $person, 'disabled' => $person->trashed()])

                    @include('partials.form.boolean', ['field' => 'is_organization', 'model' => $person, 'disabled' => $person->trashed()])
                    @include('partials.form.boolean', ['field' => 'auto_generated', 'model' => $person, 'disabled' => $person->trashed()])

                </form>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li>
                        <a href="#inheritances" data-toggle="tab">Nachlässe</a>
                    </li>
                    <li>
                        <a href="#references" data-toggle="tab">Referenzen</a>
                    </li>
                    <li>
                        <a href="#books" data-toggle="tab">Bücher</a>
                    </li>
                    <li>
                        <a href="#information" data-toggle="tab">Informationen</a>
                    </li>
                    <li>
                        <a href="#changes" data-toggle="tab">Änderungsverlauf</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <prints-list index-url="{{ route('people.prints.index', [$person]) }}"
                                 store-url="{{ route('people.prints.store', [$person]) }}"
                    ></prints-list>
                    <inheritances-list index-url="{{ route('people.inheritances.index', [$person]) }}"
                                       store-url="{{ route('people.inheritances.store', [$person]) }}"
                    ></inheritances-list>
                    <references-list index-url="{{ route('people.references.index', [$person]) }}"
                                     store-url="{{ route('people.references.store', [$person]) }}"
                    ></references-list>
                    <div role="tabpanel" class="tab-pane" id="books">
                        @unless($person->trashed())
                            <div class="add-button">
                                @can('books.assign')
                                    <a href="{{ route('people.add-book', [$person->id]) }}" role="button"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-plus"></i> Buch hinzufügen
                                    </a>
                                @endcan
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th># Buch</th>
                                <th>Kurztitel</th>
                                <th>Titel</th>
                                <th>Seite</th>
                                <th>Zeile</th>
                                <th class="action-column"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->bookAssociations as $bookAssociation)
                                <tr>
                                    <td>{{ $bookAssociation->book->id }}</td>
                                    <td>{{ $bookAssociation->book->short_title }}</td>
                                    <td>{{ $bookAssociation->book->title }}</td>
                                    <td>
                                        {{ $bookAssociation->page }}
                                        @if($bookAssociation->page_to)
                                            bis {{ $bookAssociation->page_to }}
                                        @endif
                                    </td>
                                    <td>{{ $bookAssociation->line }}</td>
                                    <td class="action-column">
                                        <a href="{{ route('people.book', [$bookAssociation->id]) }}">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="information">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Wert</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($person->information as $information)
                                <tr class="@if($information->code->error_generated) bg-danger @endif">
                                    <td>{{ $information->code->name }}</td>
                                    <td>{{ $information->data }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="changes">
                        @include('logs.entity-activity', ['entity' => $person])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <portal to="help-modal-body"></portal>

    <portal to="status-bar-left"></portal>

    <portal to="status-bar-right">
        @can('people.update')
            @unless($person->trashed())
                <button type="button" class="btn btn-primary" @click="form.submit()">
                    <span class="fa fa-floppy-o"></span>
                    Speichern
                </button>

                <button type="button" class="btn btn-default" @click="form.reset()">
                    Änderungen verwerfen
                </button>
                <a href="{{ referrer_url('last_person_index', route('people.index')) }}"
                   class="btn btn-default">Abbrechen</a>
            @endunless
        @endcan

        @can('people.delete')
            @unless($person->trashed())
                <form id="danger-zone" action="{{ route('people.destroy', [$person->id]) }}"
                      style="display: inline-block; margin: 0;"
                      method="post"
                      class="form-inline">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button class="btn btn-danger">
                        <span class="fa fa-trash"></span>
                    </button>
                </form>
            @endunless
        @endcan
    </portal>
@endsection

@section('scripts')
    <script>
        window.BASE_URL = "{{ route('people.show', [$person->id]) }}";
    </script>
    <script src="{{ url('js/person.js') }}"></script>
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