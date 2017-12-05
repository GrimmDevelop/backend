@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <div class="container" id="letter">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link"
                       href="{{ referrer_url('last_letter_index', route('letters.index'), '#letter-' . $letter->id) }}"><i
                                class="fa fa-caret-left"></i></a> Briefdaten: {{ $letter->title() }}</h1>
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
                    @include('partials.form.boolean', ['field' => 'copy_owned', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'language', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'copy', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'attachment', 'model' => $letter])

                    @include('partials.form.field', ['field' => 'handwriting_location', 'model' => $letter])

                    <hr>

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
                                        <a href="{{ route('people.show', [$sender->person]) }}">
                                            {{ $sender->person->fullName() }}

                                            @if($sender->person->fullName() != $sender->assignment_source)
                                                [{{ $sender->assignment_source }}]
                                            @endif
                                        </a>
                                    @else
                                        {{ $sender->assignment_source ?? '[unbekannt]' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @include('partials.form.field', ['field' => 'from_source', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'from_date', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'receive_annotation', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'reconstructed_from', 'model' => $letter])

                    <hr>

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
                                        <a href="{{ route('people.show', [$receiver->person]) }}">
                                            {{ $receiver->person->fullName() }}

                                            @if($receiver->person->fullName() != $receiver->assignment_source)
                                                [{{ $receiver->assignment_source }}]
                                            @endif
                                        </a>
                                    @else
                                        {{ $receiver->assignment_source ?? '[unbekannt]' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @include('partials.form.field', ['field' => 'to_date', 'model' => $letter])
                    @include('partials.form.field', ['field' => 'reply_annotation', 'model' => $letter])

                    <hr>

                    @unless($letter->trashed())
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                @can('library.update')
                                    <a href onclick="return false;" role="button" class="btn btn-lg btn-default" style="cursor: not-allowed;">
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

                <hr>

                <div>
                    @include('logs.entity-activity', ['entity' => $letter])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/letter.js') }}"></script>
@endsection
