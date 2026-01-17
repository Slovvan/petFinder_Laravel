<x-app-layout>
    <div class="card">
        <h2 class="card-title mb-3">Editar Información de {{ $animal->name }}</h2>

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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Nombre de la Mascota *</label>
                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Especie *</label>
                    <select name="species" required>
                        <option value="">Selecciona</option>
                        <option value="dog" {{ old('species', $animal->species) == 'dog' ? 'selected' : '' }}>Perro</option>
                        <option value="cat" {{ old('species', $animal->species) == 'cat' ? 'selected' : '' }}>Gato</option>
                        <option value="bird" {{ old('species', $animal->species) == 'bird' ? 'selected' : '' }}>Pájaro</option>
                        <option value="other" {{ old('species', $animal->species) == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Estado *</label>
                    <select name="status" required>
                        <option value="">Selecciona</option>
                        <option value="Lost" {{ old('status', $animal->status) == 'Lost' ? 'selected' : '' }}>Perdido</option>
                        <option value="In Adoption" {{ old('status', $animal->status) == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                        <option value="Archived" {{ old('status', $animal->status) == 'Archived' ? 'selected' : '' }}>Archivado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ciudad *</label>
                    <input type="text" name="city" value="{{ old('city', $animal->city) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="description" rows="4">{{ old('description', $animal->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto (opcional)</label>
                @if($animal->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$animal->image) }}" alt="Foto actual" class="image-preview" style="max-height: 160px;">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
                <p class="text-muted mt-1" style="font-size: 0.9rem;">Subir una nueva foto reemplaza la anterior. Máximo 4MB.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Latitud (opcional)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $animal->latitude) }}" placeholder="Ej: 46.5">
                </div>

                <div class="form-group">
                    <label>Longitud (opcional)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $animal->longitude) }}" placeholder="Ej: 2.5">
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <button type="submit" class="btn">Actualizar</button>
                <a href="{{ route('animals.mine') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <div class="card mt-3">
        <form method="POST" action="{{ route('animals.destroy', $animal) }}" onsubmit="return confirm('¿Estás seguro de eliminar este anuncio?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width: 100%;">Eliminar Anuncio</button>
        </form>
    </div>
</x-app-layout>
