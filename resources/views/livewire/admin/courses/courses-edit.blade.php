<div class="p-1">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-lg uppercase">Tutti i corsi / Modifica</h2>
        <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
            href="/tutti-corsi">
            Torna Indietro
        </flux:button>
    </div>


    <div class="w-full rounded-lg mt-5">

        <x-step-container title="Dati del corso">
            <div class="grid grid-cols-3 gap-5">
                <div class="space-y-3">
                    <flux:input label="Nome del corso" type="text" id="name" wire:model="name" />
                    <flux:textarea label="Descrizione" id="description" wire:model="description" />
                </div>
                <div class="space-y-3">
                    <flux:select label="Livello" id="level" wire:model="level">
                        <flux:select.option label="-" value="" />
                        @foreach($levels_course as $key => $l)
                        <flux:select.option wire:key="l-{{$key}}-{{$l['id']}}" label="{{$l['label']}}"
                            value="{{$l['id']}}" />
                        @endforeach
                    </flux:select>
                    <flux:input type="number" label="Durata" id="duration_hours" wire:model="duration_hours" />
                </div>
                <div class="space-y-3">
                    <flux:input type="number" label="Max Studenti" id="max_students" wire:model="max_students" />
                    <flux:input type="number" label="Min Studenti" id="min_students" wire:model="min_students" />
                </div>
                <div class="space-y-3">
                    <flux:input type="date" label="Data di inizio" id="start_date" wire:model="start_date" />
                    <flux:input type="date" label="Data di fine" id="end_date" wire:model="end_date" />
                </div>
                <div class="space-y-3">
                    <flux:select label="Stato" id="status" wire:model="status">
                        <flux:select.option label="-" value="" />
                        @foreach($status_course as $key => $s)
                        <flux:select.option wire:key="s-{{$key}}-{{$s['id']}}" label="{{$s['label']}}"
                            value="{{$s['id']}}" />
                        @endforeach
                    </flux:select>
                    <flux:input label="Centro Scolastico" id="center" wire:model="center" />
                </div>
                <div class="space-y-3">
                    <flux:select label="Iscrizioni" id="recruitment_status" wire:model="recruitment_status">
                        @foreach($recruitments_state as $key => $sr)
                        <flux:select.option wire:key="sr-{{$key}}-{{$sr['id']}}" label="{{$sr['label']}}"
                            value="{{$sr['id']}}" />
                        @endforeach
                    </flux:select>
 
                    <flux:input label="Prezzo" id="price" wire:model="price" />
                </div>
                <flux:checkbox.group label="Certificazione">
                    <flux:checkbox id="certification" wire:model="certification" />
                </flux:checkbox.group>
            </div>

            <div class="mt-10">
                <flux:checkbox.group label="Materie" wire:model="subjects_selected" class="flex gap-10 my-2">
                    @foreach($subjects as $s)
                    <flux:checkbox wire:key="{{$s->id}}" value="{{$s->id}}" label="{{$s->name}}" />
                    @endforeach
                </flux:checkbox.group>
            </div>


            <x-slot:actions>
                <flux:button variant="primary" class="font-semibold cursor-pointer" icon="check" wire:click="submit">
                    Salva Modifiche
                </flux:button>
            </x-slot:actions>
        </x-step-container>

    </div>
</div>