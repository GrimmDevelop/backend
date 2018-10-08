@extends('layouts.app')

@section('title', $book->catalog_id . ': ' . $book->title . ' | ')

@section('content')
    <div class="container" id="app-container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <div class="button-container">
                    <div class="generic">
                        <a href="{{ route('librarybooks.create') }}" role="button" class="btn btn-default btn-sm">
                            <span class="fa fa-plus"></span>
                            {{ trans('librarybooks.store') }}
                        </a>
                    </div>
                </div>
                <h1><a class="prev-link"
                       href="{{ referrer_url('last_book_index', route('librarybooks.index'), '#book-' . $book->id) }}"><i
                                class="fa fa-caret-left"></i></a> Buchdaten: {{ $book->title }}</h1>
            </div>
            @if($book->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Das Buch wurde gelöscht</h4>
                                    <p>Das bedeutet, dass sie nicht mehr für die Veröffentlichung berücksichtigt wird
                                        und nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{ route('librarybooks.restore', [$book->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12 page-content">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#author" data-toggle="tab">{{ trans('librarybooks.relations.author.name') }}</a>
                    </li>
                    <li>
                        <a href="#editor" data-toggle="tab">{{ trans('librarybooks.relations.editor.name') }}</a>
                    </li>
                    <li>
                        <a href="#translator"
                           data-toggle="tab">{{ trans('librarybooks.relations.translator.name') }}</a>
                    </li>
                    <li>
                        <a href="#illustrator" data-toggle="tab">Illustrator</a>
                    </li>
                    <li>
                        <a href="#changes" data-toggle="tab">Änderungsverlauf</a>
                    </li>
                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="author">
                        @include('librarybooks.person_relation', ['name' => 'author'])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="editor">
                        @include('librarybooks.person_relation', ['name' => 'editor'])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="translator">
                        @include('librarybooks.person_relation', ['name' => 'translator'])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="illustrator">
                        @include('librarybooks.person_relation', ['name' => 'illustrator'])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="changes">
                        @include('logs.entity-activity', ['entity' => $book])
                    </div>
                </div>

                <div class="clearfix"></div>

                <div style="margin: 2.5em 0; border-bottom: 1px solid #e2e2e2;"></div>

                <form id="book-editor" action="{{ route('librarybooks.update', [$book->id]) }}"
                      class="form-horizontal"
                      method="POST" ref="bookForm"
                      @change="inputChanged = true">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <input type="hidden" name="prev_title" value="{{ $book->title }}">

                    @include('partials.form.field', ['field' => 'catalog_id', 'model' => $book, 'disabled' => $book->trashed()])

                    @include('partials.form.textarea', ['field' => 'denecke_teitge', 'model' => $book, 'disabled' => $book->trashed()])

                    @include('partials.form.field', ['field' => 'title', 'model' => $book, 'disabled' => $book->trashed()])

                    @include('partials.form.field', ['field' => 'series_title', 'model' => $book, 'disabled' => $book->trashed()])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <a href @click.prevent="moreFields = !moreFields">
                                weitere Felder

                                <span class="fa fa-caret-down" v-show="!moreFields"></span>
                                <span class="fa fa-caret-up" v-show="moreFields"></span>
                            </a>
                        </div>
                    </div>

                    <div v-show="moreFields">
                        @include('partials.form.field', ['field' => 'volumes', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'vols_year', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'numbers', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'place', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'publisher', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'year', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'pages', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'handwritten_dedication', 'model' => $book, 'disabled' => $book->trashed()])

                        @include('partials.form.field', ['field' => 'notes_jg', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'notes_wg', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'notes_other', 'model' => $book, 'disabled' => $book->trashed()])

                        @include('partials.form.field', ['field' => 'particularities', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'place_of_storage', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'purchase_number', 'model' => $book, 'disabled' => $book->trashed()])
                        @include('partials.form.field', ['field' => 'shelf_mark', 'model' => $book, 'disabled' => $book->trashed()])

                        @include('partials.form.field', ['field' => 'tales_comm_1856', 'model' => $book, 'disabled' => $book->trashed()])

                        @include('partials.form.field', ['field' => 'external_digitization', 'model' => $book, 'disabled' => $book->trashed()])
                    </div>
                </form>
            </div>
        </div>
    </div>
    <portal to="help-modal-body">
        Test
    </portal>

    <portal to="status-bar-left">
        @can('library.delete')
            @unless($book->trashed())
                <form id="danger-zone" action="{{ route('librarybooks.destroy', [$book->id]) }}"
                      method="post"
                      class="form-inline">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button class="btn btn-danger">
                        <span class="fa fa-trash"></span>
                        {{ trans('librarybooks.delete') }}
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
                <button type="button" class="btn btn-default" @click="form.reset()">
                    Änderungen verwerfen
                </button>
                <a href="{{ referrer_url('last_book_index', route('librarybooks.index')) }}"
                   class="btn btn-default">
                    Abbrechen
                </a>
            @endunless
        @endcan

    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/library-book.js') }}"></script>
@endsection
