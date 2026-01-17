<div class="p-1 mt-5">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Professori</h2>
        <flux:button variant="primary" class="font-semibold cursor-pointer" icon="plus" wire:navigate
            href="professori/crea">
            Aggiungi Professore
        </flux:button>
    </div>

    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$teachers->count()}}</flux:badge>
        </div>


        <x-table :headers="[
        ['label' => '--'],
        ['label' => 'ID Istruttore'],
        ['label' => 'Nome Istruttore'],
        ['label' => 'Livello Istruttore', 'align' => 'text-center'],
        ['label' => 'Collaborazione Diretta', 'align' => 'text-center'],
        ['label' => 'Centro', 'align' => 'text-center'],
        ['label' => 'Specializzazioni', 'align' => 'text-center'],
        ['label' => '']
    ]">
            @foreach($teachers as $item)
            <tr wire:key="teacher-{{$item->id}}" class="border-b dark:border-zinc-700 h-[60px]">
                <td class="px-2">--</td>
                <td class="px-1">T-#{{$item->id}}</td>
                <td class="px-1">{{$item->name}}</td>
                <td class="px-1 text-center">
                    {{ $this->getLevelLabel($item->professionalProfile?->level_coach) }}
                </td>
                <td class="px-1">
                    <div class="flex justify-center items-center">
                        <flux:button wire:click="toggle({{$item->id}})" variant="ghost" class="cursor-pointer">
                            @if($item->professionalProfile && $item->professionalProfile->direct_collaboration)
                            <flux:icon.check-circle color="blue" variant="mini" />
                            @else
                            <flux:icon.x-circle color="red" variant="mini" />
                            @endif
                        </flux:button>
                    </div>
                </td>
                <td class="px-1 text-center">{{$item->professionalProfile?->center ?? '-' }}</td>
                <td class="px-1 text-center">--</td>
                <td class="px-1">
                    <div class="flex justify-end gap-2">
                        <flux:button wire:navigate icon="eye" variant="ghost" size="sm" class="cursor-pointer">
                        </flux:button>
                        <flux:button wire:navigate icon="pencil" variant="ghost" size="sm" class="cursor-pointer"
                            href="/professori/{{$item->id}}/modifica">
                        </flux:button>
                        <flux:modal.trigger name="delete-profile-{{$item->id}}">
                            <flux:button icon="trash" variant="ghost" size="sm" class="cursor-pointer"></flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-profile-{{$item->id}}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="xl">Attenzione</flux:heading>
                                    <flux:text class="mt-2">Sei sicuro di eliminare l'elemento?</flux:text>
                                </div>
                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button variant="danger" class="cursor-pointer">Elimina</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>

    </div>
</div>