<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">

        <title inertia>{{ config('app.name', 'TwitterClone') }}</title>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>

    <body class="font-sans antialiased">
        @inertia
    </body>

</html>
