<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') Grimmbriefwechsel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">

    <script>

        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

    </script>
</head>
<body>

<div id="app-container">
    @include('layouts.navigation.bar')

    <div style="margin-bottom: 4em;">
        @include('info')
        @yield('content')
    </div>

    <status-bar></status-bar>

    <portal-target name="modal-container" multiple></portal-target>
</div>

<!-- JavaScripts -->
<script src="/js/misc.js"></script>
<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({html: true});

        $('#danger-zone').submit(function (ev) {
            var confirm = window.confirm("Soll dieser Datensatz wirklich gelöscht werden?");
            return confirm;
        });

        window.setTimeout(function () {
            $('.alert').alert('close');
        }, 2000);
    });
</script>

@yield('scripts')
</body>
</html>