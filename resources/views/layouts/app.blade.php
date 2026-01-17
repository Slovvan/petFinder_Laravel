<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetFinder</title>
    <link rel="stylesheet" href="{{ asset('css/petfinder.css') }}">
</head>
<body>
    <nav>
        <a href="{{ route('animals.index') }}" class="logo">PETFINDER</a>
        <div class="nav-links">
            <a href="{{ route('animals.index') }}">Explorar</a>
            @auth
                <a href="{{ route('animals.mine') }}">Mis Anuncios</a>
                <a href="{{ route('notifications.index') }}" style="position: relative;">
                    Solicitudes
                    @php
                        $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-profile">
                    @php $avatar = optional(auth()->user()->profile)->profile_photo; @endphp
                    <img src="{{ $avatar ? asset('storage/'.$avatar) : 'https://ui-avatars.com/api/?name=User&background=e2e8f0&color=64748b' }}" alt="Avatar" class="nav-avatar">
                    Perfil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-weight:bold;">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}">Entrar</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>