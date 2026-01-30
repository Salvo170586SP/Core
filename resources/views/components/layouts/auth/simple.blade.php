<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 font-sans">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-150 flex-col bg-white border border-zinc-400 p-5 rounded-xl shadow-lg">
            <a href="{{ route('home') }}" class="flex flex-col items-center  font-medium" wire:navigate>
                <figure class="rounded-xl overflow-hidden w-[250px]">
                    <img src="{{asset('/assets/icons/icon.png')}}" alt="icon" class="w-full h-full" />
                </figure>
            </a>
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>