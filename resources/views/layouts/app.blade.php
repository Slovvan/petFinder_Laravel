<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetFinder</title>
    <style>
        :root { --primary: #4f46e5; --bg: #f8fafc; --text: #1e293b; }
        body { font-family: system-ui, sans-serif; background: var(--bg); color: var(--text); margin: 0; }
        nav { background: white; border-bottom: 2px solid #e2e8f0; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; sticky; top: 0; z-index: 100; }
        .logo { font-weight: 800; color: var(--primary); text-decoration: none; font-size: 1.5rem; }
        .nav-links a { margin-left: 20px; text-decoration: none; color: #64748b; font-weight: 600; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; background: #f1f5f9; border-bottom: 2px solid #e2e8f0; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('animals.index') }}" class="logo">PETFINDER</a>
        <div class="nav-links">
            <a href="{{ route('animals.index') }}">Explorar</a>
            @auth
                <a href="{{ route('animals.mine') }}">Mis Anuncios</a>
                <a href="{{ route('profile.edit') }}">Perfil</a>
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