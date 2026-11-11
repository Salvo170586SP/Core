@props([
    'title1' => null,
    'title2' => null,
    'items1' => null,
    'items2' => null,
])

<div class="overflow-hidden rounded bg-white dark:bg-zinc-800 border shadow border-neutral-200 dark:border-neutral-700">
    <div class="flex flex-col h-full gap-3 p-3">
        <div class="font-medium flex justify-between">
            <div class="font-medium uppercase text-sm">
                {{$title1}}
            </div>
            <span class="font-semibold w-5 h-5 border border-zinc-400 rounded flex justify-center items-center">
                {{$items1->count()}}
            </span>
        </div>
        <div class="font-medium flex justify-between">
            <div class="font-medium uppercase text-sm">
              {{$title2}}
            </div>
            <span class="font-semibold w-5 h-5 border border-zinc-400 rounded flex justify-center items-center">
                {{$items2->count()}}
            </span>
        </div>
    </div>
</div>