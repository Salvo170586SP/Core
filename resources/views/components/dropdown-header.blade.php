<div x-data="{isOpen: false }" class="relative">
    <button @click="isOpen = !isOpen"
        class="w-50 bg-white dark:bg-zinc-800 hover:shadow focus:shadow border dark:border-zinc-700 border-gray-300  rounded-lg p-2 cursor-pointer ">
        <div class="flex gap-2">
            <figure class="w-13 overflow-hidden border border-zinc-400 dark:border-zinc-600 rounded-lg">
                <img src="{{ asset('assets/icons/placeholder.png') }}" class="w-full h-full object-cover dark:invert-90"  alt="placeholder">
            </figure>
            <div class="text-sm font-semibold text-start">
                {{auth()->user()->name}}
                <div class="text-zinc-400 text-[12px] capitalize"> {{auth()->user()->getRoleNames()->first()}}</div>
            </div>
        </div>
    </button>

    <div x-cloak x-show="isOpen" @click.outside="isOpen = false"
        class="absolute top-18 right-0 border border-zinc-300 dark:border-zinc-700 shadow-lg bg-white dark:bg-zinc-800 w-50 rounded-lg p-2">
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