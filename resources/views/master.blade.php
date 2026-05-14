<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') }} | @yield('title')</title>
        <link rel="icon" href="{{ asset('images/logo/de-pallet.svg') }}" type="image/png">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles    
    </head>
    <body>
        @yield('body')

        @livewireScripts
    </body>
</html>