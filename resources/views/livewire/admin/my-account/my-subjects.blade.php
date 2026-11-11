<div class="p-1">
    <div class="flex justify-between items-center h-20">
        <h2 class="font-bold text-xl uppercase">Le mie materie</h2>
        <flux:button wire:navigate href="/mia-bacheca" variant="filled" icon="arrow-left" class="cursor-pointer">Torna
            Indietro</flux:button>
    </div>

    <div class="w-full rounded-lg mt-5">
        <div class="flex items-center mb-5">
            <div class="font-semibold text-sm text-zinc-500 dark:text-zinc-400 me-3">
                Numero Elementi
            </div>
            <flux:badge color="gray">{{$subjects->count()}}</flux:badge>
        </div>

        <div class="flex gap-3">
            @if($subjects->count() > 0)
            @foreach($subjects as $subject)
            <flux:badge>{{$subject->name}}</flux:badge>
            @endforeach
            @else
            <div class="w-full flex items-start justify-center text-zinc-500 font-semibold italic">
                Non hai Materie
            </div>
            @endif
        </div>
    </div>
</div>