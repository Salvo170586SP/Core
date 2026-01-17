<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div
            class="sticky top-0 left-0 right-0 w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg -mt-5 h-20 p-5 flex items-center justify-end">
            Img - Nome Utente
        </div>

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>