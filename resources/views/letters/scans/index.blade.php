@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <div class="container" id="letters-scans">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>
                    <a class="prev-link"
                       href="{{ route('letters.show', [$letter]) }}">
                        <i class="fa fa-caret-left"></i>
                    </a>

                    Brief: {{ $letter->title() }}
                </h1>
            </div>


            <div class="col-md-12 page-content">
                <p>
                    Übersicht aller Scans zu diesem Brief. Es können die Reihenfolge geändert,
                    Scans gelöscht und neue Scans hinzugefügt werden.
                </p>
            </div>
        </div>

        @if($letter->handwriting_location != null)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.handwriting_location') }}</h1>
                </div>

                <div class="col-md-12 page-content">
                    @include('letters.scans.partials.collection', ['collection' => 'handwriting_location'])
                </div>
            </div>
        @endif

        @if($letter->couvert != null)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.couvert') }}</h1>
                </div>

                <div class="col-md-12 page-content">
                    @include('letters.scans.partials.collection', ['collection' => 'couvert'])
                </div>
            </div>
        @endif

        @if($letter->transcriptions()->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1 class="pull-left">{{ trans('letters.transcription') }}</h1>

                    <p class="pull-right" style="margin-top: 9px;">
                        <a href="{{ route('letters.show', [$letter]) }}#transcriptions" class="btn btn-default">
                            <span class="fa fa-plus"></span>
                            {{ trans('letters.transcription') }} hizufügen
                        </a>
                    </p>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->transcriptions()->orderBy('sort')->get() as $print)
                        @include('letters.scans.partials.collection', ['collection' => 'transcriptions.' . $print->id])
                    @endforeach
                </div>
            </div>
        @endif

        @if($letter->prints()->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1 class="pull-left">{{ trans('letters.print') }}</h1>

                    <p class="pull-right" style="margin-top: 9px;">
                        <a href="{{ route('letters.show', [$letter]) }}#prints" class="btn btn-default">
                            <span class="fa fa-plus"></span>
                            {{ trans('letters.print') }} hizufügen
                        </a>
                    </p>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->prints()->orderBy('sort')->get() as $print)
                        @include('letters.scans.partials.collection', ['collection' => 'prints.' . $print->id])
                    @endforeach
                </div>
            </div>
        @endif

        @if($letter->attachments()->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1 class="pull-left">{{ trans('letters.attachment') }}</h1>

                    <p class="pull-right" style="margin-top: 9px;">
                        <a href="{{ route('letters.show', [$letter]) }}#attachments" class="btn btn-default">
                            <span class="fa fa-plus"></span>
                            {{ trans('letters.attachment') }} hizufügen
                        </a>
                    </p>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->attachments as $attachment)
                        @include('letters.scans.partials.collection', ['collection' => 'attachments.' . $attachment->id])
                    @endforeach
                </div>
            </div>
        @endif

        @if($letter->drafts()->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.draft') }}</h1>

                    <p class="pull-right" style="margin-top: 9px;">
                        <a href="{{ route('letters.show', [$letter]) }}#drafts" class="btn btn-default">
                            <span class="fa fa-plus"></span>
                            {{ trans('letters.draft') }} hizufügen
                        </a>
                    </p>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->drafts as $draft)
                        @include('letters.scans.partials.collection', ['collection' => 'drafts.' . $draft->id])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/letters-scans.js') }}"></script>
@endsection
