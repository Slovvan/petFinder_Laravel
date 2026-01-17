<x-app-layout>
    <x-slot name="header">Panel de Control de Mascotas</x-slot>
    <x-slot name="header">Mapa de Avisos</x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
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
                    <td style="padding:12px; font-weight: bold;">{{ $animal->name }}</td>
                    <td style="padding:12px;">{{ $animal->species }}</td>
                    <td style="padding:12px;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; 
                            {{ $animal->status == 'Perdido' ? 'background:#fee2e2; color:#dc2626;' : 'background:#dcfce7; color:#16a34a;' }}">
                            {{ $animal->status }}
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
        // 1. Inicializar el mapa (centrado en Nancy por defecto)
        var map = L.map('map').setView([48.6919, 6.1828], 13);

        // 2. Cargar la capa visual (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 3. Generar marcadores dinámicos desde PHP
        @foreach($animals as $animal)
            @if($animal->latitude && $animal->longitude)
                L.marker([{{ $animal->latitude }}, {{ $animal->longitude }}])
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center;">
                            <strong style="font-size: 1rem;">{{ $animal->name }}</strong><br>
                            <span style="color: {{ $animal->status == 'Perdido' ? '#ef4444' : '#10b981' }}; font-weight: bold;">
                                {{ $animal->status }}
                            </span><br>
                            <a href="{{ route('animals.show', $animal) }}" style="text-decoration: none; color: #4f46e5; font-weight: bold; display: inline-block; margin-top: 5px;">Ver ficha</a>
                        </div>
                    `);
            @endif
        @endforeach
    </script>
</x-app-layout>