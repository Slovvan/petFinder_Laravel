<x-app-layout>
    <x-slot name="header">Registrar Nueva Mascota</x-slot>

    <div class="card">
        <h2 style="margin-bottom: 20px; font-size: 1.5rem;">Publicar Anuncio</h2>

        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 6px; padding: 12px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px; color: #dc2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('animals.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nombre de la Mascota *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Especie *</label>
                    <select name="species" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                        <option value="">Seleccionar...</option>
                        <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Perro</option>
                        <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                        <option value="bird" {{ old('species') == 'bird' ? 'selected' : '' }}>Pájaro</option>
                        <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Estado *</label>
                    <select name="status" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                        <option value="">Seleccionar...</option>
                        <option value="Lost" {{ old('status') == 'Lost' ? 'selected' : '' }}>Perdido</option>
                        <option value="In Adoption" {{ old('status') == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Ciudad *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Descripción</label>
                <textarea name="description" rows="4"
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Foto (opcional)</label>
                <input type="file" name="image" accept="image/*"
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #fff;">
                <p style="color: #94a3b8; margin-top: 6px; font-size: 0.9rem;">Se guardará en el disco público.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Latitud (opcional)</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude') }}"
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Longitud (opcional)</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude') }}"
                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn">Publicar Anuncio</button>
                <a href="{{ route('animals.index') }}" class="btn" style="background: #6b7280;">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
