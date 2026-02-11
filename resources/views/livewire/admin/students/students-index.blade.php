<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-lg uppercase">Studenti</h2>

        <x-div-selection :selected="$selected" function="deleteSelection" />
        <flux:button variant="primary" class="font-semibold cursor-pointer" icon="plus" wire:navigate
            href="allievi/crea">
            Aggiungi Studente
        </flux:button>
    </div>


    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$students->count()}}</flux:badge>
        </div>


        <x-table :headers="[
            ['label' => 'Matricola'],
            ['label' => 'Nome Allievo'],
            ['label' => 'Email'],
            ['label' => 'Cod.Fiscale'],
            ['label' => 'Telefono'],
            ['label' => 'Corsi', 'align' => 'text-center'],
            ['label' => 'Documento d\'identità', 'align' => 'text-center'],
            ['label' => 'Modulo', 'align' => 'text-center'],
            ['label' => '']
            ]" :show-checkbox="true">

            @slot('checkboxHeader')
            <flux:checkbox class="ps-3" wire:model.live="selectAll" />
            @endslot

            @forelse($students as $item)
            <tr wire:key="student-{{$item->id}}" class="border-b dark:border-zinc-700 h-[60px] text-sm">
                <td class="ps-5">
                    <flux:checkbox wire:model.live="selected" value="{{ $item->id }}" />
                </td>
                <td class="px-3 font-bold text-xs w-[120px]">{{$item->code}}</td>
                <td class="px-3 uppercase">{{$item->name}}</td>
                <td class="px-3">{{$item->email ?? '-'}}</td>
                <td class="px-3">{{$item->detailsAsStudent->fiscal_code?? '-'}}</td>
                <td class="px-3">{{$item->detailsAsStudent->phone_number ?? '-'}}</td>

                <td class="px-3">
                    <div class="flex justify-center items-center">
                        <flux:badge variant="ghost">{{$item->coursesStudents->count()}}</flux:badge>
                    </div>
                </td>
                <td class="px-3 text-center">
                    @if($item->documentsAsStudent->where('type', 'carta_identita')->first())
                    <flux:button download size="sm" variant="filled"
                        href="{{asset('storage/'. $item->documentsAsStudent->where('type', 'carta_identita')->first()->url_file )}}"
                        icon="arrow-down-tray" />
                    @else
                    -
                    @endif
                </td>
                <td class="px-3 text-center">
                    @if($item->documentsAsStudent->where('type', 'modulo_pdf')->first())
                    <flux:button size="sm" variant="filled" target="_black"
                        href="{{asset('storage/'. $item->documentsAsStudent->where('type', 'modulo_pdf')->first()->url_file )}}"
                        icon="document-magnifying-glass" />
                    @else
                    -
                    @endif
                </td>

                <td class="px-3">
                    <div class="flex justify-end gap-2">

                        <flux:button wire:navigate icon="eye" variant="filled" size="sm" class="cursor-pointer"
                            href="/allievi/{{$item->id}}"> Dettagli
                        </flux:button>
                        <flux:button wire:navigate icon="pencil" variant="filled" size="sm" class="cursor-pointer"
                            href="/allievi/{{$item->id}}/modifica">Modifica
                        </flux:button>
                        <flux:modal.trigger name="delete-profile-{{$item->id}}">
                            <flux:button icon="trash" variant="danger" size="sm" class="cursor-pointer">Elimina
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-profile-{{$item->id}}" class="md:w-96">
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
                                    <flux:button wire:click="delete({{$item->id}})" variant="danger"
                                        class="cursor-pointer">Elimina</flux:button>
                                </div>
                            </div>
                        </flux:modal>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-2 text-sm text-center italic">
                    Non ci sono Studenti
                </td>
            </tr>
            @endforelse
        </x-table>
        <div class="mt-5 px-2">
            {{$students->links()}}
        </div>

    </div>
</div>