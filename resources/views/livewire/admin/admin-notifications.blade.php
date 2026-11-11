<div>
    <div class="relative" x-data="{isOpen : false}" @click.outside="isOpen = false">
        <flux:button variant="ghost" class="relative" @click="isOpen = !isOpen" title="notifiche">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            @if($unreadCount > 0)
            <span
                class="absolute top-1 right-3 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                {{ $unreadCount }}
            </span>
            @endif
        </flux:button>

        <div x-cloak x-show="isOpen == true"
            class="absolute z-50 top-9 right-0 mt-2 bg-white shadow-lg rounded-lg p-4 w-80 h-60 overflow-y-auto border">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-sm  text-center">Notifiche</h3>

                <flux:button wire:click="activeNotification" size="xs" variant="filled" title="silenzia">
                    @if(auth()->user()->notification_preferences == true)
                    <svg  xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                    </svg>
                    @else
                    <svg  xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.143 17.082a24.248 24.248 0 0 0 3.844.148m-3.844-.148a23.856 23.856 0 0 1-5.455-1.31 8.964 8.964 0 0 0 2.3-5.542m3.155 6.852a3 3 0 0 0 5.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 0 0 3.536-1.003A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                    </svg>
                    @endif

                </flux:button>
            </div>



            @forelse($notifications as $notification)
            <div class="p-2 rounded-xl my-1 border {{ $notification->read_at ? 'bg-gray-50' : 'bg-blue-50' }}"
                wire:click="markAsRead('{{ $notification->id }}')">
                <p class="text-sm">{{ $notification->data['message'] }}</p>
                <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                <div class="text-end">
                    <flux:button icon="trash" variant="danger" size="xs"
                        wire:click.stop="deleteNotification('{{ $notification->id }}')" />
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-sm text-center italic">Nessuna notifica</p>
            @endforelse

        </div>
    </div>
</div>