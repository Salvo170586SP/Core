<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-xl uppercase">I miei corsi</h2>
        <flux:button wire:navigate href="/mia-bacheca" variant="filled" icon="arrow-left" class="cursor-pointer">Torna
            Indietro</flux:button>
    </div>

    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>

            @if(auth()->user()->hasRole('istruttore'))
            <flux:badge color="gray">{{$courses->count()}}</flux:badge>
            @endif

            @if(auth()->user()->hasRole('allievo'))
            <flux:badge color="gray">{{auth()->user()->coursesStudents->count()}}</flux:badge>
            @endif
        </div>

        <div class="flex gap-3">
            @if(auth()->user()->hasRole('istruttore') )
            @if( $courses->count() > 0)
            @foreach($courses as $course)
            <div wire:key="c-{{$course->id}}"
                class="w-full flex items-start gap-5 border p-3 bg-white rounded dark:bg-zinc-800 dark:border-zinc-700 text-blue-800 shadow">
                <div class="space-y-1">
                    <div class="mb-3">
                        <flux:badge size="lg">{{$course->name}}</flux:badge>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Codice: <span class="text-black dark:text-zinc-200 text-base">{{$course->code}}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Tipo: <span class="text-black dark:text-zinc-200 text-base"> {{$course->type == 'evening' ?
                            'Serale' : 'Mattutino'
                            }}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Durata corso: <span class="text-black dark:text-zinc-200 text-base"> {{$course->duration_hours
                            }}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Stato: <flux:badge class="text-black dark:text-zinc-200 text-base"
                            color="{{$course->getStatusColor($course->status)}}">
                            {{$course->getStatusLabel($course->status)}}</flux:badge>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Centro: <span class="text-black dark:text-zinc-200 text-base"> {{$course->center }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="w-full flex items-start justify-center text-zinc-500 font-semibold italic">
                Non hai Corsi
            </div>
            @endif
            @endif



            @if(auth()->user()->hasRole('allievo') )
            @if( auth()->user()->coursesStudents->count() > 0)
            @foreach($coursesStudent as $course)
            <div wire:key="c-s-{{$course->id}}"
                class="w-full flex items-start gap-5 border p-3 bg-white rounded dark:bg-zinc-800 dark:border-zinc-700 text-blue-800 shadow">
                <div class="space-y-1">
                    <div class="mb-3">
                        <flux:badge size="lg">{{$course->name}}</flux:badge>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Codice: <span class="text-black dark:text-zinc-200 text-base">{{$course->code}}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Tipo: <span class="text-black dark:text-zinc-200 text-base"> {{$course->type == 'evening' ?
                            'Serale' : 'Mattutino'
                            }}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Durata corso: <span class="text-black dark:text-zinc-200 text-base"> {{$course->duration_hours
                            }}</span>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Stato: <flux:badge class="text-black dark:text-zinc-200 text-base"
                            color="{{$course->getStatusColor($course->status)}}">
                            {{$course->getStatusLabel($course->status)}}</flux:badge>
                    </div>
                    <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                        Centro: <span class="text-black dark:text-zinc-200 text-base"> {{$course->center }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="w-full flex items-start justify-center text-zinc-500 font-semibold italic">
                Non hai Corsi
            </div>
            @endif
            @endif
        </div>
    </div>
</div>