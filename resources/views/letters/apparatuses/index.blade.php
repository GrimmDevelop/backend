@extends('layouts.app')

@section('title', $letter->title() . ' | ')

@section('content')
    <div class="container">
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
                    Übersicht aller Apparate und Sachkommentare zu diesem Brief.
                </p>

                <comments-index letter-id="{{ $letter->getRouteKey() }}" ref="comments"></comments-index>

                <apparatuses-index letter-id="{{ $letter->getRouteKey() }}" ref="apparatuses"></apparatuses-index>
            </div>
        </div>
    </div>

    <portal to="status-bar-right">
        @can('library.update')
            @unless($letter->trashed())
                <button type="button" class="btn btn-primary" @click.prevent="save">
                    <span class="fa fa-floppy-o"></span>
                    Speichern
                </button>

                <a href="{{ route('letters.show', [$letter]) }}"
                   class="btn btn-default">
                    Abbrechen
                </a>
            @endunless
        @endcan
    </portal>
@endsection

@section('scripts')
    <script src="{{ url('js/letters-apparatuses.js') }}"></script>
@endsection
