<div class="p-1">
    <div class="flex justify-end items-center">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/professori">
            Torna Indietro
        </flux:button>
    </div>

    <x-counter-step :currentStep="$currentStep"
        :titles="['1. Dati Anagrafici', ' 2. Profilo Professionale', '3. Materie', ' 4. Riepilogo']" />

    <div class="w-full mt-5">

        @if ($currentStep == 0)

        <x-step-container title="Dati Anagrafici">
            <div class="w-full flex gap-3">

                <div class="w-full border-e dark:border-e-zinc-600 pe-3">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="space-y-3">
                            <flux:input label="Nome e Cognome" type="text" id="name" variant="filled"
                                placeholder="Es. Mario Rossi" wire:model="teacherDetailsStep.name" />
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
                        <flux:textarea label="Note" id="note" wire:model="teacherDetailsStep.note"
                            class="bg-zinc-100" />
                    </div>
                </div>

                <div class="w-full space-y-3">
                    <flux:input label="Email" type="email" id="email" wire:model="teacherDetailsStep.email"
                        variant="filled" placeholder="Es. mariorossi@example.it" />
                    <flux:input label="Password" type="password" id="password" variant="filled"
                        wire:model="teacherDetailsStep.password" />
                </div>
            </div>

            <div>
                <div class="flex  flex-col  items-start gap-3 my-3">
                    <label for="url_photo">Foto profilo:</label>
                    <div class="space-x-3">
                        <input type="file" id="url_photo" wire:model="teacherDetailsStep.url_photo" class="hidden" />
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

            <x-slot:actions>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-right"
                    wire:click="addStep">
                    Avanti
                </flux:button>
            </x-slot:actions>
        </x-step-container>
        @elseif($currentStep == 1)
        <x-step-container title="Profilo Professionale">
            <div class="grid grid-cols-3 gap-3">
                <flux:select id="level_coach" wire:model="professionalProfileStep.level_coach"
                    label="Livello Professionale">
                    <flux:select.option value="">-</flux:select.option>
                    @foreach ($levels as $level)
                    <flux:select.option wire:key="level-{{ $level['id'] }}" value="{{ $level['id'] }}" variant="filled">
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
                <flux:checkbox.group label="Collaborazione">
                    <flux:checkbox id="direct_collaboration" wire:model="professionalProfileStep.direct_collaboration"
                        variant="filled" label="Diretta" />
                </flux:checkbox.group>

                <div class="flex flex-col my-3">
                    <div class="flex items-center gap-3 my-3">
                        <label for="url_file">Titolo Professionale:</label>
                        <input type="file" id="url_file" wire:model="professionalProfileStep.url_file" accept=".pdf"
                            class="hidden" />
                        <flux:button type="button" onclick="document.getElementById('url_file').click()">
                            Sfoglia file
                        </flux:button>
                        <span
                            class="text-sm {{ $professionalProfileStep->url_file ? 'text-gray-700 font-semibold' : 'text-gray-400' }}">
                            @if ($professionalProfileStep->url_file)
                            {{ $professionalProfileStep->url_file->getClientOriginalName() }}
                            @else
                            Nessun file selezionato
                            @endif
                        </span>
                    </div>
                    <div class="text-sm font-medium">*Allegare in formato .pdf</div>
                    @error('professionalProfileStep.url_file')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <x-slot:actions>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-left"
                    wire:click="backStep">
                    Indietro
                </flux:button>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-right"
                    wire:click="addStep">
                    Avanti
                </flux:button>
            </x-slot:actions>
        </x-step-container>
        @elseif($currentStep == 2)
        <x-step-container title="Materie">
            <div class="">
                <div class="flex justify-between items-center gap-3 mb-3">
                    <div class="font-medium text-sm">
                        Materie aggiunte
                        <span
                            class="inline-flex justify-center items-center ms-2 w-5 h-5 bg-zinc-600 text-white rounded-full">{{
                            count($subjectsStep->newSubject) }}</span>
                    </div>
                    <flux:button icon="plus-circle" variant="filled" class="cursor-pointer" wire:click="openNewSubject">
                        Aggiungi Materia</flux:button>
                </div>

                {{-- Lista Specializzazioni --}}
                @if (count($subjectsStep->newSubject) > 0)
                <div
                    class="w-1/2 mx-auto h-[330px] border bg-white dark:bg-zinc-800 dark:border-zinc-500 p-5 rounded-lg overflow-y-auto">
                    @foreach ($subjectsStep->newSubject as $index => $specialization)
                    <div wire:key="newSubject-{{ $index }}-{{ str()->random(10) }}"
                        class="w-full border dark:border-zinc-600 rounded-lg p-5 space-y-5 bg-zinc-100/50 dark:bg-zinc-700/50 mt-3 border-zinc-300 ">
                        <div class="flex items-center justify-between">
                            <flux:button icon="minus-circle" size="sm" variant="primary" color="red"
                                class="cursor-pointer" wire:confirm="Sei sicuro di voler eliminare questo appartamento?"
                                wire:click="closeNewSubject({{ $index }})">Elimina
                                Materia
                            </flux:button>
                            <div
                                class="bg-black text-white rounded-full w-5 h-5 font-bold flex justify-center items-center">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        <flux:select id="name" wire:model="subjectsStep.newSubject.{{ $index }}.subject_id"
                            label="Materia">
                            <flux:select.option value="">-</flux:select.option>
                            @foreach ($subjects as $s)
                            <flux:select.option wire:key="s-{{ $s->id }}-{{$index}}" value="{{ $s->id }}">
                                {{ $s->name}}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                    <p>Nessuna materia aggiunta.</p>
                    <p class="text-sm mt-2">Clicca su "Aggiungi Materia" per iniziare.</p>
                </div>
                @endif
            </div>

            <x-slot:actions>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-left"
                    wire:click="backStep">
                    Indietro
                </flux:button>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-right"
                    wire:click="addStep">
                    Avanti
                </flux:button>
            </x-slot:actions>
        </x-step-container>
        @else
        <x-step-summary title="Riepilogo">
            <div class="flex gap-3 my-3">
                <div class="w-[800px] border dark:border-zinc-700 rounded-2xl p-5">
                    <h2 class="text-sm font-bold">Dati Anagrafici</h2>
                    <div class="space-y-2 mt-3">
                        <div class="w-full flex mb-5">
                            <figure class="w-40 overflow-hidden rounded-lg border border-zinc-300">
                                @if($teacherDetailsStep->url_photo)
                                <img alt="{{$teacherDetailsStep->url_photo}}" class="w-full h-full object-cover"
                                    src="{{ $teacherDetailsStep->url_photo->temporaryUrl() }}" />
                                @else
                                <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}" />
                                @endif
                            </figure>
                            <div class="space-y-5 ms-5">
                                <div
                                    class="font-medium text-sm inline-block @error('teacherDetailsStep.name') text-red-500 @enderror">
                                    <div>
                                        Nome e Cognome
                                    </div>
                                    <div class="font-normal text-base ">
                                        {{ $teacherDetailsStep->name ?? '-' }}
                                    </div>
                                </div>

                                <div
                                    class="font-medium text-sm @error('teacherDetailsStep.email') text-red-500 @enderror">
                                    @error('teacherDetailsStep.email')
                                    *
                                    @enderror
                                    <div>
                                        Email
                                    </div>
                                    <div class="font-normal text-base ">{{ $teacherDetailsStep->email ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full border dark:border-zinc-700 rounded-2xl p-5">
                    <h2 class="text-sm font-bold">Profilo Professionale</h2>
                    <div class="space-y-2 grid grid-cols-2 mt-3">
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.level_coach') text-red-500 @enderror">
                            @error('professionalProfileStep.level_coach')
                            *
                            @enderror
                            Livello Professionale:
                            <span class="font-normal text-base ms-2">
                                {{ $this->getLevelLabel($professionalProfileStep?->level_coach) }}
                            </span>
                        </p>
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.direct_collaboration') text-red-500 @enderror">
                            @error('professionalProfileStep.direct_collaboration')
                            *
                            @enderror
                            Collaborazione Diretta: <span class="font-normal text-base ms-2">{{
                                $professionalProfileStep->direct_collaboration ?? '-' }}</span>
                        </p>
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.day_course') text-red-500 @enderror">
                            @error('professionalProfileStep.day_course')
                            *
                            @enderror
                            Giorni di lezione previsti: <span class="font-normal text-base ms-2">{{
                                $professionalProfileStep->day_course ?? '-' }}</span>
                        </p>
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.hour_start') text-red-500 @enderror">
                            @error('professionalProfileStep.hour_start')
                            *
                            @enderror
                            Ora inizio lezione: <span class="font-normal text-base ms-2">{{
                                $professionalProfileStep->hour_start ?? '-' }}</span>
                        </p>
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.hour_end') text-red-500 @enderror">
                            @error('professionalProfileStep.hour_end')
                            *
                            @enderror
                            Ora fine lezione: <span class="font-normal text-base ms-2">{{
                                $professionalProfileStep->hour_end ?? '-' }}</span>
                        </p>
                        <p
                            class="font-medium text-sm @error('professionalProfileStep.url_file') text-red-500 @enderror">
                            @error('professionalProfileStep.url_file')
                            *
                            @enderror
                            Documento Professionale: <span class="font-normal text-base ms-2">
                                @if ($professionalProfileStep->url_file)
                                {{ $professionalProfileStep->url_file->getClientOriginalName() }}
                                @else
                                -
                                @endif
                            </span></p>
                    </div>
                </div>
            </div>

            <div class="w-full border dark:border-zinc-700 rounded-2xl p-5">
                <h2 class="text-sm font-bold">Materie</h2>
                <div class="space-y-2 grid grid-cols-2 mt-3">
                    @if (count($subjectsStep->newSubject) > 0)
                    <ul class="space-y-2">
                        @foreach ($subjectsStep->newSubject as $index => $sub)
                        @php
                        $subject = App\Models\Subject::find($sub['subject_id']);
                        @endphp
                        <li class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-700/30 rounded">
                            <span class="font-medium text-sm">
                                <span class="text-zinc-500 dark:text-zinc-400">{{ $index + 1 }}.</span>
                                {{ $subject->name ?? '-' }}
                            </span>

                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 italic">
                        Nessuna materia aggiunta
                    </p>
                    @endif
                </div>
            </div>

            <x-slot:actions>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-left"
                    wire:click="backStep">
                    Indietro
                </flux:button>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check" wire:click="submit">
                    Crea
                </flux:button>
            </x-slot:actions>
        </x-step-summary>

        @endif

    </div>
</div>