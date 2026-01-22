<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div
            class="sticky z-50 top-4 left-0 right-0 w-full bg-white shadow dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded  -mt-5  p-5 flex items-center justify-end">
            Img - Nome Utente
        </div>

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>