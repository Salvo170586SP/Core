<div class="p-1">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Studenti / Crea</h2>
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
                <flux:input label="Nome e Cognome" type="text" id="name" wire:model="studentDetailsStep.name" />
                <flux:input label="Email" type="email" id="email" wire:model="studentDetailsStep.email" />
                <flux:input label="Password" type="password" id="password" wire:model="studentDetailsStep.password" />
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

                        <p class="font-medium text-sm @error('studentDetailsStep.name') text-red-500 @enderror">
                            ID Matricola:
                            <span class="font-normal text-base ms-2">{{ $this->studentDetailsStep->generateUniqueCode()
                                }}
                            </span>
                        </p>
                        <p class="font-medium text-sm @error('studentDetailsStep.name') text-red-500 @enderror">
                            Nome e Cognome:
                            <span class="font-normal text-base ms-2">{{ $studentDetailsStep->name ?? '-' }}
                            </span>
                        </p>

                        <p class="font-medium text-sm @error('studentDetailsStep.email') text-red-500 @enderror">
                            @error('studentDetailsStep.email')
                            *
                            @enderror
                            Email:
                            <span class="font-normal text-base ms-2">{{ $studentDetailsStep->email ?? '-' }}
                            </span>
                        </p>
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