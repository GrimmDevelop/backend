@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <portal to="help-modal-body">
        Test
    </portal>

    <portal to="status-bar-left">
        @can('library.update')
            <a href="{{ route('letters.scans.index', [$letter]) }}" role="button"
               class="btn btn-default">
                <span class="fa fa-picture-o"></span>
                Scans verwalten
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

                <button type="button" class="btn btn-default" @click="form.reset()">
                    Änderungen verwerfen
                </button>
            @endunless
        @endcan

        @can('letters.delete')
            @unless($letter->trashed())
                <form id="danger-zone" action="{{ route('letters.destroy', [$letter->id]) }}"
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

                    <div class="form-group">
                        <label class="col-sm-2 control-label">IDs</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
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
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
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
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @foreach($letter->getMedia('letters.scans.handwriting_location') as $index => $media)
                                    <a href="{{ route('letters.scans.index', [$letter]) }}#scan-{{ $media->id }}"><img
                                                src="{{ $media->getFullUrl() }}" style="width: 10%;"></a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </form>

                <hr>

                <h3>Verknüpfungen</h3>

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#send" data-toggle="tab">Sender</a>
                    </li>
                    <li>
                        <a href="#receive" data-toggle="tab">Empfänger</a>
                    </li>
                    <li>
                        <a href="#transcriptions" data-toggle="tab">Abschriften</a>
                    </li>
                    <li>
                        <a href="#prints" data-toggle="tab">Drucke</a>
                    </li>
                    <li>
                        <a href="#attachments" data-toggle="tab">Beilagen</a>
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
                        <a href="#codes" data-toggle="tab">Codes</a>
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
                                       for="inputFrom">{{ trans('letters.sender') }}</label>
                                <div class="col-sm-10">
                                    @foreach($letter->senders() as $sender)
                                        <p class="form-control-static">
                                            @include('letters.associations.partials.person', ['association' => $sender])
                                        </p>
                                    @endforeach
                                    <p>
                                        <a class="btn btn-default"
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputFrom">{{ trans('letters.receiver') }}</label>
                                <div class="col-sm-10">
                                    @foreach($letter->receivers() as $receiver)
                                        <p class="form-control-static">
                                            @include('letters.associations.partials.person', ['association' => $receiver])
                                        </p>
                                    @endforeach
                                    <p>
                                        <a class="btn btn-default"
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
                                        data-target="#addTranscription">
                                    <i class="fa fa-plus"></i> Abschrift hinzufügen
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
                            <tr v-for="transcription in transcriptions" is="in-place-editor"
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

                    <div role="tabpanel" class="tab-pane" id="attachments">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addAttachment">
                                    <i class="fa fa-plus"></i> Beilage hinzufügen
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
                            <tr v-for="attachment in attachments" is="in-place-editor"
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

                    <div role="tabpanel" class="tab-pane" id="information">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button id="addInformationButton" type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#addInformation">
                                    <i class="fa fa-plus"></i> Information hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Code</th>
                                <th colspan="2">Wert</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(info, index) in information" is="in-place-information-editor"
                                :item-id="info.id" :item-codes="codes" :selected-code="info.letter_code_id"
                                :item-data="info.data" @removed-info="removedInformation(index)" :key="info.id"
                                base-url="{{ route('letters.information.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>
                        <add-information-editor url="{{ route('letters.information.store', [$letter]) }}"
                                                :on-stored="storedInformation" :codes-item="codes"
                                                modal="addInformation"
                                                title="Information"></add-information-editor>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="codes">
                        @unless($letter->trashed())
                            <div class="add-button">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addCode">
                                    <i class="fa fa-plus"></i> Code hinzufügen
                                </button>
                            </div>
                        @endunless
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th colspan="2">Name</th>
                                <th colspan="1">Error Generated</th>
                                <th colspan="2">Internal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(code, index) in codes" is="in-place-code-editor"
                                :item-id="code.id" :item-name.sync="code.name"
                                :item-error-generated.sync="code.error_generated"
                                :item-internal.sync="code.internal" @removed-code="removedCode(index)"
                                @updated-code="updatedCode" :key="code.id"
                                base-url="{{ route('letters.codes.index', [$letter]) }}"
                                editable="{{ !$letter->trashed() }}">
                            </tr>
                            </tbody>
                        </table>
                        <add-code-editor url="{{ route('letters.codes.store', [$letter]) }}"
                                         :on-stored="storedCode" modal="addCode"
                                         title="Code"></add-code-editor>
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