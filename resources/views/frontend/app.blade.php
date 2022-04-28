<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Digitales Grimmarchiv</title>
    <link rel="icon" href="{{ url('images/favicon/FaviconBlue.ico') }}" type="image/x-icong">

    <!--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>-->

    <link href="{{ url('frontend/css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            adminUrl: '{{ route('dashboard') }}',
            userToken: {{ json_encode(auth()->id()) }},
            pusherAppKey: '{{ env('MIX_PUSHER_APP_KEY') }}',
            pusherAppCluster: '{{ env('MIX_PUSHER_APP_CLUSTER') }}',
        };
    </script>

    <style type="text/css">
        .loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
<div id="app">
{{-- Loading screen --}}
    <div class="loader">
        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40"
             xml:space="preserve">
                <path opacity="0.2" fill="#000"
                      d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
            <path fill="#000"
                  d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z">
                <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20"
                                  to="360 20 20" dur="0.5s" repeatCount="indefinite"/>
            </path>
            </svg>
    </div>
</div>

<div class="hidden">@sprites</div>
<script src="{{ url('frontend/js/frontend.js') }}"></script>
</body>
</html>
