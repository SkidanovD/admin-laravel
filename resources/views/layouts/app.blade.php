<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/img/meta/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/meta/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/meta/favicon-16x16.png">
    <link rel="manifest" href="/img/meta/site.webmanifest">
    <link rel="mask-icon" href="/img/meta/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/img/meta/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/img/meta/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="site-body">
    @yield('content')
    <script src="/js/app.js"></script>
</body>
</html>
