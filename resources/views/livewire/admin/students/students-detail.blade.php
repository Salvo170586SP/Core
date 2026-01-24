<div class="p-1 mt-5">
    <div class="text-end mb-5">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/allievi">
            Torna indietro
        </flux:button>
    </div>
    <div class="flex gap-5">
        <div class="w-100 space-y-3">
            <div class="border border-zinc-300 bg-white p-3 rounded shadow text-sm">
                <h3 class="font-semibold mb-2">Dati Anagrafici Allievo</h3>
                <div class="flex flex-col justify-center">
                    <div class="font-semibold text-xl capitalize">
                        {{ $student->name }}
                    </div>
                    <div>
                        {{ $student->email }}
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full border border-zinc-300 bg-white rounded shadow p-3">
            <div class="p-3 text-sm mb-5 border-b border-zinc-300">
                <h3 class="font-semibold mb-2">Descrizione</h3>
                <p class="py-3">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit repellat exercitationem obcaecati
                    reiciendis praesentium eum beatae nulla a eaque. Nam consequatur modi, quas itaque laudantium nisi
                    accusantium enim animi molestiae.
                </p>
            </div>

            <div class="p-3 text-sm mt-5">
                <h3 class="font-semibold mb-2">Inserito nei seguenti Corsi</h3>
                @if($student->coursesStudents->count() > 0)

                <x-table :headers="[
                    ['label' => '', 'align' => 'text-start'],
                    ['label' => 'Nome Corso', 'align' => 'text-start'],
                    ['label' => 'Livello', 'align' => 'text-center'],
                    ['label' => 'Durata (ore)', 'align' => 'text-center'],
                    ['label' => 'Data Inizio', 'align' => 'text-center'],
                    ['label' => 'Data Fine', 'align' => 'text-center'],
                    ['label' => 'Stato', 'align' => 'text-center'],
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
                        <td class="px-2">
                            <div class="flex justify-center">
                                <flux:button wire:navigate icon="eye" variant="ghost" size="sm"
                                    href="/tutti-corsi/{{$course->id}}">
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