<div class="p-1">
    <div class="text-end mb-5">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/tesserini-allievi/{{$student->id}}">
            Torna indietro
        </flux:button>
    </div>

    <div class="flex gap-5">
        <div class="w-full border border-zinc-300 bg-white rounded shadow p-4 text-sm">
            <h3 class="font-semibold text-lg mb-5">Tesserino</h3>
            <div class="w-full flex items-start gap-10 p-5">
                <x-card-badge :student="$student" :course="$course" />

                <div class="h-full border-s border-zinc-400 px-5">
                    <div class="flex gap-5">
                        <div class="font-medium">
                            <figure class="w-25 h-25 rounded-lg border border-blue-500 overflow-hidden mb-5">
                                @if($student->documentsAsStudent->where('type', 'foto_profilo')->first())
                                <img alt="{{$student->documentsAsStudent->where('type', 'foto_profilo')->first()->name}}"
                                    class="w-full h-full object-cover"
                                    src="{{asset('storage/'. $student->documentsAsStudent->where('type', 'foto_profilo')->first()->url_file )}}" />
                                @else
                                <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}" />
                                @endif
                            </figure>
                            <p>
                                Studente: <span class="text-sm font-semibold ms-2"> {{ $student->name }} </span>
                            </p>
                            <p>
                                Matricola: <span class="text-sm font-semibold ms-2">{{ $student->code }} </span>
                            </p>
                        </div>
                    </div>
                    <div class="font-medium">
                        Corso: <span class="text-sm font-semibold ms-2"> {{ $course->name }} </span>
                    </div>
                    <div class="font-medium">
                        Rilasciato il: <span class="text-sm font-semibold ms-2"> {{
                            $student->getDate($student->coursesStudents->firstWhere('id',
                            $course->id)->pivot->issued_at) }} </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>