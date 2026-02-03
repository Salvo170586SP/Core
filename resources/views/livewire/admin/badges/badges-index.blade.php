<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-lg uppercase">Tesseramenti</h2>
    </div>


    <div class="w-full rounded-lg mt-5 ">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$badge_student->count()}}</flux:badge>
        </div>


        <x-table :headers="[
            ['label' => 'Matricola', ],
            ['label' => 'Nome Allievo' ],
            ['label' => 'Cod Fiscale' ],
            ['label' => 'Corsi', 'align' => 'text-center'],
            ['label' => 'Tesseramenti Attivi', 'align' => 'text-center'],
            ['label' => '']
            ]" :show-checkbox="false">

            @forelse($badge_student as $item)
            <tr wire:key="student-{{$item->id}}" class="border-b dark:border-zinc-700 h-[60px] text-sm">

                <td class="px-3 font-bold text-sm">{{$item->code}}</td>
                <td class="px-3 uppercase">{{$item->name}}</td>
                <td class="px-3 uppercase"> dsfdsfsdf</td>

                <td class="px-3">
                    <div class="flex justify-center items-center">
                        <flux:badge variant="ghost">{{$item->coursesStudents->count()}}</flux:badge>
                    </div>
                </td>
                <td class="px-3">
                    <div class="flex justify-center items-center">
                        <flux:badge variant="primary" color="blue">{{$item->coursesStudents()->wherePivot('is_active',
                            true)->count()
                            }}</flux:badge>
                    </div>
                </td>
                <td class="px-3">
                    <div class="flex justify-end gap-2">
                        <flux:button wire:navigate icon="eye" variant="filled" size="sm" class="cursor-pointer"
                            href="/tesserini-allievi/{{$item->id}}">
                            Dettagli
                        </flux:button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-2 text-sm text-center italic">
                    Non ci sono Tesserati
                </td>
            </tr>
            @endforelse
        </x-table>
        <div class="mt-5 px-2">
            {{$badge_student->links()}}
        </div>
    </div>
</div>