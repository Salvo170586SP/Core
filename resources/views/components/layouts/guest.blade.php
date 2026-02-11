<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'CoreSrl') }}</title>
    <link rel="icon" href="/favicon2.ico" sizes="any">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="text-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-400 my-6 p-10 bg-white shadow-2xl overflow-hidden rounded">
            <div class="w-full flex justify-center items-center">
                <figure class="w-80 -mt-10">
                    <img src="{{asset('/assets/icons/icon.png')}}" class="w-full" alt="icon">
                </figure>
            </div>
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>

</html>