<div class="p-1">
    <div class="text-end mb-5">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/professori">
            Torna indietro
        </flux:button>
    </div>
    <div class="flex gap-5">
        <div class="w-120 space-y-3">
            <div class="border border-zinc-300 bg-white p-3 rounded shadow text-sm overflow-hidden">
                <div class="w-full flex justify-center mb-5">
                    <figure class="w-full overflow-hidden rounded-lg border border-zinc-300">
                        @if($teacher->documentsAsTeacher->where('type', 'foto_profilo')->first())
                        <img alt="{{$teacher->documentsAsTeacher->where('type', 'foto_profilo')->first()->name}}"
                            class="w-full h-full object-cover"
                            src="{{asset('storage/'. $teacher->documentsAsTeacher->where('type', 'foto_profilo')->first()->url_file )}}" />
                        @else
                        <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}" />
                        @endif
                    </figure>
                </div>
                <div class="flex flex-col justify-center space-y-2">
                    <div class="font-semibold text-xl">
                        Prof. {{ $teacher->name }}
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Cod.
                        </div>
                        <div class="font-semibold">
                            {{$teacher->code ?? '*'}}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Email:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->email ?? '-' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Tel:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->detailsAsTeacher?->phone_number ?? '-' }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="font-medium">
                            Cod Fiscale:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->detailsAsTeacher?->fiscal_code ?? '-' }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="font-medium">
                            Residente a:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->detailsAsTeacher?->city ?? '-' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Nato il:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->detailsAsTeacher?->date_birth->format('d/m/Y') ?? '-' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Nato a:
                        </div>
                        <div class="font-semibold">
                            {{ $teacher->detailsAsTeacher?->city_birth ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-zinc-300 bg-white p-3 rounded shadow text-sm">
                <h3 class="font-semibold mb-2">Materie</h3>
                @if($teacher->subjects->count() > 0)
                <div class="flex flex-wrap gap-1">
                    @foreach($teacher->subjects as $key => $value)
                    <flux:badge variant="primary">{{ $value->name }}</flux:badge>
                    @endforeach
                </div>
                @else
                Nessuna materia
                @endif
            </div>

            <div class="border border-zinc-300 bg-white p-3 rounded shadow text-sm">
                <h3 class="font-semibold mb-2 textcenter">Profilo Professionale</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span>Livello Professionale:</span>
                        <span class="font-medium">{{
                            $teacher->getLevelLabel($teacher->professionalProfile?->level_coach) }}</span>
                    </div>
                    <div class="flex items-center  justify-between">
                        <span>Collaborazione diretta:</span>
                        @if($teacher->professionalProfile && $teacher->professionalProfile->direct_collaboration)
                        <flux:icon.check-circle color="blue" variant="mini" />
                        @else
                        <flux:icon.x-circle color="red" variant="mini" />
                        @endif
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span>Giorni di lezione:</span>
                        <span class="font-medium">{{ $teacher->professionalProfile->day_course ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Orario inizio:</span>
                        <span class="font-medium">{{ $teacher->professionalProfile->hour_start ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Orario fine:</span>
                        <span class="font-medium">{{ $teacher->professionalProfile->hour_end ?? '-' }}</span>
                    </div>
                    @if($teacher->documentsAsTeacher->where('type', 'doc_professionale')->first() )
                    <div class="flex flex-col justify-between mt-5">
                        <span class="font-medium">Allegato:</span>
                        <div class="space-x-1 mt-2">
                            <flux:button download size="sm"
                                href="{{asset('storage/'. $teacher->documentsAsTeacher->where('type', 'doc_professionale')->first()->url_file )}}"
                                icon="arrow-down-tray" />
                            <flux:button target="_blanck" size="sm"
                                href="{{asset('storage/'. $teacher->documentsAsTeacher->where('type', 'doc_professionale')->first()->url_file )}}"
                                icon="eye" />
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full border border-zinc-300 bg-white rounded shadow">
            <div class="p-3 text-sm mt-5">
                <h3 class="font-semibold mb-2">Insegna nei seguenti Corsi</h3>
                @if($this->courses->count() > 0)
                <div class="space-y-2">
                    @foreach($this->courses as $course)
                    <div class="border border-zinc-200 rounded p-2 bg-zinc-50">
                        <div class="font-semibold text-zinc-800 uppercase">{{ $course->name }}</div>
                        <div class="text-xs text-zinc-600 mt-1">
                            @forelse($course->subjects->whereIn('id', $teacher->subjects->pluck('id')) as $subject)
                            <div class="inline-block mr-2">
                                <flux:badge size="sm" variant="secondary">{{ $subject->name }}</flux:badge>
                            </div>
                            @empty
                            <span class="text-zinc-400 italic">Nessuna materia</span>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-zinc-500 italic">Nessun corso assegnato</div>
                @endif
            </div>
        </div>
    </div>
    <div class="text-end mt-5">
        <flux:button wire:navigate icon="pencil" variant="primary" size="sm" class="cursor-pointer"
            href="/professori/{{$teacher->id}}/modifica">Modifica
        </flux:button>
    </div>
</div>