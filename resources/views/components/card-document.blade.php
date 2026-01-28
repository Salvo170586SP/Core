@props([
'item',
'student',
'teacher',

])

<div wire:navigate href="documenti/{{$item->id}}"
    class="w-50 bg-zinc-50 hover:shadow-lg transition border border-zinc-200 rounded cursor-pointer">
    <div class="flex justify-center border-b relative">
        <svg width="90" height="90" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4 4C2.89543 4 2 4.89543 2 6V18C2 19.1046 2.89543 20 4 20H20C21.1046 20 22 19.1046 22 18V9C22 7.89543 21.1046 7 20 7H11L9 4H4Z"
                fill="#1E88E5" />
            <path
                d="M2 10C2 8.89543 2.89543 8 4 8H20C21.1046 8 22 8.89543 22 10V18C22 19.1046 21.1046 20 20 20H4C2.89543 20 2 19.1046 2 18V10Z"
                fill="#42A5F5" />
        </svg>
        <div class="absolute top-3 right-13 shadow  bg-blue-500 w-6 h-6 flex justify-center items-center font-bold text-white rounded-full">
            @if($item->hasRole('allievo'))
            {{ $item->documentsAsStudent->count()}}
            @elseif($item->hasRole('istruttore'))
            {{$item->documentsAsTeacher->count()}}
            @endif
        </div>
    </div>
    <div class="p-2 text-sm font-medium">
        <div class="flex items-center justify-center">
            <div class="font-medium">
                {{$item->name}}
            </div>
        </div>
    </div>
</div>