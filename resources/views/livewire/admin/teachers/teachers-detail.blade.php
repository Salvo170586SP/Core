<div class="p-1 mt-5">
    <div class="flex gap-5">


        <div class="w-100 space-y-3">
            <div class="border bg-white p-3 rounded-lg text-sm">
                <h3 class="font-semibold mb-2">Dati Anagrafici</h3>
                <div class="flex flex-col justify-center">
                    <div class="font-semibold text-xl">
                        {{ $teacher->name }}
                    </div>
                    <div>
                        {{ $teacher->email }}
                    </div>
                </div>
            </div>

            <div class=" border bg-white p-3 rounded-lg   text-sm">
                <h3 class="font-semibold mb-2">Specializzazioni</h3>
                @if($teacher->specializations->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-black dark:text-white text-[13px] font-semibold pe-2">
                                Specializzazione
                            </th>
                            <th scope="col" class="text-black dark:text-white text-[13px] font-semibold pe-2">
                                Consguita nel
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teacher->specializations as $key => $value)
                        <tr>
                            <td class="pe-2">{{ $value->name }}</td>
                            <td class="pe-2">{{ $value->pivot->year }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Nessuna specializzazione
                @endif
            </div>

            <div class="border bg-white p-3 rounded-lg text-sm">
                <h3 class="font-semibold mb-2 textcenter">Profilo Professionale</h3>
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Livello Professionale:</span>
                        <span>{{ $teacher->getLevelLabel($teacher->professionalProfile?->level_coach) }}</span>
                    </div>
                    <div class="flex items-center  justify-between">
                        <span class="font-medium">Collaborazione diretta:</span>
                        @if($teacher->professionalProfile && $teacher->professionalProfile->direct_collaboration)
                        <flux:icon.check-circle color="blue" variant="mini" />
                        @else
                        <flux:icon.x-circle color="red" variant="mini" />
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Centro Scolastico:</span>
                        {{ $teacher->professionalProfile->center ?? '-' }}
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-medium">Giorni di lezione:</span>
                        <span>{{ $teacher->professionalProfile->day_course ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Orario inizio:</span>
                        <span>{{ $teacher->professionalProfile->hour_start ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Orario fine:</span>
                        <span>{{ $teacher->professionalProfile->hour_end ?? '-' }}</span>
                    </div>
                    @if($teacher->professionalProfile->file_professional )
                    <div class="flex flex-col justify-between mt-5">
                        <span class="font-medium">Allegato:</span>
                        <div class="space-x-1 mt-2">
                            <flux:button download size="sm"
                                href="{{asset('storage/'. $teacher->professionalProfile->file_professional )}}"
                                icon="arrow-down-tray" />
                            <flux:button target="_blanck" size="sm"
                                href="{{asset('storage/'. $teacher->professionalProfile->file_professional )}}"
                                icon="eye" />
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="border bg-white p-3 rounded-lg text-sm">
                <div class="text-end">
                    <flux:button variant="primary" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
                        href="/professori">
                        Torna indietro
                    </flux:button>
                </div>

                <div class="mt-5">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit repellat exercitationem obcaecati
                    reiciendis praesentium eum beatae nulla a eaque. Nam consequatur modi, quas itaque laudantium nisi
                    accusantium enim animi molestiae.
                </div>
            </div>
        </div>
    </div>
</div>