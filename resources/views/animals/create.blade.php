<x-app-layout>
    <div class="card">
        <h2 class="card-title mb-3">Publicar Anuncio</h2>

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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Nombre de la Mascota *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Especie *</label>
                    <select name="species" required>
                        <option value="">Selecciona</option>
                        <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Perro</option>
                        <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                        <option value="bird" {{ old('species') == 'bird' ? 'selected' : '' }}>Pájaro</option>
                        <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Estado *</label>
                    <select name="status" required>
                        <option value="">Selecciona</option>
                        <option value="Lost" {{ old('status') == 'Lost' ? 'selected' : '' }}>Perdido</option>
                        <option value="In Adoption" {{ old('status') == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                        <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archivado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ciudad *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto (opcional)</label>
                <input type="file" name="image" accept="image/*">
                <p class="text-muted mt-1" style="font-size: 0.9rem;">Formatos: JPG, PNG, GIF. Máximo 4MB.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Latitud (opcional)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude') }}" placeholder="Ej: 46.5">
                </div>

                <div class="form-group">
                    <label>Longitud (opcional)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude') }}" placeholder="Ej: 2.5">
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <button type="submit" class="btn">Publicar</button>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
