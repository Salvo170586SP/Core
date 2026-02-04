<div>
    <div>
        <h2 class="text-4xl font-semibold">Ciao, <span class="capitalize"> {{auth()->user()->name }}</span>!</h2>
        <div class="text-sm text-zinc-500 dark:text-zinc-300 font-medium mt-3">Ecco il riepilogo del tuo account</div>
    </div>

    <div class="my-5">
        <h2 class="text-xl my-3 font-semibold ">Riepilogo delle attività</h2>
        <div class="grid grid-cols-3 gap-3">
            <x-card-auth-dashboard />

            <div
                class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded shadow w-full h-40 p-3">
                <div class="text-lg font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-blue-500 dark:text-zinc-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="mt-3 text-zinc-500 dark:text-zinc-300 text-sm">
                        Ultimo Accesso:
                    </div>
                </div>
                <div class="text-xl font-medium dark:text-zinc-100">
                    @if(auth()->user()->last_login_at)
                    {{ auth()->user()->last_login_at->locale('it')->isoFormat('DD MMMM YYYY [alle]
                    HH:mm') }}
                    @endif
                </div>
            </div>

            <div
                class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded  shadow w-full h-40 p-3">
                <div class="space-y-3">

                    @role('allievo')
                    <div class="font-semibold flex items-center justify-between">
                        <div class="text-zinc-500 dark:text-zinc-300 flex items-end gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6  text-blue-800 dark:text-zinc-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                            </svg>
                            Corsi seguiti
                        </div>
                        <div class="text-xl font-medium dark:text-zinc-300">
                            {{$totalCoursesStudent}}
                        </div>
                    </div>
                    @endrole

                    @role('istruttore')
                    <div class="font-semibold flex items-center justify-between">
                        <div class="text-zinc-500 dark:text-zinc-300 flex items-end gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 text-blue-800 dark:text-zinc-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Studenti seguiti
                        </div>
                        <div class="text-xl font-medium dark:text-zinc-300">
                            {{$totalStudents}}
                        </div>
                    </div>

                    <div class="font-semibold flex items-center justify-between">
                        <div class="text-zinc-500 dark:text-zinc-300 text- flex items-end gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6  text-blue-800 dark:text-zinc-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                            </svg>
                            Corsi seguiti
                        </div>
                        <div class="text-xl font-medium dark:text-zinc-300">
                            {{ $totalCourses }}
                        </div>
                    </div>
                    @endrole
                </div>
            </div>

        </div>
    </div>

    <div class="my-10">
        <h2 class="text-xl my-3 font-semibold">Azioni rapide</h2>
        <div class="grid grid-cols-3 gap-3">
            @role('istruttore')
            <button wire:navigate href="/miei-allievi"
                class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded shadow w-full h-13 flex justify-between items-center p-5 cursor-pointer hover:shadow-lg">
                <div class="font-medium flex items-center gap-3 dark:text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="size-9 p-2 rounded-lg bg-blue-100 dark:bg-zinc-700 text-blue-800 dark:text-zinc-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                    I tuoi Studenti
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 dark:text-zinc-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            <button wire:navigate href="/mie-materie"
                class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded shadow w-full h-13 flex justify-between items-center p-5 cursor-pointer hover:shadow-lg">
                <div class="font-medium flex items-center gap-3 dark:text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="size-9 p-2 rounded-lg bg-blue-100 dark:bg-zinc-700 text-blue-800 dark:text-zinc-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                    Le tue Materie
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 dark:text-zinc-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            @endrole

            <button wire:navigate href="/miei-corsi"
                class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded shadow w-full h-13 flex justify-between items-center p-5 cursor-pointer hover:shadow-lg">
                <div class="font-medium flex items-center gap-3 dark:text-zinc-300">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="size-9 p-2 rounded-lg bg-blue-100 dark:bg-zinc-700 text-blue-800 dark:text-zinc-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>

                    I tuoi Corsi
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 dark:text-zinc-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>
</div>