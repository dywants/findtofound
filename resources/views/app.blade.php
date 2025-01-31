<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! \App\Contracts\Meta::render() !!}

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia

    @if (config('services.paypal.client_id'))
        <script>
            window.paypalConfig = {
                'clientId': '{{ config('services.paypal.client_id') }}',
                'currency': '{{ config('services.paypal.currency') }}',
                'mode': '{{ config('services.paypal.mode') }}'
            };
        </script>
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency={{ config('services.paypal.currency') }}&intent=capture&components=buttons">
        </script>
    @endif
</body>

</html>
