@props(['titles', 'currentStep'])

<div class="flex gap-2">
    @foreach($titles as $title)
    <flux:badge variant="primary" :color="$currentStep >= $loop->index ? 'blue' : 'gray'">
        {{ $title }}
    </flux:badge>
    @endforeach
</div>