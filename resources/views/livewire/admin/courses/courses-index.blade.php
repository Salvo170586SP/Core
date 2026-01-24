<div class="p-1 mt-5">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-lg uppercase">Tutti i Corsi</h2>
        <!-- Div con conteggio elementi selezionati -->
        <x-div-selection :selected="$selected" function="deleteSelection" />
        <flux:button variant="primary" class="font-semibold cursor-pointer" icon="plus" wire:navigate
            href="tutti-corsi/crea">
            Aggiungi Corso
        </flux:button>
    </div>


    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$courses->count()}}</flux:badge>
        </div>

        <x-table :headers="[
            ['label' => 'ID'],
            ['label' => 'Nome Corso'],
            ['label' => 'Livello', 'align' => 'text-center'],
            ['label' => 'Durata (ore)', 'align' => 'text-center'],
            ['label' => 'Studenti', 'align' => 'text-center'],
            ['label' => 'Data Inizio', 'align' => 'text-center'],
            ['label' => 'Data Fine', 'align' => 'text-center'],
            ['label' => 'Stato', 'align' => 'text-center'],
            ['label' => 'Materie', 'align' => 'text-center'],
            ['label' => 'Allievi Iscritti', 'align' => 'text-center'],
            ['label' => '']
            ]" :show-checkbox="true">

            @slot('checkboxHeader')
            <flux:checkbox class="ps-3" wire:model.live="selectAll" />
            @endslot

            @foreach($courses as $course)
            <tr wire:key="course-{{$course->id}}" class="border-b dark:border-zinc-700 h-[60px] text-sm">
                <td class="ps-5">
                    <flux:checkbox wire:model.live="selected" value="{{ $course->id }}" />
                </td>
                <td class="px-3 font-bold text-sm">{{ $course->code }}</td>
                <td class="px-1 font-semibold uppercase">{{ $course->name }}</td>
                <td class="px-1 text-center">
                    <flux:badge color="{{ $course->getLevelColor($course->level) }}" size="sm">
                        {{ $course->getLevelLabel($course->level) }}
                    </flux:badge>
                </td>
                <td class="px-1 text-center">{{ $course->duration_hours }}h</td>
                <td class="px-1 text-center">
                    {{ $course->min_students }}-{{ $course->max_students }}
                </td>
                <td class="px-1 text-center">{{ $course->start_date->format('d/m/Y') }}</td>
                <td class="px-1 text-center">{{ $course->end_date->format('d/m/Y') }}</td>
                <td class="px-1 text-center">
                    <flux:badge color="{{ $course->getStatusColor($course->status) }}" size="sm">
                        {{ $course->getStatusLabel($course->status) }}
                    </flux:badge>
                </td>
                <td class="px-1 text-center">
                    <flux:badge color="purple" size="sm">
                        {{ $course->subjects->count() }}
                    </flux:badge>
                </td>
                <td class="px-1 text-center">
                    <flux:badge color="purple" size="sm">
                        {{ $course->students->count() }}
                    </flux:badge>
                </td>
                <td class="px-1">
                    <div class="flex justify-end gap-2">
                        <flux:button wire:navigate icon="eye" variant="filled" size="sm"
                            href="/tutti-corsi/{{$course->id}}">Dettagli
                        </flux:button>
                        <flux:button wire:navigate icon="pencil" variant="filled" size="sm"
                            href="/tutti-corsi/{{$course->id}}/modifica">Modifica
                        </flux:button>
                        <flux:modal.trigger name="delete-course-{{$course->id}}">
                            <flux:button icon="trash" variant="danger" size="sm" class="cursor-pointer">Elimina</flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-course-{{$course->id}}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="xl">Attenzione</flux:heading>
                                    <flux:text class="mt-2">Sei sicuro di eliminare l'elemento?</flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button wire:click="delete({{$course->id}})" variant="danger"
                                        class="cursor-pointer">Elimina</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <div class="mt-5 px-2">
            {{$courses->links()}}
        </div>

    </div>
</div>