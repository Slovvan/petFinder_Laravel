<x-app-layout>
    <x-slot name="header">Mon Profil</x-slot>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="card-title mb-3">Informations Personnelles</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <div class="form-group">
                <label>Biographie</label>
                <textarea name="bio" rows="3">{{ old('bio', optional(auth()->user()->profile)->bio) }}</textarea>
            </div>

            <div class="form-group">
                <label>Photo de Profil</label>
                @if(optional(auth()->user()->profile)->profile_photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.auth()->user()->profile->profile_photo) }}" alt="Avatar" class="thumbnail" style="width: 64px; height: 64px;">
                    </div>
                @endif
                <input type="file" name="profile_photo" accept="image/*">
                <p class="text-muted text-small mt-1">Stocké sur le disque public (max. 2 Mo).</p>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn">Enregistrer les Modifications</button>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>

        <hr class="divider">
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action ne peut pas être annulée.');">
            <p class="text-muted text-small">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
            </p>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer le Compte</button>
        </form>
    </div>
</x-app-layout>
