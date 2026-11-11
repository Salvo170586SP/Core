<div>
    <div class="flex justify-between items-center h-25">
        <h2 class="font-bold text-lg uppercase">Documenti di <span class="italic">{{$user->name}}</span> </h2>
        <x-div-selection :selected="$selected" function="deleteSelection" />
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/documenti">
            Torna Indietro
        </flux:button>
    </div>
    <div class="flex flex-wrap gap-5">
        <x-table :headers="[
            ['label' => 'Nome Documento' ],
            ['label' => 'Tipo', 'align' => 'text-center'],
            ['label' => '']
            ]" :show-checkbox="true">

            @slot('checkboxHeader')
            <flux:checkbox class="ps-3" wire:model.live="selectAll" />
            @endslot

            @forelse($documents as $doc)
            <tr wire:key="doc-{{$doc->id}}" class="border-b dark:border-zinc-700 h-[60px] text-sm">
                <td class="ps-5">
                    <flux:checkbox wire:model.live="selected" value="{{ $doc->id }}" />
                </td>
                <td class="px-3 font-bold text-sm">{{ $doc->name }}</td>
                <td class="px-1 font-semibold text-center">{{ $doc->type }}</td>
                <td class="px-1">
                    <div class="flex justify-end gap-2">
                        <flux:button icon="eye" variant="filled" size="sm" target="_black"
                            href="{{asset('/storage/'. $doc->url_file)}}">Guarda
                        </flux:button>
                        <flux:button download icon="arrow-down-tray" variant="filled" size="sm"
                            href="{{asset('/storage/'. $doc->url_file)}}"> Scarica
                        </flux:button>
                        <flux:modal.trigger name="delete-doc-{{$doc->id}}">
                            <flux:button icon="trash" variant="danger" size="sm" class="cursor-pointer">Elimina
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-doc-{{$doc->id}}" class="md:w-96">
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
                                    <flux:button wire:click="deleteDoc({{$doc->id}})" variant="danger"
                                        class="cursor-pointer">Elimina</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </td>
            </tr>
            @empty 
            <tr>
                <td colspan="3" class="p-2 text-sm text-center italic">
                    Non ci sono Documenti
                </td>
            </tr>
            @endforelse
        </x-table>
        <div class="mt-5 px-2">
            {{$documents->links()}}
        </div>
    </div>
</div>