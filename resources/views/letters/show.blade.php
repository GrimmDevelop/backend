@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <portal to="help-modal-body"></portal>

    <portal to="status-bar-left">
        @can('library.update')
            <a href="{{ route('letters.scans.index', [$letter]) }}" role="button"
               class="btn btn-secondary">
                <span class="fa fa-picture-o"></span>
                Scans verwalten
            </a>

            <a href="{{ route('letters.apparatuses.index', [$letter]) }}" role="button"
               class="btn btn-secondary">
                <span class="fa fa-language"></span>
                Apparate und Sachkommentare
            </a>

            <a href="{{ route('letters.lettertext.index', [$letter]) }}" role="button"
               class="btn btn-secondary">
                <span class="fa fa-envelope-open-o  "></span>
                Brieftext
            </a>
        @endcan
    </portal>

    <portal to="status-bar-right">
        @can('library.update')
            @unless($letter->trashed())
                <button type="button" class="btn btn-primary" @click="form.submit()">
                    <span class="fa fa-floppy-o"></span>
                    Speichern
                </button>

                <button type="button" class="btn btn-secondary" @click="form.reset()">
                    Änderungen verwerfen
                </button>
                <a href="{{ referrer_url('last_letter_index', route('letters.index')) }}"
                   class="btn btn-secondary">
                    Abbrechen
                </a>
            @endunless
        @endcan

        @can('letters.delete')
            @unless($letter->trashed())
                <form id="danger-zone" action="{{ route('letters.destroy', [$letter]) }}"
                      style="display: inline-block; margin: 0;"
                      method="post"
                      class="form-inline">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button class="btn btn-danger">
                        <span class="fa fa-trash"></span>&nbsp;
                    </button>
                </form>
            @endunless
        @endcan
    </portal>

    <div class="container">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1 data-toggle="tooltip"
                    data-placement="bottom"
                    title="{{ addslashes($letter->title()) }}">
                    <a class="prev-link"
                       href="{{ referrer_url('last_letter_index', route('letters.index'), '#letter-' . $letter->id) }}">
                        <span class="fa fa-caret-left"></span></a> Briefdaten: {{ \Illuminate\Support\Str::limit($letter->title(), 60) }}
                </h1>
            </div>

            @if($letter->trashed())
                <div class="col-md-12 deleted-record-info">
                    <div class="row">
                        <div class="col-md-8 offset-md-1">
                            <div class="media">
                                <div class="media-left">
                                    <span class="fa fa-trash-o fa-5x"></span>
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading">Der Brief wurde gelöscht</h4>
                                    <p>Das bedeutet, dass er nicht mehr sichtbar ist.</p>
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
                <form class="form-horizontal" ref="letterForm"
                      action="{{ route('letters.update', [$letter]) }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">IDs</label>
                        <div class="col-sm-10">
                            <p class="form-control-plaintext">
                                {{ $letter->id_till_2018 }} [2018]
                                @if($letter->id_till_1997)
                                    &nbsp;&nbsp;<strong>|</strong>&nbsp;&nbsp;{{ $letter->id_till_1997 }} [1997]
                                @endif
                                @if($letter->id_till_1992)
                                    &nbsp;&nbsp;<strong>|</strong>&nbsp;&nbsp;{{ $letter->id_till_1992 }} [1992]
                                @endif
                            </p>
                        </div>
                    </div>


                    @include('partials.form.field', ['field' => 'code', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'date', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'outgoing_notice', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'from_location_historical', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'from_location_derived', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'from_date', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'to_location_historical', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'to_date', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'receive_annotation', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'reply_annotation', 'model' => $letter])

                    @include('partials.form.textarea', ['field' => 'addition', 'model' => $letter, 'rows' => 3])

                    @include('partials.form.textarea', ['field' => 'inc', 'model' => $letter, 'rows' => 3])

                    @include('partials.form.field', ['field' => 'couvert', 'model' => $letter])

                    @if($letter->couvert != null)
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                @foreach($letter->getMedia('letters.scans.couvert') as $index => $media)
                                    <a href="{{ route('letters.scans.index', [$letter]) }}#scan-{{ $media->id }}"><img
                                                src="{{ $media->getFullUrl() }}" style="width: 10%;"></a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @include('partials.form.field', ['field' => 'language', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'copy', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'directory', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'handwriting_location', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'reconstructed_from', 'model' => $letter])

                    @if($letter->handwriting_location != null)
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                @foreach($letter->getMedia('letters.scans.handwriting_location') as $index => $media)
                                    <a href="{{ route('letters.scans.index', [$letter]) }}#scan-{{ $media->id }}"><img
                                                src="{{ $media->getFullUrl('thumb') }}" style="width: 10%;"></a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <button type="submit" style="visibility: hidden;"></button>
                </form>

                <hr>

                <h3>Verknüpfungen</h3>

                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#send" data-toggle="tab">Sender</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#receive" data-toggle="tab">Empfänger</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#transcriptions" data-toggle="tab">Abschriften</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#attachments" data-toggle="tab">Beilagen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#auction_catalogues" data-toggle="tab">Auktionskataloge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#drafts" data-toggle="tab">Entwürfe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#facsimiles" data-toggle="tab">Faksimiles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#changes" data-toggle="tab">Änderungsverlauf</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="send">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right"
                                       for="inputFrom">{{ trans('letters.sender') }}</label>
                                <div class="col-sm-10">
                                    @foreach($letter->senders() as $sender)
                                        <p class="form-control-plaintext">
                                            @include('letters.associations.partials.person', ['association' => $sender])
                                        </p>
                                    @endforeach
                                    <p>
                                        <a class="btn btn-secondary"
                                           href="{{ route('letters.associations.create', [$letter]) }}?type=sender">
                                            <span class="fa fa-plus"></span>
                                            Absender hinzufügen
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="receive">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right"
                                       for="inputFrom">{{ trans('letters.receiver') }}</label>
                                <div class="col-sm-10">
                                    @foreach($letter->receivers() as $receiver)
                                        <p class="form-control-plaintext">
                                            @include('letters.associations.partials.person', ['association' => $receiver])
                                        </p>
                                    @endforeach
                                    <p>
                                        <a class="btn btn-secondary"
                                           href="{{ route('letters.associations.create', [$letter]) }}?type=receiver">
                                            <span class="fa fa-plus"></span>
                                            Empfänger hinzufügen
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="prints">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addPrint-modal">
                                    <span class="fa fa-plus"></span> Druck hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="print in prints" is="in-place-editor"
                                :key="`print-${print.id}`"
                                :item-id="print.id" :item-entry="print.entry" :item-year="print.year"
                                base-url="{{ route('letters.prints.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.prints.store', [$letter]) }}"
                                         :on-stored="storedPrint"
                                         modal="addPrint"
                                         title="Drucke"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="transcriptions">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addTranscription-modal">
                                    <span class="fa fa-plus"></span> Abschrift hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="transcription in transcriptions" is="in-place-editor"
                                :key="`transcription-${transcription.id}`"
                                :item-id="transcription.id" :item-entry="transcription.entry"
                                :item-year="transcription.year"
                                base-url="{{ route('letters.transcriptions.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.transcriptions.store', [$letter]) }}"
                                         :on-stored="storedTranscription"
                                         modal="addTranscription"
                                         title="Abschriften"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="auction_catalogues">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addCatalogue-modal">
                                    <span class="fa fa-plus"></span> Katalog hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="auctionCatalogue in auctionCatalogues" is="in-place-editor"
                                :key="`auctionCatalogue-${auctionCatalogue.id}`"
                                :item-id="auctionCatalogue.id" :item-entry="auctionCatalogue.entry" :item-year="auctionCatalogue.year"
                                base-url="{{ route('letters.auction-catalogues.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.auction-catalogues.store', [$letter]) }}"
                                         :on-stored="storedCatalogue"
                                         modal="addCatalogue"
                                         title="Auktionskataloge"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="attachments">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addAttachment-modal">
                                    <span class="fa fa-plus"></span> Beilage hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="attachment in attachments" is="in-place-editor"
                                :key="`attachment-${attachment.id}`"
                                :item-id="attachment.id" :item-entry="attachment.entry" :item-year="attachment.year"
                                base-url="{{ route('letters.attachments.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.attachments.store', [$letter]) }}"
                                         :on-stored="storedAttachment"
                                         modal="addAttachment"
                                         title="Beilagen"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="drafts">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addDraft-modal">
                                    <span class="fa fa-plus"></span> Entwurf hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="draft in drafts" is="in-place-editor"
                                :key="`draft-${draft.id}`"
                                :item-id="draft.id" :item-entry="draft.entry" :item-year="draft.year"
                                base-url="{{ route('letters.drafts.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.drafts.store', [$letter]) }}"
                                         :on-stored="storedDraft"
                                         modal="addDraft"
                                         title="Drucke"></add-item-editor>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="facsimiles">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addFacsimile-modal">
                                    <span class="fa fa-plus"></span> Faksimile hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Eintrag</th>
                                <th colspan="2">Jahr</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="facsimile in facsimiles" is="in-place-editor"
                                :key="`facsimile-${facsimile.id}`"
                                :item-id="facsimile.id" :item-entry="facsimile.entry" :item-year="facsimile.year"
                                base-url="{{ route('letters.facsimiles.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>

                        <add-item-editor url="{{ route('letters.facsimiles.store', [$letter]) }}"
                                         :on-stored="storedFacsimile"
                                         modal="addFacsimile"
                                         title="Faksimile"></add-item-editor>
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
        window.letterId = "{{ $letter->getRouteKey() }}";
        window.LETTERS_FACSIMILE_STORE_URL = "{{ route('letters.facsimiles.store', [$letter]) }}";
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
