@extends('layouts.app')

@section('content')
    <div class="container" id="import">
        <div class="row page">
            <div class="col-md-12 page-title">
                <h1>{{ trans('admin.import') }}</h1>
            </div>
            <div class="col-md-12 page-content">
                <p>
                    Um eine akutelle version der Datenbank (DBF) einzuspielen, kann diese hier hochgeladen und
                    anschließend importiert werden.
                </p>
                <p>
                    <strong>Achtung!</strong>
                    Wird eine Datenbank importiert, werden vorher sämtliche Eintrage in der entsprechenden Datenbank auf
                    dem Server gelöscht.
                </p>
                <p>
                    <strong>Achtung!</strong>
                    Alle vorhandenen Datenbanken werden importiert. Um eine DBF Datenbank nicht zu importieren, muss
                    diese vorher gelöscht werden.
                </p>

                <div v-if="!started && !done">
                    <upload target="{{route('admin.import.upload')}}"
                            v-on:complete="onComplete"></upload>
                </div>

                <h3>Datenbanken</h3>
                <div v-if="!started && !done">
                    <table class="table table-striped">
                        <tbody>
                        <tr v-for="database in databases">
                            <td>
                                @{{ database.name }}
                            </td>
                            <td width="100%">
                                <span style="font-weight: lighter;">
                                    @{{ database.type }}
                                </span>
                            </td>
                            <td>
                                <a :href="database.remove" class="text-danger">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="float-right">
                    <button class="btn btn-success" @click="startImport($event)" :disabled="started">
                        <span class="fa fa-circle-o-notch fa-btn fa-spin" v-if="started"></span>
                        Import jetzt starten
                    </button>
                </div>

                <div v-if="started">
                    <h4>Briefe</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             :aria-valuenow="letterProgress" aria-valuemin="0" style="width: 100%;">
                            @{{ letterProgress }}
                        </div>
                    </div>
                    <h4>Personen</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             :aria-valuenow="personProgress" aria-valuemin="0" style="width: 100%;">
                            @{{ personProgress }}
                        </div>
                    </div>
                    <h4>Bücher</h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             :aria-valuenow="bookProgress" aria-valuemin="0" style="width: 100%;">
                            @{{ bookProgress }}
                        </div>
                    </div>
                </div>
                <div v-if="done">
                    <p>Import abgeschlossen!</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.BASE_URL = "{{ route('admin.import.index') }}";
        window.PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
        window.PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
        window.USER_ID = "{{ auth()->user()->id }}";
    </script>
    <script src="{{ url('js/import.js') }}"></script>
@endsection
