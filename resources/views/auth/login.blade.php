<x-app-layout>
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2 class="card-title mb-2">Se connecter</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Connexion</button>
        </form>
        <p class="text-muted text-center mt-2">
            Vous n'avez pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a>
        </p>
    </div>
</x-app-layout>