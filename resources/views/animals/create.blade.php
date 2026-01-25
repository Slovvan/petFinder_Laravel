<x-app-layout>
    <div class="card">
        <h2 class="card-title mb-3">Publier une Annonce</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('animals.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label>Nom de l'Animal *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Espèce *</label>
                    <select name="species" required>
                        <option value="">Sélectionner</option>
                        <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Chien</option>
                        <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Chat</option>
                        <option value="bird" {{ old('species') == 'bird' ? 'selected' : '' }}>Oiseau</option>
                        <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Statut *</label>
                    <select name="status" required>
                        <option value="">Sélectionner</option>
                        <option value="Lost" {{ old('status') == 'Lost' ? 'selected' : '' }}>Perdu</option>
                        <option value="In Adoption" {{ old('status') == 'In Adoption' ? 'selected' : '' }}>En Adoption</option>
                        <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ville *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Photo (optionnel)</label>
                <input type="file" name="image" accept="image/*">
                <p class="text-muted text-small mt-1">Formats : JPG, PNG, GIF. Maximum 4 Mo.</p>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Latitude (optionnel)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude') }}" placeholder="Ex : 46.5">
                </div>

                <div class="form-group">
                    <label>Longitude (optionnel)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude') }}" placeholder="Ex : 2.5">
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <button type="submit" class="btn">Publier</button>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</x-app-layout>
