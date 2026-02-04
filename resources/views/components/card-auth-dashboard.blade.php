<div class="rounded shadow bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700">
    <div class="flex flex-col h-full gap-3 p-3 text-sm">
        <div class="flex gap-5">
            <figure class="w-20 h-20 border rounded-lg border-zinc-400 dark:border-zinc-600 overflow-hidden">
                @if(auth()->user()->documentsAsAdmin()?->first()?->url_file)
                <img src="{{asset('storage/' . auth()->user()->documentsAsAdmin()?->first()?->url_file )}}"
                    alt="{{auth()->user->name}}" class="w-full h-full object-cover">
                @else
                <img src="{{asset('assets/icons/placeholder.png')}}" alt="placeholder"
                    class="w-full h-full object-cover dark:invert-90">
                @endif
            </figure>
            <div class="space-y-1">
                @role('allievo')
                <div class="flex gap-3">
                    <span class="font-medium dark:text-zinc-300">Matricola:</span>
                    <span class="text-zinc-600 dark:text-zinc-300 capitalize">{{auth()->user()->code}}</span>
                </div>
                @endrole

                @role('istruttore')
                <div class="flex gap-3">
                    <span class="font-medium dark:text-zinc-300">Id:</span>
                    <span class="text-zinc-600 dark:text-zinc-200 capitalize">{{auth()->user()->code}}</span>
                </div>
                @endrole
                <div class="flex gap-3">
                    <span class="font-medium dark:text-zinc-300">Utente:</span>
                    <span class="text-zinc-600 dark:text-zinc-200 capitalize">
                        {{auth()->user()->name}}</span>
                </div>
                <div class="flex gap-3">
                    <span class="font-medium dark:text-zinc-300">Email:</span>
                    <span class="text-zinc-600 dark:text-zinc-200"> {{auth()->user()->email}}</span>
                </div>
                @role('allievo|insegnante')
                <div class="flex gap-3">
                    <span class="font-medium dark:text-zinc-300">Tel:</span>
                    <span class="text-zinc-600 dark:text-zinc-200">{{auth()->user()->detailsAsStudent->phone_number}}</span>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>