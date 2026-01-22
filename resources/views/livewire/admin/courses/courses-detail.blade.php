<div class="p-1 mt-5">
    <div class="space-y-3">
        <div class="text-end">
            <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
                href="/tutti-corsi">
                Torna indietro
            </flux:button>
        </div>
        <div class="flex justify-center gap-3 h-25">
            <div class="w-full border bg-white border-zinc-300 p-3 rounded shadow text-sm">
                <div class="flex flex-col justify-center space-y-1">
                    <div class="font-semibold text-xl capitalize">
                        {{ $course->name }}
                    </div>
                    <div>
                        Cod. <span class="text-sm font-medium"> {{ $course->code }} </span>
                    </div>
                </div>
            </div>

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-1">
                <div class="flex justify-between">
                    Durata prevista:
                    <span class="text-sm font-medium"> {{ $course->duration_hours .'h' }} </span>
                </div>
                <div class="flex justify-between items-center">
                    Livello: <flux:badge color="{{ $course->getLevelColor($course->level) }}" size="sm">
                        {{ $course->getLevelLabel($course->level) }}
                    </flux:badge>
                </div>
                <div class="flex justify-between">
                    Centro Scolastico:
                    <span class="text-sm font-medium"> {{ $course->center }}</span>
                </div>
            </div>

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-1">
                <div class="flex justify-between items-center">
                    Stato: <flux:badge color="{{ $course->getStatusColor($course->status) }}" size="sm">
                        {{ $course->getStatusLabel($course->status) }}
                    </flux:badge>
                </div>
                <div class="flex justify-between">
                    Min-Max Allievi:
                    <span class="text-sm font-medium"> {{ $course->min_students ?? '-' }} - {{ $course->max_students ??
                        '-' }}</span>
                </div>
                <div class="flex justify-between">
                    Certificazione:
                    <span class="text-sm font-medium">{{ $course->certification ? 'Con Certificazione' : 'Senza
                        Certificazione' }}</span>
                </div>
            </div>

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-1">
                <div class="flex justify-between">
                    Prezzo:
                    <span class="font-bold">{{ $course->price .'€' ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    Data di inizio:
                    <span class="text-sm font-medium"> {{ $course->start_date->format('d/m/Y') ?? '-' }} </span>
                </div>
                <div class="flex justify-between">
                    Data di fine:
                    <span class="text-sm font-medium">{{ $course->end_date->format('d/m/Y') ?? '-' }} </span>
                </div>
            </div>
        </div>


        <div class="w-full shadow">
            <div x-cloak x-data="{isOpen: 'info'}" class="border border-zinc-300 bg-white p-5 rounded-lg text-sm">


                <div class="space-x-3">
                    <button @click="isOpen = 'info'"
                        :class="isOpen === 'info' ? 'bg-black text-white' : 'bg-zinc-50 hover:bg-zinc-100'"
                        class="cursor-pointer p-2 font-medium rounded border border-zinc-400">Info del corso
                    </button>
                    <button @click="isOpen = 'allievi'"
                        :class="isOpen === 'allievi' ? 'bg-black text-white' :  'bg-zinc-50 hover:bg-zinc-100'"
                        class="cursor-pointer p-2 rounded font-medium border border-zinc-400">Allievi
                    </button>
                </div>

                <div x-cloak x-show="isOpen === 'info'">
                    <div class="mt-5 space-y-2 border-b border-zinc-300">
                        <h3 class="text-lg font-medium">Descrizione del Corso</h3>
                        <p class="py-3">{{$course->description ?? '-'}}</p>
                    </div>

                    <div class="mt-5 space-y-2 border-b border-zinc-300">
                        <h3 class="text-lg font-medium">Materie da seguire</h3>
                        <div class="py-3">
                            @forelse($course->subjects as $subject)
                            <flux:badge color="purple" size="sm">
                                {{ $subject->name }}
                            </flux:badge>
                            @empty
                            -
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-5 space-y-2">
                        <h3 class="text-lg font-medium">Professori per Materia</h3>
                        <div class="py-3 space-y-5 grid grid-cols-3">
                            @forelse($course->subjects as $subject)
                            <div wire:key="subject-{{$subject->id}}" class="pl-2">
                                <div class="font-semibold text-sm mb-2 uppercase">{{ $subject->name }}</div>
                                <div class="space-y-1">
                                    @forelse($subject->teachers as $teacher)
                                    <div wire:key="teacher-{{$teacher->id}}" class="text-sm capitalize">
                                        Prof. {{ $teacher->name }}
                                    </div>
                                    @empty
                                    <div class="text-sm text-gray-500 italic">Nessun professore assegnato</div>
                                    @endforelse
                                </div>
                            </div>
                            @empty
                            <span class="text-gray-500">-</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div x-cloak  x-show="isOpen === 'allievi'">
                    <div class="mt-5 space-y-2 border-b border-zinc-300 ">
                        <h3 class="text-lg font-medium mb-5">Allievi iscritti</h3>

                        <x-table :headers="[
        ['label' => 'ID'],
        ['label' => 'Nome Allievo'],
        ['label' => 'Livello Istruttore', 'align' => 'text-center'],
        ['label' => 'Collaborazione Diretta', 'align' => 'text-center'],
        ['label' => 'Centro', 'align' => 'text-center'],
        ['label' => 'Specializzazioni', 'align' => 'text-center'],
        ['label' => 'Allegato', 'align' => 'text-center'],
        ['label' => '']
    ]" :show-checkbox="false">

                            {{-- @slot('checkboxHeader')
                            <flux:checkbox class="ps-3" wire:model.live="selectAll" />
                            @endslot --}}

                            {{-- @foreach($teachers as $item) --}}
                            <tr {{-- wire:key="teacher-{{$item->id}}" --}}
                                class="border-b dark:border-zinc-700 h-[60px] text-sm">
                                <td class="ps-5">
                                    {{--
                                    <flux:checkbox wire:model.live="selected" value="{{ $item->id }}" /> --}}
                                </td>
                                <td class="px-3 font-bold text-sm">{{-- T-#{{$item->id}} --}}</td>
                                <td class="px-3">{{-- {{$item->name}} --}}</td>
                                <td class="px-3 text-center">
                                    {{-- <flux:badge color="purple" size="sm">
                                        {{ $item->getLevelLabel($item->professionalProfile?->level_coach) }}
                                    </flux:badge> --}}
                                </td>
                                <td class="px-3">
                                    {{-- <div class="flex justify-center items-center">
                                        <flux:button wire:click="toggle({{$item->id}})" variant="ghost"
                                            class="cursor-pointer">
                                            @if($item->professionalProfile &&
                                            $item->professionalProfile->direct_collaboration)
                                            <flux:icon.check-circle color="blue" variant="mini" />
                                            @else
                                            <flux:icon.x-circle color="red" variant="mini" />
                                            @endif
                                        </flux:button>
                                    </div> --}}
                                </td>
                                <td class="px-3 text-center">
                                    {{-- {{$item->professionalProfile?->center ?? '-' }} --}}</td>
                                <td class="px-3 text-center">
                                    {{-- <flux:badge color="purple" size="sm">
                                        {{$item->subjects?->count() }}
                                    </flux:badge> --}}
                                </td>
                                <td class="px-3 text-center">
                                    {{-- @if($item->professionalProfile?->file_professional)
                                    <flux:button download size="sm" variant="ghost"
                                        href="{{asset('storage/'. $item->professionalProfile->file_professional )}}"
                                        icon="arrow-down-tray" />
                                    @else
                                    -
                                    @endif --}}
                                </td>
                                <td class="px-3">
                                    <div class="flex justify-end gap-2">
                                        <flux:button wire:navigate icon="eye" variant="ghost" size="sm"
                                            class="cursor-pointer" {{-- href="/professori/{{$item->id}}/dettagli" --}}>
                                        </flux:button>
                                        <flux:button wire:navigate icon="pencil" variant="ghost" size="sm"
                                            class="cursor-pointer" {{-- href="/professori/{{$item->id}}/modifica" --}}>
                                        </flux:button>
                                        <flux:modal.trigger {{-- name="delete-profile-{{$item->id}}" --}}>
                                            <flux:button icon="trash" variant="ghost" size="sm" class="cursor-pointer">
                                            </flux:button>
                                        </flux:modal.trigger>
                                        <flux:modal {{-- name="delete-profile-{{$item->id}}" --}} class="md:w-96">
                                            <div class="space-y-6">
                                                <div>
                                                    <flux:heading size="xl">Attenzione</flux:heading>
                                                    <flux:text class="mt-2">Sei sicuro di eliminare l'elemento?
                                                    </flux:text>
                                                </div>
                                                <div class="flex gap-2">
                                                    <flux:spacer />
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost">Cancel</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button {{-- wire:click="delete({{$item->id}})" --}}
                                                        variant="danger" class="cursor-pointer">Elimina</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                    </div>
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        </x-table>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="text-end mt-5">
        <flux:button wire:navigate icon="pencil" variant="primary" size="sm"
            href="/tutti-corsi/{{$course->id}}/modifica"> Modifica
        </flux:button>
    </div>
</div>
</div>