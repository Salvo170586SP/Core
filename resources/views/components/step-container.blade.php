@props(['title'])

<div class="flex flex-col">
    <div class="my-3 border p-5 rounded-2xl bg-white dark:bg-zinc-800 dark:border-zinc-700">
        <h2 class="text-sm font-bold">{{ $title }}</h2>
        <div class="my-3">
            {{ $slot }}
        </div>
    </div>
    
    @isset($actions)
    <div class="text-end space-x-2">
        {{ $actions }}
    </div>
    @endisset
</div>