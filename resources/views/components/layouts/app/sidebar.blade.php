<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <flux:sidebar sticky stashable
        class="border-e border-zinc-300  bg-white dark:border-zinc-700 dark:bg-zinc-800">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="w-full -my-5 -ms-7">
            <figure class="rounded-xl overflow-hidden w-[150px]">
                <img src="{{asset('/assets/icons/icon.png')}}" alt="icon" class="dark:invert-90" />
            </figure>
        </div>

        <flux:navlist variant="outline">

            <flux:navlist.group :heading="__('Anagrafiche')" class="grid">
                <flux:navlist.item icon="home" :href="route('teachers')" :current="request()->routeIs('teachers')"
                    wire:navigate>{{ __('Insegnanti') }}</flux:navlist.item>
                <flux:navlist.item icon="academic-cap" :href="route('students')" :current="request()->routeIs('students')"
                    wire:navigate>{{ __('Allievi') }}</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Corsi')" class="grid">
                <flux:navlist.item icon="computer-desktop" :href="route('courses')" :current="request()->routeIs('courses')"
                    wire:navigate>{{ __('Tutti I Corsi') }}</flux:navlist.item>
                <flux:navlist.item icon="computer-desktop"  :href="route('evening_courses')"
                    :current="request()->routeIs('evening_courses')" wire:navigate>{{ __('Corsi Serali') }}
                </flux:navlist.item>
            </flux:navlist.group>
           
            <flux:navlist.group :heading="__('Documentazioni')" class="grid">
                <flux:navlist.item icon="credit-card" :href="route('badges-students')" :current="request()->routeIs('badges-students')"
                    wire:navigate>{{ __('Tesseramenti') }}</flux:navlist.item>
                <flux:navlist.item icon="folder-plus" :href="route('documents')" :current="request()->routeIs('documents')"
                    wire:navigate>{{ __('Documenti') }}</flux:navlist.item>
               {{--  <flux:navlist.item icon="home" :href="route('evening_courses')"
                    :current="request()->routeIs('evening_courses')" wire:navigate>{{ __('Documenti Insegnati') }}
                </flux:navlist.item> --}}
            </flux:navlist.group>


            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="presentation-chart-line" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />
    </flux:sidebar>


    <flux:header class="{{-- lg:hidden --}} mt-3">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <livewire:admin.components.breadcrumbs />


        <flux:spacer />
        <div class="flex gap-7 mx-18 text-zinc-500">
            <button class="cursor-pointer">
                <flux:icon.chat-bubble-left-right class="size-5" />
            </button>
            <button class="cursor-pointer">
                <flux:icon.bell class="size-5" />
            </button>
        </div>

        <x-dropdown-header />
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>