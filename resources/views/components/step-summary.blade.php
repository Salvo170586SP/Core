@props(['title'])

<div class="flex flex-col">
    <div class="space-y-3 my-3 border p-5 rounded-2xl bg-white dark:bg-zinc-800 dark:border-zinc-700">
        <h2 class="text-sm font-bold">{{ $title }}</h2>
        
        @if ($errors->any())
        <div class="border border-red-300 dark:border-red-800 bg-red-50 dark:bg-red-900/20 rounded-2xl p-5">
            <h3 class="text-sm font-bold text-red-800 dark:text-red-400 mb-2">Attenzione! Correggi i seguenti errori:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                <li class="text-sm text-red-600 dark:text-red-400">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="grid grid-row-2 gap-3 my-3">
            {{ $slot }}
        </div>
    </div>
    
    @isset($actions)
    <div class="text-end space-x-2">
        {{ $actions }}
    </div>
    @endisset
</div>