<x-app-layout>
    <div style="max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <h2 style="margin-top: 0;">Iniciar Sesión</h2>
        
        @if ($errors->any())
            <div style="color: #e53e3e; margin-bottom: 15px; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 5px;">Contraseña</label>
                <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;">
            </div>
            <button type="submit" style="width: 100%; background: #4f46e5; color: white; padding: 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Entrar
            </button>
        </form>
        <p style="margin-top: 15px; font-size: 0.9rem; text-align: center;">
            ¿No tienes cuenta? <a href="{{ route('register') }}" style="color: #4f46e5;">Regístrate</a>
        </p>
    </div>
</x-app-layout>