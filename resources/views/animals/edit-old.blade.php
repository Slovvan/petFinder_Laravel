<x-app-layout>
    <x-slot name="header">Editar Anuncio</x-slot>

    <div class="card">
        <h2 style="margin-bottom: 20px; font-size: 1.5rem;">Editar Información de {{ $animal->name }}</h2>

        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 6px; padding: 12px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px; color: #dc2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('animals.update', $animal) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nombre de la Mascota *</label>
                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Especie *</label>
                    <select name="species" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                        <option value="">Seleccionar...</option>
                        <option value="dog" {{ old('species', $animal->species) == 'dog' ? 'selected' : '' }}>Perro</option>
                        <option value="cat" {{ old('species', $animal->species) == 'cat' ? 'selected' : '' }}>Gato</option>
                        <option value="bird" {{ old('species', $animal->species) == 'bird' ? 'selected' : '' }}>Pájaro</option>
                        <option value="other" {{ old('species', $animal->species) == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Estado *</label>
                    <select name="status" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                        <option value="">Seleccionar...</option>
                        <option value="Lost" {{ old('status', $animal->status) == 'Lost' ? 'selected' : '' }}>Perdido</option>
                        <option value="In Adoption" {{ old('status', $animal->status) == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Ciudad *</label>
                    <input type="text" name="city" value="{{ old('city', $animal->city) }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Descripción</label>
                <textarea name="description" rows="4"
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">{{ old('description', $animal->description) }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Foto (opcional)</label>
                @if($animal->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'.$animal->image) }}" alt="Foto actual" style="max-height: 160px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #fff;">
                <p style="color: #94a3b8; margin-top: 6px; font-size: 0.9rem;">Se guardará en el disco público. Subir una nueva foto reemplaza la anterior.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Latitud (opcional)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $animal->latitude) }}"
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Longitud (opcional)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $animal->longitude) }}"
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn">Guardar Cambios</button>
                <a href="{{ route('animals.mine') }}" class="btn" style="background: #6b7280;">Cancelar</a>
            </div>
        </form>

        <form method="POST" action="{{ route('animals.destroy', $animal) }}" style="margin-top: 16px;" onsubmit="return confirm('¿Estás seguro de eliminar este anuncio?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background: #dc2626; width: 100%;">Eliminar</button>
        </form>
    </div>
</x-app-layout>
