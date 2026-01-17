<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="card mb-3">
        <h3 class="card-title">Buscar Mascotas</h3>
        <form method="GET" action="{{ route('animals.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o descripción">
            </div>
            <div class="form-group">
                <label>Especie</label>
                <select name="species">
                    <option value="">Todas</option>
                    <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Perro</option>
                    <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                    <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Pájaro</option>
                    <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select name="status">
                    <option value="">Todos</option>
                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Perdido</option>
                    <option value="In Adoption" {{ request('status') == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="city" value="{{ request('city') }}" placeholder="Ciudad">
            </div>
            <div style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn" style="flex: 1;">Buscar</button>
                <a href="{{ route('animals.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">Limpiar</a>
            </div>
        </form>
    </div>
    
    <div class="card mb-3" style="padding: 0; overflow: hidden;">
        <div id="map" style="height: 450px; width: 100%; z-index: 1;"></div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado Reciente</h3>
            <a href="{{ route('animals.create') }}" class="btn">+ Nueva Mascota</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Especie</th>
                    <th>Estado</th>
                    <th>Ciudad</th>
                    <th style="text-align:right;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                <tr>
                    <td>
                        <div class="flex" style="align-items:center; gap:10px;">
                            <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://ui-avatars.com/api/?name='.urlencode($animal->name).'&background=f1f5f9&color=64748b' }}" alt="{{ $animal->name }}" class="thumbnail">
                            <strong>{{ $animal->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $animal->species }}</td>
                    <td>
                        <span class="badge badge-{{ $animal->status == 'Lost' ? 'danger' : 'success' }}">
                            {{ $animal->status == 'Lost' ? 'Perdido' : 'En Adopción' }}
                        </span>
                    </td>
                    <td>{{ $animal->city }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('animals.show', $animal) }}" style="color:var(--primary); text-decoration: none; font-weight: 600;">Ver Detalles</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted" style="padding:30px;">No hay mascotas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $animals->links('pagination::petfinder') }}
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([46.5, 2.5], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @foreach($animals as $animal)
            @if($animal->latitude && $animal->longitude)
                L.marker([{{ $animal->latitude }}, {{ $animal->longitude }}])
                    .addTo(map)
                    .bindPopup(`
                        <div class="text-center">
                            <strong style="font-size: 1rem;">{{ $animal->name }}</strong><br>
                            <span style="color: {{ $animal->status == 'Lost' ? '#ef4444' : '#10b981' }}; font-weight: bold;">
                                {{ $animal->status == 'Lost' ? 'Perdido' : 'En Adopción' }}
                            </span><br>
                            <a href="{{ route('animals.show', $animal) }}" style="text-decoration: none; color: #4f46e5; font-weight: bold; display: inline-block; margin-top: 5px;">Ver ficha</a>
                        </div>
                    `);
            @endif
        @endforeach
    </script>
</x-app-layout>
