<div x-data="{isOpen: false }" class="relative">
    <button @click="isOpen = !isOpen"
        class="w-50 bg-white shadow hover:shadow-lg focus:shadow-lg border border-gray-300 rounded-lg p-2 cursor-pointer transition-all">
        <div class="flex gap-2">
            <figure class="w-13 overflow-hidden border border-zinc-400 rounded-lg">
                <img src="{{ asset('assets/icons/placeholder.png') }}" class="w-full h-full object-cover" alt="placeholder">
            </figure>
            <div class="text-sm font-semibold text-start">
                {{auth()->user()->name}}
                <span class="text-zinc-400 text-[12px]"> {{auth()->user()->getRoleNames()->first()}}</span>
            </div>
        </div>
    </button>

    <div x-cloak x-show="isOpen" @click.outside="isOpen = false"
        class="absolute top-16 right-0 border border-zinc-300 shadow-lg bg-white w-50 rounded-lg p-2">
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Impostazioni') }}
            </flux:menu.item>
        </flux:menu.radio.group>

        <flux:menu.separator />

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                class="w-full cursor-pointer" data-test="logout-button">
                {{ __('Log Out') }}
            </flux:menu.item>
        </form>
    </div>
</div>