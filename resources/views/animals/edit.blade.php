<x-app-layout>
    <div class="card">
        <h2 class="card-title mb-3">Modifier les Informations de {{ $animal->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('animals.update', $animal) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="form-group">
                    <label>Nom de l'Animal *</label>
                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Espèce *</label>
                    <select name="species" required>
                        <option value="">Sélectionner</option>
                        <option value="dog" {{ old('species', $animal->species) == 'dog' ? 'selected' : '' }}>Chien</option>
                        <option value="cat" {{ old('species', $animal->species) == 'cat' ? 'selected' : '' }}>Chat</option>
                        <option value="bird" {{ old('species', $animal->species) == 'bird' ? 'selected' : '' }}>Oiseau</option>
                        <option value="other" {{ old('species', $animal->species) == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Statut *</label>
                    <select name="status" required>
                        <option value="">Sélectionner</option>
                        <option value="Lost" {{ old('status', $animal->status) == 'Lost' ? 'selected' : '' }}>Perdu</option>
                        <option value="In Adoption" {{ old('status', $animal->status) == 'In Adoption' ? 'selected' : '' }}>En Adoption</option>
                        <option value="Archived" {{ old('status', $animal->status) == 'Archived' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ville *</label>
                    <input type="text" name="city" value="{{ old('city', $animal->city) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description', $animal->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Photo (optionnel)</label>
                @if($animal->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$animal->image) }}" alt="Photo actuelle" class="image-preview" style="max-height: 160px;">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
                <p class="text-muted text-small mt-1">Télécharger une nouvelle photo remplace l'ancienne. Maximum 4 Mo.</p>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Latitude (optionnel)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $animal->latitude) }}" placeholder="Ex : 46.5">
                </div>

                <div class="form-group">
                    <label>Longitude (optionnel)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $animal->longitude) }}" placeholder="Ex : 2.5">
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <button type="submit" class="btn">Mettre à jour</button>
                <a href="{{ route('animals.mine') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <div class="card mt-3">
        <form method="POST" action="{{ route('animals.destroy', $animal) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width: 100%;">Supprimer l'Annonce</button>
        </form>
    </div>
</x-app-layout>
