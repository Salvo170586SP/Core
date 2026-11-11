    @props([
        'selected',
        'function'
    ])
    
    @if(count($selected) > 0)
    <div
        class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-zinc-900 rounded  border border-blue-300 dark:border-zinc-800">
        <flux:icon.check-circle variant="mini" class="text-blue-600 dark:text-zinc-400" />
        <span class="text-sm font-semibold text-blue-800 dark:text-zinc-200">
            {{ count($selected) }} {{ count($selected) === 1 ? 'elemento selezionato' : 'elementi selezionati' }}
        </span>
        <flux:spacer />
        <flux:modal.trigger name="delete-profile">
            <flux:button variant="danger" class="font-medium">Elimna Selezione</flux:button>
        </flux:modal.trigger>

        <flux:modal name="delete-profile" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg"></flux:heading>

                    <flux:text class="mt-2">
                      Sei sicuro di eliminare i selezionati?
                    </flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger" wire:click="{{$function}}">Elimina</flux:button>
                </div>
            </div>
        </flux:modal>
        <flux:button wire:click="clearSelection" variant="ghost" size="sm"
            class="cursor-pointer">
            Cancella selezione
        </flux:button>
    </div>
    @endif