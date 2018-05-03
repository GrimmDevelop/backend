@extends('layouts.app')

@section('title', 'neuen Brief hinzufügen | ')

@section('content')
    <div class="container" id="letter">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>
                    <a class="prev-link"
                       href="{{ referrer_url('last_letter_index', route('letters.index')) }}">
                        <i class="fa fa-caret-left"></i></a> Brief hinzufügen
                </h1>
            </div>

            <div class="col-md-12 page-content">
                <form class="form-horizontal" action="{{ route('letters.store') }}" method="post">
                    {{ csrf_field() }}

                    @include('partials.form.field', ['field' => 'code', 'model' => 'letters'])
                    @include('partials.form.field', ['field' => 'date', 'model' => 'letters'])

                    @include('partials.form.textarea', ['field' => 'addition', 'model' => 'letters', 'rows' => 3])

                    @include('partials.form.textarea', ['field' => 'inc', 'model' => 'letters', 'rows' => 3])

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            @can('library.update')
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-floppy-o"></span>
                                    Speichern und weiter bearbeiten
                                </button>

                                <button type="reset" class="btn btn-link">
                                    Änderungen zurücksetzen
                                </button>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
