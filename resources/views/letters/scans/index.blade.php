@extends('layouts.app')

@section('title', $letter->id . ': ' . $letter->title() . ' | ')

@section('content')
    <div class="container" id="library-scans">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link"
                       href="{{ route('letters.show', [$letter]) }}"><i
                                class="fa fa-caret-left"></i></a> Brief: {{ $letter->title() }}</h1>
            </div>

            <div class="col-md-12 page-content">
                <div class="row">
                    <div class="col-md-12">
                        <Upload target="{{route('letters.scans.upload', $letter)}}"></Upload>
                    </div>
                </div>

                <form id="book-editor" action="{{ route('letters.update', [$letter]) }}"
                      class="form-horizontal"
                      method="POST"
                      @change="inputChanged = true">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @foreach($letter->getMedia('letters.scans') as $media)
                        <div class="row">
                            <div class="col-md-10">
                                <p>
                                    <a href="{{ route('letters.scans.show', [$letter, $media]) }}"
                                       data-toggle="tooltip" title="Scan herunterladen">
                                        {{ $media->name }}
                                        <span class="fa fa-download"></span>
                                    </a>
                                </p>
                                <p>{{ $media->mime_type }}</p>
                                <strong>{{ $media->getHumanReadableSizeAttribute() }}</strong>
                            </div>
                            <div class="col-md-2">
                                <img src="{{ $media->getFullUrl() }}" class="img-responsive">
                            </div>
                        </div>
                    @endforeach
                    <p>edit / delete existing scans</p>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/letters-scans.js') }}"></script>
@endsection
