<div class="p-1">
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
                <div class="space-y-3 grid grid-cols-2 gap-5">
                    <div class="border-e pe-3">
                        <flux:input label="Nome e Cognome" type="text" id="name" wire:model="studentDetailsStep.name" />
                        <div class="flex flex-col my-3">
                            <div class="flex  flex-col  items-start gap-3 my-3">
                                <label for="url_photo">Foto profilo:</label>
                                <div class="space-x-3">
                                    <input type="file" id="url_photo" wire:model="studentDetailsStep.url_photo"
                                     class="hidden" />
                                    <flux:button type="button" onclick="document.getElementById('url_photo').click()">
                                        Sfoglia file
                                    </flux:button>
                                    <span
                                        class="text-sm {{ $studentDetailsStep->url_photo ? 'text-gray-700 font-semibold' : 'text-gray-400' }}">
                                        @if ($studentDetailsStep->url_photo)
                                        {{ $studentDetailsStep->url_photo->getClientOriginalName() }}
                                        @else
                                        Nessun file selezionato
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @error('studentDetailsStep.url_file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="space-y-3">
                        <flux:input label="Email" type="email" id="email" disabled
                            value="{{$studentDetailsStep->email}}" />

                        <flux:input label="Password" type="password" id="password"
                            wire:model="studentDetailsStep.password" />
                        <flux:text class="text-sm text-gray-500 dark:text-gray-400">Lascia vuoto per non modificare la
                            password</flux:text>
                    </div>
                </div>
                <div class="flex flex-col my-3">
                    <div class="flex  flex-col  items-start gap-3 my-3">
                        <label for="url_file">Carica o sostituisci documento d'identità:</label>
                        <div class="space-x-3">
                            <input type="file" id="url_file" wire:model="studentDetailsStep.url_file" accept=".pdf"
                                class="hidden" />
                            <flux:button type="button" onclick="document.getElementById('url_file').click()">
                                Sfoglia file
                            </flux:button>
                            <span
                                class="text-sm {{ $studentDetailsStep->url_file ? 'text-gray-700 font-semibold' : 'text-gray-400' }}">
                                @if ($studentDetailsStep->url_file)
                                {{ $studentDetailsStep->url_file->getClientOriginalName() }}
                                @else
                                Nessun file selezionato
                                @endif
                            </span>
                        </div>
                        <div class="text-sm font-medium">*Allegare in formato .pdf</div>
                    </div>
                    @error('studentDetailsStep.url_file')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check"
                        wire:click="submit">
                        Salva Modifiche
                    </flux:button>
                </div>
            </div>
        </div>

    </div>
</div>