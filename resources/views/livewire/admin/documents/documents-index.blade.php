<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-lg uppercase">Documenti</h2>
    </div>

    <div x-data="{isOpen: 'teachers'}" class="w-full rounded-lg mt-5">
        <div class="flex gap-3">
            <button @click="isOpen = 'teachers'"
                :class="isOpen === 'teachers' ? 'bg-black text-white dark:border-zinc-700' : 'bg-white hover:bg-zinc-100 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:border-zinc-700'"
                class="cursor-pointer p-2 font-medium rounded border border-zinc-300 flex items-center gap-2 text-sm">
                <svg x-cloak x-show="isOpen == 'teachers'" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Insegnanti
            </button>
            <button @click="isOpen = 'students'"
                :class="isOpen === 'students' ? 'bg-black text-white dark:border-zinc-700' :  'bg-white hover:bg-zinc-100 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:border-zinc-700'"
                class="cursor-pointer p-2 rounded font-medium border border-zinc-300 flex items-center gap-2 text-sm">
                <svg x-cloak x-show="isOpen == 'students'" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>

                Allievi
            </button>
        </div>

        <div x-cloak x-show="isOpen == 'teachers'">
            <div class="my-5">
                <h2 class="text-base font-semibold">Documenti Professori</h2>
            </div>

            <div class="flex flex-wrap gap-5">
                @forelse($teacherDocuments as $teacher)
                <x-card-document :item="$teacher" />
                @empty
                <div>Nessun Documento</div>
                @endforelse
            </div>
        </div>

        <div x-cloak x-show="isOpen == 'students'">
            <div class="my-5">
                <h2 class="text-base font-semibold">Documenti Studenti</h2>
            </div>

            <div class="flex flex-wrap gap-5">
                @forelse($studentDocuments as $student)
                <x-card-document :item="$student" />
                @empty
                <div>Nessun Documento</div>
                @endforelse
            </div>
        </div>
    </div>
</div>