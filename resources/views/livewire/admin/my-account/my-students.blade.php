<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-xl uppercase">I miei allievi</h2>
        <flux:button wire:navigate href="/mia-bacheca" variant="filled" icon="arrow-left" class="cursor-pointer">Torna
            Indietro</flux:button>
    </div>


    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$totalStudents}}</flux:badge>
        </div>

        <div class="flex gap-3">
            @if($students->count() > 0)
            @foreach($students as $student)
            <div class="w-full flex items-start gap-5 border p-3 bg-white rounded dark:bg-zinc-800 dark:border-zinc-700 text-blue-800 shadow">
                <figure class="w-18 overflow-hidden rounded-lg border border-zinc-300 dark:border-zinc-600">
                    @if($student->documentsAsStudent->where('type', 'foto_profilo')->first())
                    <img alt="{{$student->documentsAsStudent->where('type', 'foto_profilo')->first()->name}}"
                        class="w-full h-full object-cover"
                        src="{{asset('storage/'. $student->documentsAsStudent->where('type', 'foto_profilo')->first()->url_file )}}" />
                    @else
                    <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}"
                        class="w-full dark:invert-90" />
                    @endif
                </figure>
                <div class="space-y-1">
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Matricola: <span class="text-black dark:text-zinc-200 text-base">{{$student->code}}</span>
                    </div>
                    <div class="text-zinc-500 text-sm font-medium dark:text-zinc-400">
                        Studente: <span class="text-black dark:text-zinc-200 text-base">{{$student->name}}</span>
                    </div>
                    <div class="text-zinc-500 text-sm font-medium dark:text-zinc-400">
                        Email: <span class="text-black dark:text-zinc-200 text-base">{{$student->email}}</span>
                    </div>

                    <div class="text-zinc-500 text-sm font-medium dark:text-zinc-400">
                        Numero corsi: <span class="text-black dark:text-zinc-200 text-base"> {{$student->coursesStudents->count()}}</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3 text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Corsi:
                        @foreach($student->coursesStudents as $corso)
                        <flux:badge size="sm">{{$corso->name}}</flux:badge>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="w-full flex items-start justify-center text-zinc-500 font-semibold italic">
                Non hai Studenti
            </div>
            @endif
        </div>

    </div>
</div>