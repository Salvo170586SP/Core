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
                    <div>
                        Allievi iscritti <span class="text-black font-bold ms-2"> {{$course->students->count()}} </span>
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


        <div class="w-full">
            <div x-cloak x-data="{isOpen: 'allievi'}"
                class="border border-zinc-300 bg-white p-5 rounded shadow text-sm">

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

                <div x-cloak x-show="isOpen === 'allievi'">
                    <div class="mt-5 space-y-2">
                        <div class="flex justify-between items-center h-20">
                            <div class="space-y-3">
                                <h3 class="text-lg font-medium">Allievi iscritti</h3>
                                @if($course->status  == 'recruitment_closed' || $course->students->count() == 3) <div
                                    class="text-red-600 rounded-lg flex gap-1 text-base font-bold">
                                    Iscrizioni chiuse
                                    <flux:icon.lock-closed />
                                </div>
                                @endif
                            </div>
                            <!-- Div con conteggio elementi selezionati -->
                            <x-div-selection :selected="$selected" function="detachSelectedStudentCourse" />

                            @if($course->status == 'recruitment' || $course->students->count() < 3) <div>
                                <flux:modal.trigger name="add-allievo-{{$course->id}}">
                                    <flux:button icon="plus" variant="primary" size="sm" class="cursor-pointer">
                                        Aggiungi Allievo
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal name="add-allievo-{{$course->id}}" class="md:w-96">
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="md">Aggiungi Allievo</flux:heading>
                                            <flux:text class="mt-2">
                                                <flux:select id="student_id" wire:model="student_id">
                                                    <flux:select.option value="">-</flux:select.option>
                                                    @foreach ($students as $student)
                                                    <flux:select.option wire:key="student-{{ $student->id }}"
                                                        value="{{ $student->id }}">
                                                        {{ $student->name }}
                                                    </flux:select.option>
                                                    @endforeach
                                                </flux:select>
                                            </flux:text>
                                        </div>
                                        <div class="flex gap-2">
                                            <flux:spacer />
                                            <flux:modal.close>
                                                <flux:button variant="ghost">Cancel</flux:button>
                                            </flux:modal.close>
                                            <flux:modal.close>
                                                <flux:button wire:click="attachStudentCourse" variant="primary"
                                                    class="cursor-pointer">Aggiungi al corso
                                                </flux:button>
                                            </flux:modal.close>
                                        </div>
                                    </div>
                                </flux:modal>
                        </div>

                        @endif
                    </div>

                    @if($course->students->count() > 0)
                    <x-table :headers="[
                                ['label' => 'ID'],
                                ['label' => 'Nome Allievo'],
                                ['label' => 'Allegato', 'align' => 'text-center'],
                                ['label' => '']
                            ]" :show-checkbox="true">
                        @foreach($course->students as $student)
                        <tr wire:key="student-course-{{$student->id}}-{{$course->id}}"
                            class="border-b dark:border-zinc-700 h-[60px] text-sm">
                            <td class="ps-5">
                                <flux:checkbox wire:model.live="selected" value="{{ $student->id }}" />
                            </td>
                            <td class="px-3 font-bold text-sm">{{$student->code}}</td>
                            <td class="px-3">{{$student->name}}</td>
                            <td class="px-3 text-center">

                            </td>
                            <td class="px-3">
                                <div class="flex justify-end gap-2">
                                    <flux:button wire:navigate icon="eye" variant="ghost" size="sm"
                                        class="cursor-pointer" href="/allievi/{{$student->id}}">
                                    </flux:button>
                                    <flux:modal.trigger name="delete-allievo-{{$student->id}}">
                                        <flux:button icon="trash" variant="ghost" size="sm" class="cursor-pointer">
                                        </flux:button>
                                    </flux:modal.trigger>
                                    <flux:modal name="delete-allievo-{{$student->id}}" class="md:w-96">
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
                                                <flux:button wire:click="detachStudentCourse({{$student->id}})"
                                                    variant="danger" class="cursor-pointer">Elimina</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </x-table>
                    @else
                    <div>Non ci sono studenti iscritti</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<div class="text-end mt-5">
    <flux:button wire:navigate icon="pencil" variant="primary" size="sm" href="/tutti-corsi/{{$course->id}}/modifica">
        Modifica
    </flux:button>
</div>
</div>
</div>