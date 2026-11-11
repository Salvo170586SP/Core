<div class="p-1">
    <div class="flex justify-end items-center">
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/allievi">
            Torna Indietro
        </flux:button>
    </div>

    <x-counter-step :currentStep="$currentStep"
        :titles="['1. Dati Anagrafici', '2. Seleziona Corsi', '3. Riepilogo']" />

    <div class="w-full mt-5">

        @if ($currentStep == 0)

        <x-step-container title="Dati Anagrafici">
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-5">
                    <div class="border-e dark:border-e-zinc-700 pe-5 gap-5">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="space-y-3">
                                <flux:input label="Nome e Cognome" type="text" id="name" variant="filled"
                                    placeholder="Es. Mario Rossi" wire:model="studentDetailsStep.name" />
                                <flux:input label="Cod.Fiscale" type="text" id="fiscal_code" variant="filled"
                                    wire:model="studentDetailsStep.fiscal_code" />
                                <flux:input label="Città di residenza" type="text" id="city" variant="filled"
                                    wire:model="studentDetailsStep.city" />
                            </div>
                            <div class="space-y-3">
                                <flux:input label="Cap di Residenza" type="text" id="cap" variant="filled"
                                    wire:model="studentDetailsStep.cap" />
                                <flux:input label="Nato a" type="text" id="city_birth" variant="filled"
                                    wire:model="studentDetailsStep.city_birth" />
                            </div>
                            <div class="space-y-3">
                                <flux:input label="Nato il" type="date" id="date_birth" variant="filled"
                                    wire:model="studentDetailsStep.date_birth" />
                                <flux:input label="Numero di telefono" type="text" id="phone_number" variant="filled"
                                    wire:model="studentDetailsStep.phone_number" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <flux:textarea label="Note" id="note" wire:model="studentDetailsStep.note"
                                class="bg-zinc-100" />
                        </div>
                    </div>

                    <div class="space-y-3">
                        <flux:input label="Email" type="email" id="email" wire:model="studentDetailsStep.email"
                            variant="filled" placeholder="Ex. mariorossi@example.it" />
                        <flux:input label="Password" type="password" id="password" variant="filled"
                            wire:model="studentDetailsStep.password" />
                    </div>
                </div>

                <div class="flex  items-center gap-10 mt-5 border-t dark:border-t-zinc-700">
                    <div class="flex flex-col mt-5 border-e dark:border-e-zinc-700 pe-5">
                        <div class="flex flex-col  items-start gap-3 my-3  text-sm font-medium">
                            <label for="url_file">Carica o sostituisci documento d'identità:</label>
                            <div class="text-sm font-medium">*Allegare in formato .pdf</div>
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
                        </div>
                        @error('studentDetailsStep.url_file')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col items-start gap-3 my-3 text-sm font-medium">
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
        <x-step-container title="Seleziona Corsi">

            <x-table :headers="[
                ['label' => 'ID'],
                ['label' => 'Nome Corso'],
                ['label' => 'Livello', 'align' => 'text-center'],
                ['label' => 'Durata (ore)', 'align' => 'text-center'],
                ['label' => 'Data Inizio', 'align' => 'text-center'],
                ['label' => 'Data Fine', 'align' => 'text-center'],
                ['label' => 'Stato', 'align' => 'text-center'],
                ['label' => '']
                ]" :show-checkbox="true">

                @foreach($courses as $course)
                <tr wire:key="course-{{$course->id}}" class="border-b dark:border-zinc-700 h-[60px] text-sm">
                    <td class="ps-5">
                        <flux:checkbox wire:model.live="coursesAddStep.courses_selected" value="{{ $course->id }}" />
                    </td>
                    <td class="px-3 font-bold text-sm">{{ $course->code }}</td>
                    <td class="px-1 font-semibold">{{ $course->name }}</td>
                    <td class="px-1 text-center">
                        <flux:badge color="{{ $course->getLevelColor($course->level) }}" size="sm">
                            {{ $course->getLevelLabel($course->level) }}
                        </flux:badge>
                    </td>
                    <td class="px-1 text-center">{{ $course->duration_hours }}h</td>

                    <td class="px-1 text-center">{{ $course->start_date->format('d/m/Y') }}</td>
                    <td class="px-1 text-center">{{ $course->end_date->format('d/m/Y') }}</td>
                    <td class="px-1 text-center">
                        <flux:badge color="{{ $course->getStatusColor($course->status) }}" size="sm">
                            {{ $course->getStatusLabel($course->status) }}
                        </flux:badge>
                    </td>

                    <td class="px-1">
                        <div class="flex justify-center">
                            <flux:button wire:navigate icon="eye" variant="ghost" size="sm"
                                href="/tutti-corsi/{{$course->id}}">
                            </flux:button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </x-table>

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
                        <div class="w-full flex mb-5">
                            <figure class="w-40 overflow-hidden rounded-lg border border-zinc-300">
                                @if($studentDetailsStep->url_photo)
                                <img alt="{{$studentDetailsStep->url_photo}}" class="w-full h-full object-cover"
                                    src="{{ $studentDetailsStep->url_photo->temporaryUrl() }}" />
                                @else
                                <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}"
                                    class="w-full h-full object-cover" />
                                @endif
                            </figure>
                            <div class="space-y-5 ms-5">
                                <div
                                    class="font-medium text-sm @error('studentDetailsStep.name') text-red-500 @enderror">
                                    <div>
                                        ID Matricola:
                                    </div>
                                    <div class="font-normal text-base ms-2">{{
                                        $this->studentDetailsStep->generateUniqueCode()
                                        }}
                                    </div>
                                </div>
                                <div
                                    class="font-medium text-sm @error('studentDetailsStep.name') text-red-500 @enderror">
                                    <div>
                                        Nome e Cognome:
                                    </div>
                                    <div class="font-normal text-base ms-2">{{ $studentDetailsStep->name ?? '-' }}
                                    </div>
                                </div>

                                <div
                                    class="font-medium text-sm @error('studentDetailsStep.email') text-red-500 @enderror">
                                    @error('studentDetailsStep.email')
                                    *
                                    @enderror
                                    <div>
                                        Email:
                                    </div>
                                    <div class="font-normal text-base ms-2">{{ $studentDetailsStep->email ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full border dark:border-zinc-700 rounded-2xl p-5">
                    <h2 class="text-sm font-bold">Corsi Selezionati</h2>
                    <div class="space-y-2 mt-3">
                        @if(!empty($coursesAddStep->courses_selected))
                        @foreach($courses->whereIn('id', $coursesAddStep->courses_selected) as $course)
                        <div class="w-100 flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <div class="flex-1">
                                <p class="font-semibold text-sm">{{ $course->code }} - {{ $course->name }}</p>
                                <div class="flex gap-2 mt-1">
                                    <flux:badge color="{{ $course->getLevelColor($course->level) }}" size="sm">
                                        {{ $course->getLevelLabel($course->level) }}
                                    </flux:badge>
                                </div>
                            </div>
                            <div class="text-right text-sm">
                                <p class="font-medium">{{ $course->duration_hours }}h</p>
                                <p class="text-xs text-zinc-500">
                                    {{ $course->start_date->format('d/m/Y') }} - {{ $course->end_date->format('d/m/Y')
                                    }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="text-sm text-zinc-500 italic">Nessun corso selezionato</p>
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