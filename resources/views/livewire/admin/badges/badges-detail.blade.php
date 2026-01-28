<div class="p-1">
    <div class="space-y-3">
        <div class="text-end">
            <flux:button variant="filled" class="font-semibold cursor-pointer" icon="arrow-left" wire:navigate
                href="/tesserini-allievi">
                Torna indietro
            </flux:button>
        </div>
        <div class="flex justify-center gap-3 h-25">

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-1">
                <div class="font-semibold text-lg capitalize">
                    {{ $student->name }}
                </div>
                <div class="flex justify-between items-center font-medium">
                    Matricola: <span class="text-sm font-semibold"> {{ $student->code }} </span>
                </div>
                <div class="flex justify-between items-center font-medium">
                    Tesseramenti attivi: <span class="bg-black text-white font-semibold rounded text-center w-5 h-5">
                        {{$student->coursesStudents()->wherePivot('is_active',
                        true)->count()
                        }}</span>
                </div>
            </div>

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-2">
                <div class="flex justify-between font-medium">
                    Cod Fiscale:
                    <span class="text-sm font-semibold">{{ $student->detailsAsStudent?->fiscal_code ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center font-medium">
                    Nato il: <span class="text-sm  font-semibold"> {{
                        $student->detailsAsStudent?->date_birth?->format('d-m-Y') ?? '-' }} </span>
                </div>
                <div class="flex justify-between items-center font-medium">
                    A:
                    <span class="text-sm font-semibold">{{ $student->detailsAsStudent?->city_birth ?? '-' }}</span>
                </div>
            </div>

            <div class="w-full border border-zinc-300 bg-white p-3 rounded shadow text-sm space-y-2">
                <div class="flex justify-between items-center font-medium">
                    Tel: <span class="text-sm font-semibold"> {{ $student->detailsAsStudent?->phone_number ?? '-' }}
                    </span>
                </div>
                <div class="flex justify-between font-medium">
                    Email: <span class="text-sm font-semibold">
                        {{ $student->email ?? '-' }} </span>
                </div>
                <div class="flex justify-between font-medium">
                    Residente a: <span class="text-sm font-semibold">
                        {{ $student->detailsAsStudent?->city ?? '-' }} </span>
                </div>
            </div>
        </div>


        <div class="w-full">
            <div class="border border-zinc-300 bg-white p-5 rounded shadow text-sm">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-medium">Tesseramenti Attivi</h3>
                </div>
                <div class="flex items-center mb-5">
                    <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                        Numero Elementi
                    </div>
                    <flux:badge color="gray">{{$student->coursesStudents()->count()}}</flux:badge>
                </div>
                @if($student->coursesStudents()->count() > 0)
                <x-table :headers="[
                                ['label' => 'Cod'],
                                ['label' => 'Nome Corso'],
                                ['label' => 'Tesserato', 'align' => 'text-center'],
                                ['label' => 'Emesso il', 'align' => 'text-center'],
                                ['label' => 'Numero', 'align' => 'text-center'],
                                ['label' => '']
                            ]" :show-checkbox="false">
                    @foreach($student->coursesStudents as $course)
                    <tr wire:key="student-course-{{$student->id}}-{{$course->id}}"
                        class="border-b dark:border-zinc-700 h-[60px] text-sm">

                        <td class="px-3 font-bold text-sm">{{$course->code}}</td>
                        <td class="px-3">{{$course->name}}</td>
                        <td class="px-3 text-center">
                            <flux:badge color="blue">{{$course->pivot->is_active ? 'Tesserato' : 'Non Tesserato'}}
                            </flux:badge>
                        </td>
                        <td class="px-3 text-center">
                            {{ $course->getDate($course->pivot->issued_at) }}
                        </td>
                        <td class="px-3 text-center">
                            {{$course->pivot->badge_number ?? '-'}}
                        </td>
                        <td class="px-3">
                            <div class="flex justify-end gap-2">
                                <flux:button wire:navigate icon="eye" variant="filled" size="sm" class="cursor-pointer"
                                    href="/tesserini-allievi/{{$student->id}}/corso/{{$course->id}}">Dettagli
                                </flux:button>
                                <flux:modal.trigger name="delete-course-allievo-{{$student->id}}-{{$course->id}}">
                                    <flux:button icon="trash" variant="danger" size="sm" class="cursor-pointer">Elimina
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal name="delete-course-allievo-{{$student->id}}-{{$course->id}}"
                                    class="md:w-96">
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="xl">Attenzione</flux:heading>
                                            <flux:text class="mt-2">Sei sicuro di escludere l'elemento?
                                            </flux:text>
                                        </div>
                                        <div class="flex gap-2">
                                            <flux:spacer />
                                            <flux:modal.close>
                                                <flux:button variant="ghost">Cancel</flux:button>
                                            </flux:modal.close>
                                            <flux:button wire:click="detachCourseStudent({{$course->id}})"
                                                variant="danger" class="cursor-pointer">Elimina</flux:button>
                                        </div>
                                    </div>
                                </flux:modal>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-table>
                @else
                <div>Non ci sono tesseramenti attivi</div>
                @endif
            </div>

        </div>
    </div>