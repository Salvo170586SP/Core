@props([
'student',
'course'
])

<div class="w-150 h-75 bg-blue-600 border border-blue-500 shadow-lg rounded-lg">
    <div class="text-xs text-white p-2 text-end font-medium">
        Numero Tessera: <span class="text-sm font-semibold">{{
            $student->coursesStudents->firstWhere('id', $course->id)->pivot->badge_number
            }}</span>
    </div>

    <div class="bg-white p-3">
        <div class="flex items-center justify-between">
            <div class="flex gap-5">
                <figure class="w-25 h-25 rounded-lg border border-blue-500 overflow-hidden">
                    @if($student->documentsAsStudent->where('type', 'foto_profilo')->first())
                    <img alt="{{$student->documentsAsStudent->where('type', 'foto_profilo')->first()->name}}"
                        class="w-full h-full object-cover"
                        src="{{asset('storage/'. $student->documentsAsStudent->where('type', 'foto_profilo')->first()->url_file )}}" />
                    @else
                    <img alt="placeholder" src="{{asset('./assets/icons/placeholder.png')}}" />
                    @endif
                </figure>

                <div class="font-medium">
                    <p class="text-xs">
                        Studente: <span class="text-sm font-semibold"> {{ $student->name }} </span>
                    </p>
                    <p class="text-xs">
                        Matricola: <span class="text-sm font-semibold">{{ $student->code }} </span>
                    </p>
                </div>
            </div>

            <figure class="w-15 h-15 -mt-10 rounded-lg border border-blue-500 overflow-hidden">
                @if($student->coursesStudents->firstWhere('id',
                $course->id)->pivot->badge_number)
                <img src="{{ $this->getQrCode() }}" class="w-full" alt="QR Code">
                @endif
            </figure>
        </div>
        <div class="font-medium text-xs flex justify-end gap-5">
            <div class="font-medium text-xs">
                Corso: <span class="text-sm font-semibold"> {{ $course->name }} </span>
            </div>
            <div class="font-medium text-xs">
                Rilasciato il: <span class="text-sm font-semibold"> {{
                    $student->getDate($student->coursesStudents->firstWhere('id',
                    $course->id)->pivot->issued_at) }} </span>
            </div>
        </div>
    </div>

    <div class="bg-black h-15 mt-10"></div>
</div>