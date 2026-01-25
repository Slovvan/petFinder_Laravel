<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('animals.index') }}" class="font-bold text-xl text-indigo-600 tracking-tight">
                    PET<span class="text-gray-800">FINDER</span>
                </a>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('animals.index')" :active="request()->routeIs('animals.index')">
                        Explorer
                    </x-nav-link>
                    @auth
                    <x-nav-link :href="route('animals.create')" :active="request()->routeIs('animals.create')">
                        Publier une Annonce
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            @if(request()->routeIs('animals.index'))
                <div class="hidden sm:flex items-center flex-1 justify-center px-6">
                    <form action="{{ route('animals.index') }}" method="GET" class="w-full" style="max-width: 720px;">
                        <div class="flex items-end gap-2" style="flex-wrap: wrap;">
                            <div class="flex flex-col gap-1" style="flex: 1 1 180px; min-width: 160px;">
                                <label class="text-[11px] text-gray-500">Rechercher</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou description"
                                       class="rounded-md border-gray-300 bg-gray-50">
                            </div>
                            <div class="flex flex-col gap-1" style="flex: 1 1 140px; min-width: 120px;">
                                <label class="text-[11px] text-gray-500">Espèce</label>
                                <select name="species" class="rounded-md border-gray-300 bg-gray-50">
                                    <option value="">Toutes</option>
                                    <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Chien</option>
                                    <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Chat</option>
                                    <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Oiseau</option>
                                    <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1" style="flex: 1 1 140px; min-width: 120px;">
                                <label class="text-[11px] text-gray-500">Statut</label>
                                <select name="status" class="rounded-md border-gray-300 bg-gray-50">
                                    <option value="">Tous</option>
                                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Perdu</option>
                                    <option value="In Adoption" {{ request('status') == 'In Adoption' ? 'selected' : '' }}>En Adoption</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1" style="flex: 1 1 140px; min-width: 120px;">
                                <label class="text-[11px] text-gray-500">Ville</label>
                                <input type="text" name="city" value="{{ request('city') }}" placeholder="Ville"
                                       class="rounded-md border-gray-300 bg-gray-50">
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="btn" style="height: 36px;">Rechercher</button>
                                <a href="{{ route('animals.index') }}" class="btn btn-secondary" style="height: 36px;">Effacer</a>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    <div class="relative" x-data="{ nOpen: false }">
                        <button @click="nOpen = !nOpen" class="p-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <div class="relative">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-[10px] text-white items-center justify-center">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                        </button>
                        <div x-show="nOpen" @click.away="nOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border z-50 py-2">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="px-4 py-3 hover:bg-gray-50 border-b last:border-0">
                                    <p class="text-sm text-gray-700"><strong>{{ $notification->data['requester_name'] }}</strong> {{ $notification->data['message'] }}</p>
                                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500">Aucune notification.</div>
                            @endforelse
                        </div>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                <img src="{{ auth()->user()->profile->profile_photo ? asset('storage/'.auth()->user()->profile->profile_photo) : asset('default-avatar.png') }}" class="h-8 w-8 rounded-full object-cover mr-2 border">
                                <div>{{ Auth::user()->name }}</div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Mon Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Déconnexion</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Connexion</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Inscription</a>
                @endauth
            </div>
        </div>
    </div>
</nav>