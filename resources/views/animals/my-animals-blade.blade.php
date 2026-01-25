<x-app-layout>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Mes Animaux Publiés</h2>
            <div class="flex gap-2">
                <a href="{{ route('notifications.index') }}" class="btn btn-secondary" style="position: relative;">
                    Demandes
                    @php
                        $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('animals.create') }}" class="btn">+ Publier</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Statut</th>
                    <th>Ville</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $animal)
                <tr>
                    <td>
                        <div class="flex" style="align-items:center; gap:10px;">
                            <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://ui-avatars.com/api/?name='.urlencode($animal->name).'&background=f1f5f9&color=64748b' }}" alt="{{ $animal->name }}" class="thumbnail">
                            <strong>{{ $animal->name }}</strong>
                        </div>
                    </td>
                    <td>
                        @if($animal->status === 'Lost')
                            Perdu
                        @elseif($animal->status === 'In Adoption')
                            En Adoption
                        @elseif($animal->status === 'Archived')
                            Archivé
                        @else
                            {{ $animal->status }}
                        @endif
                    </td>
                    <td>{{ $animal->city }}</td>
                    <td class="text-right">
                        <a href="{{ route('animals.edit', $animal) }}" class="btn btn-sm">Modifier</a>
                        <form action="{{ route('animals.destroy', $animal) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>