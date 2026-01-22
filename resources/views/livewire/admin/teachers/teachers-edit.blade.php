<div class="p-1 mt-5">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Professori / Modifica</h2>
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/professori">
            Torna Indietro
        </flux:button>
    </div>

    <div class="w-full mt-5">
        <div class="border border-zinc-300 bg-white dark:border-zinc-700 rounded shadow p-5 space-y-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Dati Anagrafici</h3>
                <div class="space-y-3">
                    <flux:input label="Nome e Cognome" type="text" id="name" wire:model="teacherDetailsStep.name" />
                    <flux:input label="Email" type="email" id="email" disabled value="teacherDetailsStep.email" />
                    <flux:input label="Password" type="password" id="password" wire:model="teacherDetailsStep.password" />
                    <flux:text class="text-sm text-gray-500 dark:text-gray-400">Lascia vuoto per non modificare la password</flux:text>
                </div>
            </div>

            <div class="border-t dark:border-zinc-700 pt-6">
                <h3 class="text-lg font-semibold mb-4">Profilo Professionale</h3>
                <div class="grid grid-cols-3 gap-3">
                    <flux:input id="center" wire:model="professionalProfileStep.center" label="Centro Scolastico" />
                    <flux:select id="level_coach" wire:model="professionalProfileStep.level_coach"
                        label="Livello Professionale">
                        <flux:select.option value="">-</flux:select.option>
                        @foreach($levels as $level)
                        <flux:select.option wire:key="level-{{ $level['id'] }}" value="{{ $level['id'] }}">
                            {{ $level['label'] }}
                        </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input id="day_course" wire:model="professionalProfileStep.day_course"
                        label="Giorni di Lezione Previsti" />
                    <flux:input id="hour_start" type="time" wire:model="professionalProfileStep.hour_start"
                        label="Ora inizio lezione" />
                    <flux:input id="hour_end" type="time" wire:model="professionalProfileStep.hour_end" label="Ora fine lezione" />
                    <flux:checkbox.group label="Collaborazione">
                        <flux:checkbox id="direct_collaboration" wire:model="professionalProfileStep.direct_collaboration"
                            label="Diretta" />
                    </flux:checkbox.group>

                    <div class="flex items-center gap-3 my-3 col-span-3">
                        <label for="file_professional">Allegato:</label>
                        <input type="file" id="file_professional" 
                            wire:model="professionalProfileStep.file_professional" 
                            accept=".pdf,.doc,.docx"
                            class="hidden" />
                        <flux:button type="button" 
                            onclick="document.getElementById('file_professional').click()">
                            Scegli file
                        </flux:button>
                        <span class="text-sm {{ $professionalProfileStep->file_professional ? 'text-gray-700 dark:text-gray-300 font-semibold' : 'text-gray-400 dark:text-gray-500' }}">
                            @if($professionalProfileStep->file_professional)
                                {{ $professionalProfileStep->file_professional->getClientOriginalName() }}
                            @elseif($teacher->professionalProfile?->file_professional)
                                File attuale: {{ basename($teacher->professionalProfile->file_professional) }}
                            @else
                                Nessun file selezionato
                            @endif
                        </span>
                        @error('professionalProfileStep.file_professional')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                       <div class="mt-5">
                <flux:checkbox.group label="Materie" wire:model="subjects_selected" class="flex gap-10 my-2">
                    @foreach($subjects as $s)
                    <flux:checkbox wire:key="{{$s->id}}" value="{{$s->id}}" label="{{$s->name}}" />
                    @endforeach
                </flux:checkbox.group>
            </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check" wire:click="submit">
                    Salva Modifiche
                </flux:button>
            </div>
        </div>
    </div>
</div>
