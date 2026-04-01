<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
        <title>{{ $title ?? config('app.name') }}</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
        <section class="h-screen bg-dark-light flex">
            @livewire('components.workspace-nav')
            @livewire('components.workspace-channels')
            <div class="w-full h-screen overflow-hidden">
                {{ $slot }}
            </div>
            @livewire('components.workspace-channel-info')
        </section>

        @livewireScripts
    </body>
</html>
