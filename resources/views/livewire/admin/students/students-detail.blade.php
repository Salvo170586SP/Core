<div class="p-1">
    <div class="text-end mb-5">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/allievi">
            Torna indietro
        </flux:button>
    </div>
    <div class="flex gap-5">
        <div class="w-120 space-y-3">
            <div
                class="border border-zinc-300 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-4 rounded shadow text-sm">
                <div class="flex flex-col justify-center space-y-3">
                    <div class="w-full flex justify-center mb-5">
                        <figure class="w-full overflow-hidden rounded border border-zinc-300 dark:border-zinc-600">
                            @if($student->documentsAsStudent->where('type', 'foto_profilo')->first())
                            <img alt="{{$student->documentsAsStudent->where('type', 'foto_profilo')->first()->name}}"
                                class="w-full h-full object-cover"
                                src="{{asset('storage/'. $student->documentsAsStudent->where('type', 'foto_profilo')->first()->url_file )}}" />
                            @else
                            <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}"
                                class="dark:invert-90" />
                            @endif
                        </figure>
                    </div>
                    <div class="font-semibold text-xl uppercase">
                        {{ $student->name ?? '-' }}
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Email:
                        </div>
                        <div class="font-semibold">
                            {{ $student->email ?? '-' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Tel:
                        </div>
                        <div class="font-semibold">
                            {{ $student->detailsAsStudent?->phone_number ?? '-' }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="font-medium">
                            Cod Fiscale:
                        </div>
                        <div class="font-semibold">
                            {{ $student->detailsAsStudent?->fiscal_code ?? '-' }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="font-medium">
                            Residente a:
                        </div>
                        <div class="font-semibold">
                            {{ $student->detailsAsStudent?->city ?? '-' }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Nato il:
                        </div>
                        <div class="font-semibold">
                            {{ $student->getDate($student->detailsAsStudent?->date_birth) }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">
                            Nato a:
                        </div>
                        <div class="font-semibold">
                            {{ $student->detailsAsStudent?->city_birth ?? '-' }}
                        </div>
                    </div>
                    <div>
                        @if($student->documentsAsStudent->where('type', 'carta_identita')->first() )
                        <div class="flex flex-col justify-between mt-5">
                            <span class="font-medium">Documento d'identità:</span>
                            <div class="space-x-1 mt-2">
                                <flux:button download size="sm"
                                    href="{{asset('storage/'. $student->documentsAsStudent->where('type', 'carta_identita')->first()->url_file )}}"
                                    icon="arrow-down-tray" />
                                <flux:button target="_blanck" size="sm"
                                    href="{{asset('storage/'. $student->documentsAsStudent->where('type', 'carta_identita')->first()->url_file )}}"
                                    icon="eye" />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full border border-zinc-300 bg-white dark:bg-zinc-800 dark:border-zinc-700 rounded shadow p-3">
            <div class="p-3 text-sm">
                <h3 class="font-semibold mb-5 text-sm uppercase">Inserito nei seguenti Corsi</h3>
                @if($student->coursesStudents->count() > 0)

                <x-table :headers="[
                    ['label' => 'Cod', 'align' => 'text-start'],
                    ['label' => 'Nome Corso', 'align' => 'text-start'],
                    ['label' => 'Livello', 'align' => 'text-center'],
                    ['label' => 'Durata (ore)', 'align' => 'text-center'],
                    ['label' => 'Data Inizio', 'align' => 'text-center'],
                    ['label' => 'Data Fine', 'align' => 'text-center'],
                    ['label' => 'Stato', 'align' => 'text-center'],
                    ['label' => 'Tesseramento', 'align' => 'text-center'],
                    ['label' => '']
                    ]" :show-checkbox="false">

                    @foreach($coursesStudents as $course)
                    <tr wire:key="courseStudent-{{$student->id}}-{{$course->id}}"
                        class="border-b dark:border-zinc-700 h-[60px] text-sm">
                        <td class="px-3 font-bold text-sm">{{ $course->code }}</td>
                        <td class="px-1 font-semibold">{{ $course->name }}</td>
                        <td class="px-1 text-center">
                            <flux:badge color="{{ $course->getLevelColor($course->level) }}" size="sm">
                                {{ $course->getLevelLabel($course->level) }}
                            </flux:badge>
                        </td>
                        <td class="px-1 text-center">{{ $course->duration_hours }}h</td>
                        <td class="px-1 text-center">{{ $course->start_date->format('d/m/Y') }}</td>
                        <td class="px-1 text-center">{{ $course->end_date->format('d/m/Y') }}</td>
                        <td class="px-1 text-center">
                            <flux:badge color="{{ $course->getStatusColor($course->status) }}" size="sm">
                                {{ $course->getStatusLabel($course->status) }}
                            </flux:badge>
                        </td>
                        <td class="px-1 text-center">
                            <flux:badge color="gray" size="sm">
                                {{ $course->IsBadge ? 'Tesserato' : 'Non Tesserato' }}
                            </flux:badge>
                        </td>
                        <td class="px-2">
                            <div class="flex justify-center">
                                <flux:button wire:navigate icon="eye" variant="filled" size="sm"
                                    href="/tutti-corsi/{{$course->id}}">Dettagli
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-table>
                <div class="mt-5">
                    {{$coursesStudents->links()}}
                </div>
                @else
                <div class="text-zinc-500 italic">Nessun corso assegnato</div>
                @endif
            </div>
        </div>
    </div>
    <div class="text-end mt-5">
        <flux:button wire:navigate icon="pencil" variant="primary" size="sm" class="cursor-pointer"
            href="/allievi/{{$student->id}}/modifica">Modifica
        </flux:button>
    </div>
</div>