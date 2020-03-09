@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link"
                       href="{{ referrer_url('last_book_index', route('books.index'), "#book-" . $book->id) }}"><i
                            class="fa fa-caret-left"></i></a> Buchdaten</h1>
            </div>
            @if($book->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 offset-md-1">
                            <div class="media">
                                <div class="media-left">
                                    <span class="fa fa-trash-o fa-5x"></span>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Das Buch wurde gelöscht</h4>
                                    <p>Das bedeutet, dass dieses nicht mehr für die Veröffentlichung berücksichtigt wird
                                        und nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{ route('books.restore', [$book->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12 page-content">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('books.update', [$book]) }}"
                          method="post" ref="bookForm">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        @include('partials.form.field', ['field' => 'short_title', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'title', 'model' => $book, 'disabled' => $book->trashed()])
                        {{-- @include('partials.form.field', ['field' => 'year', 'model' => $book]) --}}
                        @include('partials.form.field', ['field' => 'volume', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'volume_irregular', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'edition', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'source', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.textarea', ['field' => 'notes', 'model' => $book, 'disabled' => $book->trashed()])


                        @include('partials.form.boolean', ['field' => 'grimm', 'model' => $book, 'disabled' => $book->trashed()])

                    </form>
                </div>

                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#associations" data-toggle="tab">Assoziationen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#changes" data-toggle="tab">Änderungsverlauf</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane show active" id="associations">
                        @unless($book->trashed())
                            <div class="add-button">
                                <a href="{{ route('books.associations.index', [$book]) }}"
                                   class="btn btn-primary btn-sm">
                                    <span class="fa fa-plus"></span> Person hinzufügen
                                </a>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nachname</th>
                                <th>Vorname</th>
                                <th>Seite</th>
                                <th>Zeile</th>
                                <th>Notiz</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($book->personAssociations as $personAssociation)
                                <tr>
                                    <td>
                                        <a href="{{ route('people.show', [$personAssociation->person]) }}">{{ $personAssociation->person->id }}</a>
                                    </td>
                                    <td>{{ $personAssociation->person->last_name }}</td>
                                    <td>{{ $personAssociation->person->first_name }}</td>
                                    <td>
                                        {{ $personAssociation->page }}
                                        @if($personAssociation->page_to)
                                            bis {{ $personAssociation->page_to }}
                                        @endif
                                    </td>
                                    <td>{{ $personAssociation->line }}</td>
                                    <td>{{ $personAssociation->page_description }}</td>
                                    <td>
                                        <a href="{{ route('people.book', [$personAssociation->id]) }}"
                                           data-toggle="tooltip" data-title="Verknüpfung">
                                            <span class="fa fa-link"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="changes">
                        @include('logs.entity-activity', ['entity' => $book])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <portal to="help-modal-body"></portal>

    <portal to="status-bar-left">
        @can('books.delete')
            @unless($book->trashed())
                <form id="danger-zone" action="{{ route('books.destroy', [$book]) }}"
                      method="post" class="form-inline">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button class="btn btn-danger">
                        <span class="fa fa-trash"></span>&nbsp;
                        {{ trans('books.delete') }}
                    </button>
                </form>
            @endunless
        @endcan
    </portal>
    <portal to="status-bar-right">
        @can('library.update')
            @unless($book->trashed())
                <button type="button" class="btn btn-primary" @click="form.submit()">
                    <span class="fa fa-floppy-o"></span>
                    Speichern
                </button>

                <button type="button" class="btn btn-secondary" @click="form.reset()">
                    Änderungen verwerfen
                </button>

                <a href="{{ referrer_url('last_book_index', route('books.index')) }}"
                   class="btn btn-secondary">
                    Abbrechen
                </a>
            @endunless
        @endcan
    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/library-book.js') }}"></script>
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
