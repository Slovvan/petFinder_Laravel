<x-app-layout>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Mis Mascotas Publicadas</h2>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('notifications.index') }}" class="btn btn-secondary" style="position: relative;">
                    Solicitudes
                    @php
                        $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('animals.create') }}" class="btn">+ Publicar</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Ciudad</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $animal)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://ui-avatars.com/api/?name='.urlencode($animal->name).'&background=f1f5f9&color=64748b' }}" alt="{{ $animal->name }}" class="thumbnail">
                            <strong>{{ $animal->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $animal->status }}</td>
                    <td>{{ $animal->city }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('animals.edit', $animal) }}" style="color:var(--primary); margin-right:10px;">Editar</a>
                        <form action="{{ route('animals.destroy', $animal) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>