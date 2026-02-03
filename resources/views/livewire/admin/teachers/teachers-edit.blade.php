<div class="p-1">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Professori / Modifica</h2>
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/professori">
            Torna Indietro
        </flux:button>
    </div>

    <div class="w-full mt-5">
        <div class="border border-zinc-300 bg-white dark:bg-zinc-800 dark:border-zinc-700 rounded shadow p-5 space-y-6">
            <div>
                <h3 class="text-base font-semibold mb-4">Dati Anagrafici</h3>
                <div class="w-full flex gap-3">
                    <div class="w-full border-e dark:border-e-zinc-700 pe-3">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="space-y-3">
                                <flux:input label="Nome e Cognome" type="text" id="name" variant="filled" 
                                    wire:model="teacherDetailsStep.name" />
                                <flux:input label="Cod.Fiscale" type="text" id="fiscal_code" variant="filled" 
                                    wire:model="teacherDetailsStep.fiscal_code" />
                                <flux:input label="Numero di telefono" type="text" id="phone_number" variant="filled" 
                                    wire:model="teacherDetailsStep.phone_number" />
                            </div>

                            <div class="space-y-3">
                                <flux:input label="Cap di Residenza" type="text" id="cap" variant="filled" 
                                    wire:model="teacherDetailsStep.cap" />
                                <flux:input label="Nato a" type="text" id="city_birth" variant="filled" 
                                    wire:model="teacherDetailsStep.city_birth" />
                            </div>

                            <div class="space-y-3">
                                <flux:input label="Città di residenza" type="text" id="city" variant="filled" 
                                    wire:model="teacherDetailsStep.city" />
                                <flux:input label="Nato il" type="date" id="date_birth" variant="filled" 
                                    wire:model="teacherDetailsStep.date_birth" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <flux:textarea label="Note" id="note" wire:model="teacherDetailsStep.note" class="bg-zinc-100"/>
                        </div>
                    </div>

                    <div class="w-full space-y-3">
                         <flux:input label="Password" type="password" id="password" variant="filled" 
                            wire:model="teacherDetailsStep.password" />
                    </div>
                </div>

                <div>
                    <div class="flex  flex-col  items-start gap-3 my-3 font-medium text-sm">
                        <label for="url_photo">Foto profilo:</label>
                        <div class="space-x-3">
                            <input type="file" id="url_photo" wire:model="teacherDetailsStep.url_photo"
                                class="hidden" />
                            <flux:button type="button" onclick="document.getElementById('url_photo').click()">
                                Sfoglia file
                            </flux:button>
                            <span
                                class="text-sm {{ $teacherDetailsStep->url_photo ? 'text-gray-700 font-semibold' : 'text-gray-400' }}">
                                @if ($teacherDetailsStep->url_photo)
                                {{ $teacherDetailsStep->url_photo->getClientOriginalName() }}
                                @else
                                Nessun file selezionato
                                @endif
                            </span>
                        </div>

                    </div>
                    @error('studentDetailsStep.url_photo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="border-t dark:border-zinc-700 pt-6">
                <h3 class="text-base font-semibold mb-4">Profilo Professionale</h3>
                <div class="grid grid-cols-3 gap-3">
                    <flux:select id="level_coach" wire:model="professionalProfileStep.level_coach"
                        label="Livello Professionale">
                        <flux:select.option value="">-</flux:select.option>
                        @foreach($levels as $level)
                        <flux:select.option wire:key="level-{{ $level['id'] }}" value="{{ $level['id'] }}">
                            {{ $level['label'] }}
                        </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input id="day_course" wire:model="professionalProfileStep.day_course" variant="filled" 
                        label="Giorni di Lezione Previsti" />
                    <flux:input id="hour_start" type="time" wire:model="professionalProfileStep.hour_start" variant="filled" 
                        label="Ora inizio lezione" />
                    <flux:input id="hour_end" type="time" wire:model="professionalProfileStep.hour_end" variant="filled" 
                        label="Ora fine lezione" />
                    <flux:checkbox.group label="Collaborazione" >
                        <flux:checkbox id="direct_collaboration"
                            wire:model="professionalProfileStep.direct_collaboration" label="Diretta"   />
                    </flux:checkbox.group>

                    <div class="flex items-center gap-3 my-3 col-span-3">
                        <label for="url_file">Titolo Professionale:</label>
                        <input type="file" id="url_file" wire:model="professionalProfileStep.url_file" accept=".pdf"
                            class="hidden" />
                        <flux:button type="button" onclick="document.getElementById('url_file').click()">
                            Scegli file
                        </flux:button>
                        <span
                            class="text-sm {{ $professionalProfileStep->url_file ? 'text-gray-700 dark:text-gray-300 font-semibold' : 'text-gray-400 dark:text-gray-500' }}">
                            @if($professionalProfileStep->url_file)
                            {{ $professionalProfileStep->url_file->getClientOriginalName() }}
                            @elseif($teacher->professionalProfile?->url_file)
                            File attuale: {{ basename($teacher->professionalProfile->url_file) }}
                            @else
                            Nessun file selezionato
                            @endif
                        </span>
                        @error('professionalProfileStep.url_file')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t dark:border-t-zinc-700 pt-5">
                <h3 class="text-base font-semibold mb-4">Materie</h3>
                <flux:checkbox.group wire:model="subjects_selected" class="flex gap-10 my-2">
                    @foreach($subjects as $s)
                    <flux:checkbox wire:key="{{$s->id}}" value="{{$s->id}}" label="{{$s->name}}" />
                    @endforeach
                </flux:checkbox.group>
            </div>

            <div class="flex justify-end gap-3 pt-4  dark:border-zinc-700">
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check" wire:click="submit">
                    Salva Modifiche
                </flux:button>
            </div>
        </div>
    </div>
</div>