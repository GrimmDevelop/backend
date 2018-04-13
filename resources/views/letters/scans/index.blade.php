@extends('layouts.app')

@section('title', $letter->id . ': ' . $letter->title() . ' | ')

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

        @if($letter->prints()->where('transcription', 1)->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.prints') }}</h1>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->prints()->where('transcription', 1)->orderBy('sort')->get() as $print)
                        @include('letters.scans.partials.collection', ['collection' => 'prints.' . $print->id])
                    @endforeach
                </div>
            </div>
        @endif

        @if($letter->prints()->where('transcription', 0)->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.transcriptions') }}</h1>
                </div>

                <div class="col-md-12 page-content">
                    @foreach($letter->prints()->where('transcription', 0)->orderBy('sort')->get() as $print)
                        @include('letters.scans.partials.collection', ['collection' => 'prints.' . $print->id])
                    @endforeach
                </div>
            </div>
        @endif

        @if($letter->drafts->count() > 0)
            <div class="row page">
                <div class="col-md-12 page-title page-title--subtitle">
                    <h1>{{ trans('letters.drafts') }}</h1>
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
