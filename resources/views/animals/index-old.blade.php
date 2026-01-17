<x-app-layout>
    <x-slot name="header">Panel de Control de Mascotas</x-slot>
    <x-slot name="header">Mapa de Avisos</x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Formulario de búsqueda con filtros -->
    <div class="card" style="margin-bottom: 20px;">
        <h3 style="margin-bottom: 15px;">Buscar Mascotas</h3>
        <form method="GET" action="{{ route('animals.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o descripción" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Especie</label>
                <select name="species" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <option value="">Todas</option>
                    <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Perro</option>
                    <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                    <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Pájaro</option>
                    <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Estado</label>
                <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <option value="">Todos</option>
                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Perdido</option>
                    <option value="In Adoption" {{ request('status') == 'In Adoption' ? 'selected' : '' }}>En Adopción</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Ciudad</label>
                <input type="text" name="city" value="{{ request('city') }}" placeholder="Ciudad" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            <div style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn" style="flex: 1;">Buscar</button>
                <a href="{{ route('animals.index') }}" class="btn" style="flex: 1; text-align: center; background: #6b7280;">Limpiar</a>
            </div>
        </form>
    </div>
    
    <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 30px;">
        <div id="map" style="height: 450px; width: 100%; z-index: 1;"></div>
    </div>

    <div style="margin-top: 20px;">
        <h2 style="font-size: 1.2rem; margin-bottom: 15px;">Listado Reciente</h2>
        </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0;">Listado Reciente</h3>
            <a href="{{ route('animals.create') }}" class="btn">+ Nueva Mascota</a>
        </div>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f3f4f6;">
                    <th style="padding:12px;">Mascota</th>
                    <th style="padding:12px;">Especie</th>
                    <th style="padding:12px;">Estado</th>
                    <th style="padding:12px;">Ciudad</th>
                    <th style="padding:12px; text-align:right;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding:12px; font-weight: bold;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://ui-avatars.com/api/?name='.urlencode($animal->name).'&background=f1f5f9&color=64748b' }}" alt="{{ $animal->name }}" class="thumbnail">
                            <span>{{ $animal->name }}</span>
                        </div>
                    </td>
                    <td style="padding:12px;">{{ $animal->species }}</td>
                    <td style="padding:12px;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; 
                            {{ $animal->status == 'Lost' ? 'background:#fee2e2; color:#dc2626;' : 'background:#dcfce7; color:#16a34a;' }}">
                            {{ $animal->status == 'Lost' ? 'Perdido' : 'En Adopción' }}
                        </span>
                    </td>
                    <td style="padding:12px;">{{ $animal->city }}</td>
                    <td style="padding:12px; text-align:right;">
                        <a href="{{ route('animals.show', $animal) }}" style="color:var(--primary); text-decoration: none; font-weight: bold;">Ver Detalles</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:30px; text-align:center; color:#9ca3af;">No hay mascotas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $animals->links() }}
        </div>
    </div>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 1. Inicializar el mapa (centrado en Francia, zoom para ver todo el país)
        var map = L.map('map').setView([46.5, 2.5], 6);

        // 2. Cargar la capa visual (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 3. Generar marcadores dinámicos desde PHP
        @foreach($animalsForMap as $animal)
            @if($animal->latitude && $animal->longitude)
                L.marker([{{ $animal->latitude }}, {{ $animal->longitude }}])
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center;">
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