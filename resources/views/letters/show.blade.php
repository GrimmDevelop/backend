@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <div class="container" id="letter">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1 data-toggle="tooltip"
                    data-placement="bottom"
                    title="{{ addslashes($letter->title()) }}">
                    <a class="prev-link"
                       href="{{ referrer_url('last_letter_index', route('letters.index'), '#letter-' . $letter->id) }}">
                        <i class="fa fa-caret-left"></i></a> Briefdaten: {{ str_limit($letter->title(), 60) }}
                </h1>
            </div>

            @if($letter->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Die Person wurde gelöscht</h4>
                                    <p>Das bedeutet, dass sie nicht mehr sichtbar ist.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 delete-btn-container">
                            <form action="{{-- route('letters.restore', [$letter->id]) --}}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" disabled class="btn">Wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 page-content">
                <form class="form-horizontal" action="{{ route('letters.update', [$letter]) }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'code', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'date', 'model' => $letter])

                    @include('partials.form.boolean', ['field' => 'valid', 'model' => $letter])

                    @include('partials.form.textarea', ['field' => 'inc', 'model' => $letter, 'rows' => 3])
                    @include('partials.form.field', ['field' => 'couvert', 'model' => $letter])

                    @if($letter->couvert != null)
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @foreach($letter->getMedia('letters.scans.couvert') as $index => $media)
                                    <a href="{{ route('letters.scans.index', [$letter]) }}#scan-{{ $media->id }}"><img
                                                src="{{ $media->getFullUrl() }}" style="width: 10%;"></a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @include('partials.form.boolean', ['field' => 'copy_owned', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'language', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'copy', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'attachment', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'directory', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'handwriting_location', 'model' => $letter])

                    @if($letter->handwriting_location != null)
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @foreach($letter->getMedia('letters.scans.handwriting_location') as $index => $media)
                                    <a href="{{ route('letters.scans.index', [$letter]) }}#scan-{{ $media->id }}"><img
                                                src="{{ $media->getFullUrl() }}" style="width: 10%;"></a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @unless($letter->trashed())
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @can('library.update')
                                    <a href="{{ route('letters.scans.index', [$letter]) }}" role="button"
                                       class="btn btn-lg btn-default">
                                        <span class="fa fa-picture-o"></span>
                                        Scans verwalten
                                    </a>
                                @endcan
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @can('library.update')
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-floppy-o"></span>
                                        Speichern
                                    </button>

                                    <button type="reset" class="btn btn-link">
                                        Änderungen zurücksetzen
                                    </button>
                                @endcan
                            </div>
                        </div>
                    @endunless
                </form>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#send" data-toggle="tab">Sende-Daten</a>
                    </li>
                    <li>
                        <a href="#receive" data-toggle="tab">Empf.-Daten</a>
                    </li>
                    <li>
                        <a href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li>
                        <a href="#drafts" data-toggle="tab">Entwürfe</a>
                    </li>
                    <li>
                        <a href="#facsimiles" data-toggle="tab">Faksimiles</a>
                    </li>
                    <li>
                        <a href="#information" data-toggle="tab">Informationen</a>
                    </li>
                    <li>
                        <a href="#changes" data-toggle="tab">Änderungsverlauf</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="send">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputFrom">{{ trans('letters.from') }}</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">
                                        {{ $letter->from->historical_name ?? '[unbekannt]' }}

                                        <a href="{{-- route('letters.location', [$letter, 'from']) --}}">
                                            <span class="fa fa-pencil"></span>
                                        </a>
                                    </p>
                                </div>
                            </div>

                            @foreach($letter->senders() as $sender)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"
                                           for="inputFrom">{{ trans('letters.sender') }}</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            @if($sender->person)
                                                <a href="{{ route('people.show', [$sender->person]) }}"
                                                   data-toggle="tooltip"
                                                   title="Person öffnen">
                                                    {{ $sender->person->fullName() }}

                                                    @if($sender->person->fullName() != $sender->assignment_source)
                                                        [{{ $sender->assignment_source }}]
                                                    @endif
                                                </a>

                                                -

                                                <a href="{{ route('letters.index') }}?correspondence={{ $sender->person->id }}">
                                            <span class="fa fa-envelope" data-toggle="tooltip"
                                                  title="Correspondence filtern"></span>
                                                </a>
                                            @else
                                                <a href="{{ route('letters.assign-person', [$sender]) }}">
                                                    {{ $sender->assignment_source ?? '[unbekannt]' }}
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            @include('partials.form.field', ['field' => 'from_source', 'model' => $letter])
                            @include('partials.form.field', ['field' => 'from_date', 'model' => $letter])
                            @include('partials.form.field', ['field' => 'reconstructed_from', 'model' => $letter])
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="receive">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputFrom">{{ trans('letters.to') }}</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">
                                        {{ $letter->to->historical_name ?? '[unbekannt]' }}

                                        <a href="{{-- route('letters.location', [$letter, 'to']) --}}">
                                            <span class="fa fa-pencil"></span>
                                        </a>
                                    </p>
                                </div>
                            </div>

                            @foreach($letter->receivers() as $receiver)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"
                                           for="inputFrom">{{ trans('letters.receiver') }}</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            @if($receiver->person)
                                                <a href="{{ route('people.show', [$receiver->person]) }}"
                                                   data-toggle="tooltip"
                                                   title="Person öffnen">
                                                    {{ $receiver->person->fullName() }}

                                                    @if($receiver->person->fullName() != $receiver->assignment_source)
                                                        [{{ $receiver->assignment_source }}]
                                                    @endif
                                                </a>

                                                -

                                                <a href="{{ route('letters.index') }}?correspondence={{ $receiver->person->id }}">
                                            <span class="fa fa-envelope" data-toggle="tooltip"
                                                  title="Correspondence"></span>
                                                </a>
                                            @else
                                                <a href="{{ route('letters.assign-person', [$receiver]) }}">
                                                    {{ $receiver->assignment_source ?? '[unbekannt]' }}
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            @include('partials.form.field', ['field' => 'to_date', 'model' => $letter])
                            @include('partials.form.field', ['field' => 'receive_annotation', 'model' => $letter])
                            @include('partials.form.field', ['field' => 'reply_annotation', 'model' => $letter])
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="prints">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addPrint">
                                    <i class="fa fa-plus"></i> Druck hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="print in prints" is="in-place-editor"
                                :item-id="print.id" :item-entry="print.entry" :item-year="print.year"
                                base-url="{{ route('letters.prints.index', [$letter->id]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.prints.store', [$letter]) }}"
                                         :on-stored="stored"
                                         modal="addPrint"
                                         title="Drucke"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="drafts">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addDraft">
                                    <i class="fa fa-plus"></i> Entwurf hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="draft in drafts" is="in-place-editor"
                                :item-id="draft.id" :item-entry="draft.entry" :item-year="draft.year"
                                base-url="{{ route('letters.drafts.index', [$letter->id]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.drafts.store', [$letter]) }}"
                                         :on-stored="stored"
                                         modal="addDraft"
                                         title="Drucke"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="facsimiles">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addFacsimile">
                                    <i class="fa fa-plus"></i> Faksimile hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="facsimile in facsimiles" is="in-place-editor"
                                :item-id="facsimile.id" :item-entry="facsimile.entry" :item-year="facsimile.year"
                                base-url="{{ route('letters.facsimiles.index', [$letter->id]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.facsimiles.store', [$letter]) }}"
                                         :on-stored="stored"
                                         modal="addFacsimile"
                                         title="Faksimile"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="information">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 25%;">Code</th>
                                <th>Wert</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($letter->information as $information)
                                <tr class="@if($information->code->error_generated) bg-danger @endif">
                                    <td>{{ $information->code->name }}</td>
                                    <td>{{ $information->data }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="changes">
                        @include('logs.entity-activity', ['entity' => $letter])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var BASE_URL = "{{ route('letters.show', [$letter]) }}";
        var LETTERS_FACSIMILE_STORE_URL = "{{ route('letters.facsimiles.store', [$letter]) }}";
    </script>
    <script src="{{ url('js/letter.js') }}"></script>
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
