<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - PetFinder</title>
    <style>
        :root { --primary: #4f46e5; }
        body { font-family: system-ui, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: white; border-radius: 12px; padding: 2.5rem; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .logo { text-align: center; font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem; }
        .subtitle { text-align: center; color: #64748b; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155; }
        input { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s; box-sizing: border-box; }
        input:focus { outline: none; border-color: var(--primary); }
        .btn { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; }
        .btn:hover { background: #4338ca; }
        .error { background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 10px; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; }
        .link { text-align: center; margin-top: 1.5rem; }
        .link a { color: var(--primary); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo">PETFINDER</div>
        <p class="subtitle">Crea tu cuenta para comenzar</p>

        @if ($errors->any())
            <div class="error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Registrarse</button>
        </form>

        <div class="link">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
