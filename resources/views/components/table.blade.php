@props(['headers'])

<table class="w-full border border-zinc-200 dark:border-zinc-700">
    <thead class="bg-zinc-100 dark:bg-zinc-800 h-[44px] border-b dark:border-zinc-700">
        <tr>
            @foreach($headers as $header)
            <th scope="col" class="text-black dark:text-white text-[13px] font-semibold px-2 {{ $header['align'] ?? 'text-start' }}">
                {{ $header['label'] }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-zinc-900">
        {{ $slot }}
    </tbody>
</table>