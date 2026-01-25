<div class="w-full h-[60px] px-4 flex items-center">
    <flux:breadcrumbs>
        @foreach($items as $index => $item)
        @if(isset($item['route']))
        <flux:breadcrumbs.item wire:navigate href="{{ route($item['route']) }}"
            icon="{{ $index === 0 && isset($item['icon']) ?  $item['icon'] : ''}}">
            {{ $item['label'] }}
        </flux:breadcrumbs.item>
        @else
        <flux:breadcrumbs.item wire:navigate>
            {{ $item['label'] }}
        </flux:breadcrumbs.item>
        @endif
        @endforeach
    </flux:breadcrumbs>
</div>