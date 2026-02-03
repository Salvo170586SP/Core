<div class="rounded shadow bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700">
    <div class="flex flex-col h-full gap-3 p-3 text-sm">
        <div class="flex gap-5">
            <figure class="w-20 h-20 border rounded-lg border-zinc-400 overflow-hidden">
                @if(auth()->user()->documentsAsAdmin()?->first()?->url_file)
                <img src="{{asset('storage/' . auth()->user()->documentsAsAdmin()?->first()?->url_file )}}"
                    alt="{{auth()->user->name}}" class="w-full h-full object-cover">
                @else
                <img src="{{asset('assets/icons/placeholder.png')}}" alt="placeholder"
                    class="w-full h-full object-cover">
                @endif
            </figure>
            <div class="space-y-1">
                @role('allievo')
                <div class="flex gap-3">
                    <span class="font-medium">Matricola:</span>
                    <span class="text-zinc-600 dark:text-zinc-200 capitalize"> </span>
                </div>
                @endrole

                @role('istruttore')
                <div class="flex gap-3">
                    <span class="font-medium">Id:</span>
                    <span class="text-zinc-600 dark:text-zinc-200 capitalize"> </span>
                </div>
                @endrole
                <div class="flex gap-3">
                    <span class="font-medium">Utente:</span>
                    <span class="text-zinc-600 dark:text-zinc-200 capitalize">
                        {{auth()->user()->name}}</span>
                </div>
                <div class="flex gap-3">
                    <span class="font-medium">Email:</span>
                    <span class="text-zinc-600 dark:text-zinc-200"> {{auth()->user()->email}}</span>
                </div>
                @role('allievo|insegnante')
                <div class="flex gap-3">
                    <span class="font-medium">Tel:</span>
                    <span class="text-zinc-600 dark:text-zinc-200"> </span>
                </div>
                <div class="flex gap-3">
                    <span class="font-medium">Codice Tessera:</span>
                    <span class="text-zinc-600 dark:text-zinc-200"> </span>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>