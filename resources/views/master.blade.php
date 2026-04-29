<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title')</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])    
    </head>
    <body class="flex flex-col">
        
        <main class="flex-1">
            @yield('content')
        </main>
        
    </body>
</html>
