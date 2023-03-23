<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Capital Office UK</title>

        <link rel="stylesheet" href="{{ asset('base/base.css') }}" />
        <link href="/favicon.ico" type="image/x-icon" rel="icon"/>
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
    </head>
    <body>
        <div id="client"></div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <script src="{{ asset('js/client.js') }}"></script>
        <script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async=""></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script> 
    </body>
</html>
