<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {!! \App\Contracts\Meta::render() !!}

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="icon" type="image/png" href="/favicon.png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/main.css') }}">

        <!-- Scripts -->
        @routes
{{--        <script src="{{ mix('js/manifest.js') }}" defer></script>--}}
{{--        <script src="{{ mix('js/vendor.js') }}" defer></script>--}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        @php
            $clientId = env('PAYPAL_CLIENT_ID');
            $currency = env('PAYPAL_CURRENCY');
        @endphp
        <script src="https://www.paypal.com/sdk/js?client-id={{$clientId}}&currency={{$currency}}&intent=authorize"></script>
    </body>
</html>
