<div class="p-1 mt-5">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Professori / Crea</h2>
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
            <div class="space-y-3">
                <flux:input label="Nome e Cognome" type="text" id="name" wire:model="teacherDetailsStep.name" />
                <flux:input label="Email" type="email" id="email" wire:model="teacherDetailsStep.email" />
                <flux:input label="Password" type="password" id="password" wire:model="teacherDetailsStep.password" />
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
                <flux:input id="center" wire:model="professionalProfileStep.center" label="Centro Scolastico" />
                <flux:select id="level_coach" wire:model="professionalProfileStep.level_coach"
                    label="Livello Professionale">
                    <flux:select.option value="">-</flux:select.option>
                    @foreach ($levels as $level)
                    <flux:select.option wire:key="level-{{ $level['id'] }}" value="{{ $level['id'] }}">
                        {{ $level['label'] }}
                    </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input id="day_course" wire:model="professionalProfileStep.day_course"
                    label="Giorni di Lezione Previsti" />
                <flux:input id="hour_start" type="time" wire:model="professionalProfileStep.hour_start"
                    label="Ora inizio lezione" />
                <flux:input id="hour_end" type="time" wire:model="professionalProfileStep.hour_end"
                    label="Ora fine lezione" />
                <flux:checkbox.group label="Collaborazione">
                    <flux:checkbox id="direct_collaboration" wire:model="professionalProfileStep.direct_collaboration"
                        label="Diretta" />
                </flux:checkbox.group>

                <div class="flex items-center gap-3 my-3">
                    <label for="file_professional">Allegato:</label>
                    <input type="file" id="file_professional" wire:model="professionalProfileStep.file_professional"
                        accept=".pdf,.doc,.docx" class="hidden" />
                    <flux:button type="button" onclick="document.getElementById('file_professional').click()">
                        Scegli file
                    </flux:button>
                    <span
                        class="text-sm {{ $professionalProfileStep->file_professional ? 'text-gray-700 font-semibold' : 'text-gray-400' }}">
                        @if ($professionalProfileStep->file_professional)
                        {{ $professionalProfileStep->file_professional->getClientOriginalName() }}
                        @else
                        Nessun file selezionato
                        @endif
                    </span>
                    @error('professionalProfileStep.file_professional')
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

                        {{-- <flux:input type="number" id="year" wire:model="subjectsStep.newSubject.{{ $index }}.year"
                            label="Anno" min="1900" max="2155" placeholder="Anno" required /> --}}
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
            <div class="grid grid-row-2 gap-3 my-3">
                <div class="w-full border dark:border-zinc-700 rounded-2xl p-5">
                    <h2 class="text-sm font-bold">Dati Anagrafici</h2>
                    <div class="space-y-2 mt-3">

                        <p class="font-medium text-sm @error('teacherDetailsStep.name') text-red-500 @enderror">
                            Nome e Cognome:
                            <span class="font-normal text-base ms-2">{{ $teacherDetailsStep->name ?? '-' }}
                            </span>
                        </p>

                        <p class="font-medium text-sm @error('teacherDetailsStep.email') text-red-500 @enderror">
                            @error('teacherDetailsStep.email')
                            *
                            @enderror
                            Email:
                            <span class="font-normal text-base ms-2">{{ $teacherDetailsStep->email ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="w-full border dark:border-zinc-700 rounded-2xl p-5">
                    <h2 class="text-sm font-bold">Profilo Professionale</h2>
                    <div class="space-y-2 grid grid-cols-2 mt-3">
                        <p class="font-medium text-sm @error('professionalProfileStep.center') text-red-500 @enderror">
                            @error('professionalProfileStep.center')
                            *
                            @enderror
                            Centro Scolastico: <span class="font-normal text-base ms-2">{{
                                $professionalProfileStep->center ?? '-' }}</span>
                        </p>
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
                            class="font-medium text-sm @error('professionalProfileStep.file_professional') text-red-500 @enderror">
                            @error('professionalProfileStep.file_professional')
                            *
                            @enderror
                            File Professionale: <span class="font-normal text-base ms-2">
                                @if ($professionalProfileStep->file_professional)
                                {{ $professionalProfileStep->file_professional->getClientOriginalName() }}
                                @else
                                -
                                @endif
                            </span></p>
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