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

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-WBCHR7M');
        </script>
        <!-- End Google Tag Manager -->


    </head>
    <body>
        <div id="client"></div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <script src="{{ asset('js/client.js') }}"></script>
        <script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async=""></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script> 

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WBCHR7M"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        
    </body>
</html>
