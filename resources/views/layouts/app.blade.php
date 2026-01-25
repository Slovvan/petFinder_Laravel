<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetFinder</title>
    <link rel="stylesheet" href="{{ asset('css/petfinder.css') }}">
</head>
<body>
    <nav>
        <a href="{{ route('animals.index') }}" class="logo">PETFINDER</a>
        <form method="GET" action="{{ route('animals.index') }}" class="nav-search">
            <div class="nav-search-field" style="min-width: 180px;">
                <label>Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou description">
            </div>
            <div class="nav-search-field">
                <label>Espèce</label>
                <select name="species">
                    <option value="">Toutes</option>
                    <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Chien</option>
                    <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Chat</option>
                    <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Oiseau</option>
                    <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>
            <div class="nav-search-field">
                <label>Statut</label>
                <select name="status">
                    <option value="">Tous</option>
                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Perdu</option>
                    <option value="In Adoption" {{ request('status') == 'In Adoption' ? 'selected' : '' }}>En Adoption</option>
                </select>
            </div>
            <div class="nav-search-field">
                <label>Ville</label>
                <input type="text" name="city" value="{{ request('city') }}" placeholder="Ville">
            </div>
            <div class="nav-search-actions">
                <button type="submit" class="btn">Rechercher</button>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary">Effacer</a>
            </div>
        </form>
        <div class="nav-links">
            <a href="{{ route('animals.index') }}">Explorer</a>
            @auth
                <a href="{{ route('animals.mine') }}">Mes Annonces</a>
                <div class="nav-notifications-wrap">
                    <button type="button" id="nav-notifications-toggle" class="nav-notifications" aria-label="Notifications">
                        <svg class="nav-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span>Demandes</span>
                        @php
                            $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                            $unreadList = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                        @endphp
                        <span id="nav-notification-badge" class="notification-badge" style="display: {{ $unreadCount > 0 ? 'flex' : 'none' }};">
                            {{ $unreadCount }}
                        </span>
                    </button>
                    <div id="nav-notifications-panel" class="nav-notifications-panel" style="display: none;">
                        <div class="nav-notifications-header">Demandes récentes</div>
                        <div id="nav-notifications-list" class="nav-notifications-list">
                            @if($unreadList->isEmpty())
                                <div class="nav-notifications-empty">Aucune notification.</div>
                            @else
                                @foreach($unreadList as $notification)
                                    <a class="nav-notifications-item" href="{{ $notification->data['animal_url'] ?? '#' }}">
                                        <div><strong>{{ $notification->data['animal_name'] ?? 'Animal' }}</strong> — {{ $notification->data['requester_name'] ?? 'Utilisateur' }}</div>
                                        <div class="text-muted text-small">{{ $notification->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                        <div class="nav-notifications-footer">
                            <a href="{{ route('notifications.index') }}">Voir toutes</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="nav-profile">
                    @php $avatar = optional(auth()->user()->profile)->profile_photo; @endphp
                    <img src="{{ $avatar ? asset('storage/'.$avatar) : 'https://ui-avatars.com/api/?name=User&background=e2e8f0&color=64748b' }}" alt="Avatar" class="nav-avatar">
                    Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}">Connexion</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        {{ $slot }}
    </div>
    @auth
        <script>
            (function () {
                const badge = document.getElementById('nav-notification-badge');
                const panel = document.getElementById('nav-notifications-panel');
                const list = document.getElementById('nav-notifications-list');
                const toggle = document.getElementById('nav-notifications-toggle');
                let lastCount = Number(badge?.textContent || 0);

                const renderList = (items) => {
                    if (!list) return;
                    if (!items.length) {
                        list.innerHTML = '<div class="nav-notifications-empty">Aucune notification.</div>';
                        return;
                    }
                    list.innerHTML = items.map(item => (
                        `<a class="nav-notifications-item" href="${item.animal_url}">
                            <div><strong>${item.animal_name}</strong> — ${item.requester_name}</div>
                            <div class="text-muted text-small">${item.created_at}</div>
                        </a>`
                    )).join('');
                };

                const poll = async () => {
                    try {
                        const res = await fetch("{{ route('notifications.unread-count') }}", { headers: { 'Accept': 'application/json' } });
                        if (!res.ok) return;
                        const data = await res.json();
                        const count = Number(data.count || 0);
                        if (badge) {
                            badge.textContent = count;
                            badge.style.display = count > 0 ? 'flex' : 'none';
                            if (count > lastCount) {
                                badge.classList.remove('notification-pop');
                                void badge.offsetWidth;
                                badge.classList.add('notification-pop');
                                if (panel) {
                                    panel.style.display = 'block';
                                }
                            }
                        }
                        if (count !== lastCount) {
                            const listRes = await fetch("{{ route('notifications.unread') }}", { headers: { 'Accept': 'application/json' } });
                            if (listRes.ok) {
                                const listData = await listRes.json();
                                renderList(listData.notifications || []);
                            }
                        }
                        lastCount = count;
                    } catch (e) {
                        // ignore
                    }
                };

                if (toggle && panel) {
                    toggle.addEventListener('click', () => {
                        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                    });
                    document.addEventListener('click', (e) => {
                        if (!panel.contains(e.target) && !toggle.contains(e.target)) {
                            panel.style.display = 'none';
                        }
                    });
                }

                poll();
                setInterval(poll, 10000);
            })();
        </script>
    @endauth
</body>
</html>