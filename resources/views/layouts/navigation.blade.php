<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-gray-500">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg overflow-hidden z-50">
        <div class="py-2">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <div class="px-4 py-3 hover:bg-gray-100 border-b border-gray-100">
                    <p class="text-sm text-gray-800">
                        <strong>{{ $notification->data['requester_name'] }}</strong> 
                        {{ $notification->data['message'] }}
                    </p>
                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="px-4 py-3 text-sm text-gray-500">No tienes notificaciones nuevas.</p>
            @endforelse
        </div>
    </div>
</div>