@props(['headers','showCheckbox' => false])

<table class="w-full border rounded border-zinc-300 shadow dark:border-zinc-700">
    <thead class="bg-zinc-100 dark:bg-zinc-800 h-[44px] border-b dark:border-zinc-700">
        <tr>
            @if($showCheckbox)
            <th scope="col" class="text-black dark:text-white text-[13px] font-semibold px-2 text-start w-12">
                {{ $checkboxHeader ?? '' }}
            </th>
            @endif
            @foreach($headers as $header)
            <th scope="col"
                class="text-black dark:text-white text-[13px] font-semibold px-2 {{ $header['align'] ?? 'text-start' }}">
                {{ $header['label'] }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-zinc-900">
        {{ $slot }}
    </tbody>
</table>