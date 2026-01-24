<div class="p-1 mt-5">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Studenti / Modifica</h2>
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/allievi">
            Torna Indietro
        </flux:button>
    </div>

    <div class="w-full mt-5">
        <div class="w-full mt-5">
            <div class="border border-zinc-300 bg-white dark:border-zinc-700 rounded shadow p-5 space-y-6">
                <h3 class="text-lg font-semibold mb-4">Dati Anagrafici</h3>
                <div class="space-y-3">
                    <flux:input label="Nome e Cognome" type="text" id="name" wire:model="studentDetailsStep.name" />
                    <flux:input label="Email" type="email" id="email" disabled value="{{$studentDetailsStep->email}}" />
                    <flux:input label="Password" type="password" id="password"
                        wire:model="studentDetailsStep.password" />
                    <flux:text class="text-sm text-gray-500 dark:text-gray-400">Lascia vuoto per non modificare la
                        password</flux:text>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check"
                        wire:click="submit">
                        Salva Modifiche
                    </flux:button>
                </div>
            </div>
        </div>

    </div>
</div>