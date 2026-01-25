<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="flex" style="gap: 12px; align-items: stretch; height: 100vh;">
        <div class="card mb-3" style="padding: 0; overflow: hidden; flex: 1 1 70%; min-width: 320px; height: 100%;">
            <div id="map" style="height: 100%; width: 100%; z-index: 1;"></div>
        </div>

        <div class="card" style="flex: 1 1 30%; min-width: 280px; height: 100%; overflow: auto; padding: 8px;">
            <div class="card-header" style="margin-bottom: 8px;">
                <h3 class="card-title">Annonces Récentes</h3>
                <a href="{{ route('animals.create') }}" class="btn">+ Nouvel Animal</a>
            </div>
            <div class="mt-3" style="margin-top: 6px;">
                {{ $animals->links('pagination::petfinder') }}
            </div>

            <div style="display: flex; flex-direction: column; gap: 6px;">
                @forelse($animals as $animal)
                    <details class="card" style="padding: 6px;">
                        <summary style="display: flex; align-items: center; justify-content: space-between; gap: 8px; cursor: pointer; list-style: none;">
                            <div class="flex" style="align-items:center; gap:8px;">
                                <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://ui-avatars.com/api/?name='.urlencode($animal->name).'&background=f1f5f9&color=64748b' }}" alt="{{ $animal->name }}" class="thumbnail">
                                <div>
                                    <strong>{{ $animal->name }}</strong>
                                    <div class="text-muted" style="font-size: 11px;">{{ $animal->city }}</div>
                                </div>
                            </div>
                            <span style="font-weight: bold; color: {{ $animal->status == 'Lost' ? '#d00' : '#060' }};">
                                {{ $animal->status == 'Lost' ? 'Perdu' : 'En Adoption' }}
                            </span>
                        </summary>
                        <div style="padding: 6px 0 0; border-top: 1px dashed var(--border); margin-top: 6px;">
                            <div class="flex" style="justify-content: space-between; gap: 8px; flex-wrap: wrap;">
                                <div>
                                    <div class="text-muted" style="font-size: 11px;">Espèce</div>
                                    <div>{{ $animal->species }}</div>
                                </div>
                                <div>
                                    <div class="text-muted" style="font-size: 11px;">Ville</div>
                                    <div>{{ $animal->city }}</div>
                                </div>
                                <div class="flex" style="align-items:center; gap:8px; margin-left: auto;">
                                    <a href="{{ route('animals.show', $animal) }}" class="btn">Voir Détails</a>
                                </div>
                            </div>
                        </div>
                    </details>
                @empty
                    <div style="padding: 12px; text-align: center; color: #555;">Aucun animal enregistré.</div>
                @endforelse
            </div>

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
                                {{ $animal->status == 'Lost' ? 'Perdu' : 'En Adoption' }}
                            </span><br>
                            <a href="{{ route('animals.show', $animal) }}" style="text-decoration: none; color: #4f46e5; font-weight: bold; display: inline-block; margin-top: 5px;">Voir fiche</a>
                        </div>
                    `);
            @endif
        @endforeach
    </script>
</x-app-layout>
