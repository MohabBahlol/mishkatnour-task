<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.ts'])
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>
</html>
