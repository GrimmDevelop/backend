@extends('layouts.app')

@section('title', $book->catalog_id . ': ' . $book->title . ' | ')

@section('content')
    <div class="container" id="library">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1><a class="prev-link"
                       href="{{ route('librarybooks.show', [$book]) }}"><i
                                class="fa fa-caret-left"></i></a> Buchdaten: {{ $book->title }}</h1>
            </div>

            <div class="col-md-12 page-content">
                <form id="book-editor" action="{{ route('librarybooks.update', [$book->id]) }}"
                      class="form-horizontal"
                      method="POST"
                      @change="inputChanged = true">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <p>display scans...</p>
                    <p>edit / delete existing scans</p>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div id="dropZone" class="drop">
                            <span id="browseButton" class="btn btn-default">
                                neuen Scan hinzufügen
                                <input type="file" multiple="multiple"
                                       style="visibility: hidden; position: absolute;">
                            </span>
                        </div>

                        <br>

                        <div class="progress ">
                            <div id="upload-progress" class="progress-bar progress-bar-success"
                                 style="width: 0; min-width: 2em;">0%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('js/library.js') }}"></script>
    <script src="{{url('js/flow.min.js')}}"></script>

    <script>
        var flow = new Flow({
            target: '{{route('librarybooks.upload-scan',$book)}}',
            headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
            withCredentials: true
        });


        flow.assignBrowse($('#browseButton'));
        flow.assignDrop($('#dropZone'));

        flow.on('fileAdded', function (file, event) {
            $('#upload-progress').show();
        });
        flow.on('fileSuccess', function (file, message) {
            console.log(file, message);
        });
        flow.on('fileError', function (file, message) {
            console.log(file, message);
        });
        flow.on('progress', function () {
            let percent = Math.round(flow.sizeUploaded() / flow.getSize() * 100);

            $('#upload-progress').css('width', percent + '%');
            $('#upload-progress').text(percent + '%');
        });
        flow.on('complete', function (e) {
            $('#upload-progress').addClass('progress-bar-success');
            $('#upload-progress').css('width', '100%');
        });


        flow.on('fileProgress', function (file, message) {

        }, false);
        flow.on('filesSubmitted', function () {
            flow.upload();// instant upload
        });


    </script>
@endsection
